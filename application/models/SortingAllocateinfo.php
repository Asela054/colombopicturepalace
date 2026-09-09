<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SortingAllocateinfo extends CI_Model
{
    /**
     * List of materials that currently have available stock (qty > 0).
     * No GRN filtering — this is a straight material list.
     */
    public function GetMaterials()
    {
        $this->db->distinct();
        $this->db->select('m.idtbl_print_material_info, m.materialname');
        $this->db->from('tbl_print_material_info m');
        $this->db->join('tbl_print_stock s', 's.tbl_print_material_info_idtbl_print_material_info = m.idtbl_print_material_info');
        $this->db->where('m.status', 1);
        $this->db->where('s.status', 1);
        $this->db->where('s.qty >', 0);
        $this->db->order_by('m.materialname', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Available qty for a material = sum of qty across every stock row
     * for that material (no batch/rack breakdown any more).
     */
    public function GetAvailableQty($material_id)
    {
        $this->db->select('SUM(qty) as available_qty');
        $this->db->from('tbl_print_stock');
        $this->db->where('tbl_print_material_info_idtbl_print_material_info', $material_id);
        $this->db->where('status', 1);
        $this->db->where('qty >', 0);
        $row = $this->db->get()->row_array();
        return $row && $row['available_qty'] !== null ? (float)$row['available_qty'] : 0;
    }

    public function SaveAllocation()
    {
        $this->db->trans_begin();

        $user_id = $_SESSION['userid'];
        $insert_datetime = date('Y-m-d H:i:s');

        $items = $this->input->post('items');

        if (!$items || !is_array($items)) {
            return [
                'success' => false,
                'message' => 'No items received in POST'
            ];
        }

        foreach ($items as $item) {

            if (empty($item['material_id']) || empty($item['qty'])) {
                $this->db->trans_rollback();
                return ['success' => false, 'message' => 'Missing material or quantity'];
            }

            // Guard against over-allocating past what's currently available
            $available = $this->GetAvailableQty($item['material_id']);
            if ($item['qty'] > $available) {
                $this->db->trans_rollback();
                return ['success' => false, 'message' => 'Quantity exceeds available stock for this material'];
            }

            $data = [
                'material_id' => $item['material_id'],
                'site_location_id' => $item['site_location_id'] ?? null,
                'qty' => $item['qty'],
                'status' => 1,
                'remarks' => $item['remarks'] ?? null,
                'insertdatetime' => $insert_datetime,
                'tbl_user_idtbl_user' => $user_id
            ];

            $this->db->insert('tbl_allocation', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return ['success' => false, 'message' => 'Failed to save allocation'];
        }

        $this->db->trans_commit();
        return ['success' => true, 'message' => 'Allocation saved successfully'];
    }

    public function GetAllocations($status = 1)
    {
        $this->db->select('a.*, m.materialname, l.location as site_location');
        $this->db->from('tbl_allocation a');
        $this->db->join('tbl_print_material_info m', 'm.idtbl_print_material_info = a.material_id');
        $this->db->join('tbl_location l', 'l.idtbl_location = a.site_location_id', 'left');
        $this->db->where('a.status', $status);
        $this->db->order_by('a.insertdatetime', 'DESC');

        return $this->db->get()->result_array();
    }

    public function DeleteAllocation($allocation_id)
    {
        $this->db->trans_begin();

        $this->db->where('idtbl_allocation', $allocation_id);
        $this->db->where('status', 1);
        $this->db->delete('tbl_allocation');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Failed to delete allocation');
        } else {
            $this->db->trans_commit();
            return array('success' => true, 'message' => 'Allocation deleted successfully');
        }
    }

    public function UpdateAllocation($allocation_id)
    {
        $this->db->trans_begin();

        $user_id = $_SESSION['userid'];
        $update_datetime = date('Y-m-d H:i:s');

        $data = array(
            'qty' => $this->input->post('qty'),
            'remarks' => $this->input->post('remarks'),
            'updatedatetime' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        );

        $this->db->where('idtbl_allocation', $allocation_id);
        $this->db->where('status', 1);
        $this->db->update('tbl_allocation', $data);

        $history_data = array(
            'allocation_id' => $allocation_id,
            'action' => 'Edit',
            'remarks' => 'Allocation updated: Qty=' . $this->input->post('qty'),
            'action_date' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        );
        $this->db->insert('tbl_allocation_history', $history_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Failed to update allocation');
        } else {
            $this->db->trans_commit();
            return array('success' => true, 'message' => 'Allocation updated successfully');
        }
    }

    /**
     * Approve = decrement stock for the material, FIFO across
     * every tbl_print_stock row for that material (oldest first),
     * since there's no single batch_id to point at any more.
     */
    public function ApproveAllocation($allocation_id)
    {
        $this->db->trans_begin();

        $user_id = $_SESSION['userid'];
        $update_datetime = date('Y-m-d H:i:s');

        $this->db->select('*');
        $this->db->from('tbl_allocation');
        $this->db->where('idtbl_allocation', $allocation_id);
        $allocation = $this->db->get()->row_array();

        if (!$allocation || $allocation['status'] != 1) {
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Allocation not found or not in pending status');
        }

        $remaining = (float)$allocation['qty'];

        // Total available check
        $available = $this->GetAvailableQty($allocation['material_id']);
        if ($remaining > $available) {
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Insufficient quantity in stock');
        }

        // FIFO consume across stock rows for this material
        $this->db->select('idtbl_print_stock, qty');
        $this->db->from('tbl_print_stock');
        $this->db->where('tbl_print_material_info_idtbl_print_material_info', $allocation['material_id']);
        $this->db->where('status', 1);
        $this->db->where('qty >', 0);
        $this->db->order_by('insertdatetime', 'ASC');
        $stock_rows = $this->db->get()->result_array();

        foreach ($stock_rows as $row) {
            if ($remaining <= 0) break;

            $take = min($remaining, (float)$row['qty']);
            $new_qty = (float)$row['qty'] - $take;

            $this->db->where('idtbl_print_stock', $row['idtbl_print_stock']);
            $this->db->update('tbl_print_stock', array(
                'qty' => $new_qty,
                'updatedatetime' => $update_datetime
            ));

            $remaining -= $take;
        }

        if ($remaining > 0) {
            // Shouldn't happen given the availability check above, but guard anyway
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Stock changed during approval, please retry');
        }

        $this->db->where('idtbl_allocation', $allocation_id);
        $this->db->update('tbl_allocation', array(
            'status' => 2,
            'updatedatetime' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        ));

        $history_data = array(
            'allocation_id' => $allocation_id,
            'action' => 'Approve',
            'remarks' => 'Allocation approved, stock updated',
            'action_date' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        );
        $this->db->insert('tbl_allocation_history', $history_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Failed to approve allocation');
        } else {
            $this->db->trans_commit();
            return array('success' => true, 'message' => 'Allocation approved successfully');
        }
    }

    public function RejectAllocation($allocation_id)
    {
        $this->db->trans_begin();

        $user_id = $_SESSION['userid'];
        $update_datetime = date('Y-m-d H:i:s');

        $this->db->where('idtbl_allocation', $allocation_id);
        $this->db->update('tbl_allocation', array(
            'status' => 3,
            'updatedatetime' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        ));

        $history_data = array(
            'allocation_id' => $allocation_id,
            'action' => 'Reject',
            'remarks' => $this->input->post('reject_reason') ?: 'Allocation rejected',
            'action_date' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        );
        $this->db->insert('tbl_allocation_history', $history_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Failed to reject allocation');
        } else {
            $this->db->trans_commit();
            return array('success' => true, 'message' => 'Allocation rejected successfully');
        }
    }

    public function GetAllocationDetails($allocation_id)
    {
        $this->db->select('
            a.*,
            m.materialname,
            l.location AS site_location_name
        ');
        $this->db->from('tbl_allocation a');
        $this->db->join('tbl_print_material_info m', 'm.idtbl_print_material_info = a.material_id', 'left');
        $this->db->join('tbl_location l', 'l.idtbl_location = a.site_location_id', 'left');
        $this->db->where('a.idtbl_allocation', $allocation_id);
        $this->db->where('a.status', 1);

        return $this->db->get()->row_array();
    }

    public function UpdateSortingComplete($allocation_id)
    {
        $this->db->trans_begin();

        $user_id = $_SESSION['userid'];
        $update_datetime = date('Y-m-d H:i:s');

        $this->db->select('sorting_complete');
        $this->db->from('tbl_allocation');
        $this->db->where('idtbl_allocation', $allocation_id);
        $current = $this->db->get()->row_array();

        $new_status = ($current['sorting_complete'] == 0) ? 1 : 0;

        $data = array(
            'sorting_complete' => $new_status,
            'updatedatetime' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        );

        $this->db->where('idtbl_allocation', $allocation_id);
        $this->db->update('tbl_allocation', $data);

        $action = ($new_status == 1) ? 'Sorting Complete' : 'Sorting Incomplete';
        $history_data = array(
            'allocation_id' => $allocation_id,
            'action' => 'Sorting Status',
            'remarks' => $action . ' updated',
            'action_date' => $update_datetime,
            'tbl_user_idtbl_user' => $user_id
        );
        $this->db->insert('tbl_allocation_history', $history_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('success' => false, 'message' => 'Failed to update sorting status');
        } else {
            $this->db->trans_commit();
            return array('success' => true, 'message' => 'Sorting status updated successfully', 'new_status' => $new_status);
        }
    }
}
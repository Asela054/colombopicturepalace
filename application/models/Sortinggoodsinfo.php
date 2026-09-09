<?php
class Sortinggoodsinfo extends CI_Model
{

    public function GetSiteLocations()
    {
        $this->db->select('idtbl_location,location as  location_name');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);
        $this->db->order_by('location', 'asc');

        return $this->db->get()->result_array();
    }

    /**
     * tbl_allocation no longer has grn_id / batch_id / batch_number / rack_id,
     * so the GRN join, batch column, and rack join are dropped. Only
     * material + site location remain on the allocation.
     */
    public function GetActiveAllocations()
    {
        $this->db->select('
        a.idtbl_allocation,
        a.material_id,
        a.site_location_id,
        rm.materialname AS material_name,
        a.qty,
        l.location AS site_location
    ');

        $this->db->from('tbl_allocation a');

        $this->db->join('tbl_print_material_info rm', 'rm.idtbl_print_material_info = a.material_id');
        $this->db->join('tbl_location l', 'l.idtbl_location = a.site_location_id', 'left');

        $this->db->where('a.status', 2);
        $this->db->where('a.sorting_complete', 0);

        $this->db->order_by('a.allocation_date', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetRawMaterials()
    {
        $this->db->select('idtbl_print_material_info AS idtbl_row_material, materialname AS material_name');
        $this->db->from('tbl_print_material_info');
        $this->db->where('status', 1);
        $this->db->order_by('materialname', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function GetNextJobCardNo()
    {
        $this->db->select('job_card_no');
        $this->db->from('tbl_sorting_goods');
        $this->db->order_by('idtbl_sorting_goods', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $last_record = $query->row();
            $last_job_card = $last_record->job_card_no;

            $number = (int) substr($last_job_card, 5);
            $next_number = $number + 1;

            return 'SORT-' . str_pad($next_number, 3, '0', STR_PAD_LEFT);
        } else {
            return 'SORT-001';
        }
    }

    /**
     * No more batch_number on tbl_allocation — tbl_sorting_details.batch_no
     * is simply left null now (there's no batch identity to carry through).
     */
    public function ProcessSorting()
    {
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $sorting_date = $this->input->post('sorting_date') . ' ' . date('H:i:s');
        $allocation_id = $this->input->post('allocation_id');
        $site_location_id = $this->input->post('site_location');
        $job_card_no = $this->input->post('job_card_no');
        $items = $this->input->post('items');

        $allocation = $this->db->get_where(
            'tbl_allocation',
            array('idtbl_allocation' => $allocation_id)
        )->row_array();

        if (!$allocation) {
            return array('status' => false, 'message' => 'Invalid allocation selected');
        }

        $header_data = array(
            'sorting_date' => $sorting_date,
            'allocation_id' => $allocation_id,
            'site_location_id' => $site_location_id,
            'job_card_no' => $job_card_no,
            'status' => 2,
            'created_by' => $userID,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_sorting_goods', $header_data);
        $sorting_id = $this->db->insert_id();

        foreach ($items as $item) {
            $detail_data = array(
                'sorting_id' => $sorting_id,
                'allocation_id' => $allocation_id,
                'site_location_id' => $site_location_id,
                'allocation_material_id' => $allocation['material_id'],
                'sorted_material_id' => $item['material_id'],
                'quantity' => $item['quantity'],
                'batch_no' => null,
                'remark' => $item['remark'],
                'status' => 2,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_sorting_details', $detail_data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Error saving sorting', 'type' => 'danger');
        } else {
            $this->db->trans_commit();
            return array('type' => 'success', 'status' => true, 'message' => 'Sorting saved successfully.', 'sorting_id' => $sorting_id);
        }
    }

    public function GetSortingRecords()
    {
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];
        $order_column = $this->input->post('order')[0]['column'];
        $order_dir = $this->input->post('order')[0]['dir'];

        $this->db->select('sg.idtbl_sorting_goods as id, 
                          sg.sorting_date, 
                          sg.job_card_no,
                          CONCAT("ALLOC-", sg.allocation_id) as allocation_text,
                          COUNT(sd.idtbl_sorting_details) as total_items,
                          sg.status,
                          u.username as created_by');
        $this->db->from('tbl_sorting_goods sg');
        $this->db->join('tbl_sorting_details sd', 'sd.sorting_id = sg.idtbl_sorting_goods', 'left');
        $this->db->join('tbl_user u', 'u.idtbl_user = sg.created_by', 'left');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('sg.job_card_no', $search);
            $this->db->or_like('u.username', $search);
            $this->db->or_like('sg.sorting_date', $search);
            $this->db->group_end();
        }

        $this->db->group_by('sg.idtbl_sorting_goods');

        $columns = array(
            'sg.idtbl_sorting_goods',
            'sg.sorting_date',
            'allocation_text',
            'total_items',
            'sg.status',
            'u.username'
        );
        $this->db->order_by($columns[$order_column], $order_dir);

        $total_query = $this->db->get_compiled_select();
        $total_result = $this->db->query($total_query);
        $total_records = $total_result->num_rows();

        $this->db->limit($length, $start);
        $query = $this->db->get();
        $data = $query->result_array();

        return array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => $total_records,
            'recordsFiltered' => $total_records,
            'data' => $data
        );
    }

    /**
     * GRN / rack joins on tbl_allocation dropped (columns no longer exist).
     * Only material + input qty + allocation's site location remain.
     */
    public function GetSortingDetails($sorting_id)
    {
        $this->db->select('sg.*, 
            CONCAT("ALLOC-", sg.allocation_id) as allocation_text,
            a.material_id as input_material_id,
            rm.materialname as input_material,
            a.qty as input_qty,
            loc.location as location_name,
            u.username as created_by,
            l.location as site_location_name'
        );
        $this->db->from('tbl_sorting_goods sg');
        $this->db->join('tbl_allocation a', 'a.idtbl_allocation = sg.allocation_id');
        $this->db->join('tbl_print_material_info rm', 'rm.idtbl_print_material_info = a.material_id');
        $this->db->join('tbl_location loc', 'loc.idtbl_location = a.site_location_id', 'left');
        $this->db->join('tbl_user u', 'u.idtbl_user = sg.created_by', 'left');
        $this->db->join('tbl_location l', 'l.idtbl_location = sg.site_location_id', 'left');
        $this->db->where('sg.idtbl_sorting_goods', $sorting_id);
        $header_query = $this->db->get();
        $header = $header_query->row_array();

        $this->db->select('sd.*, rm.materialname as sorted_material_name');
        $this->db->from('tbl_sorting_details sd');
        $this->db->join('tbl_print_material_info rm', 'rm.idtbl_print_material_info = sd.sorted_material_id');
        $this->db->where('sd.sorting_id', $sorting_id);
        $details_query = $this->db->get();
        $details = $details_query->result_array();

        return array(
            'header' => $header,
            'details' => $details
        );
    }

    public function GetSortingForEdit($sorting_id)
    {
        $this->db->select('sg.*, 
            a.material_id as input_material_id,
            rm.materialname as input_material,
            a.qty as input_qty,
            loc.location as location_name,
            l.idtbl_location as site_location_id,
            l.location as site_location_name'
        );
        $this->db->from('tbl_sorting_goods sg');
        $this->db->join('tbl_allocation a', 'a.idtbl_allocation = sg.allocation_id', 'left');
        $this->db->join('tbl_print_material_info rm', 'rm.idtbl_print_material_info = a.material_id', 'left');
        $this->db->join('tbl_location loc', 'loc.idtbl_location = a.site_location_id', 'left');
        $this->db->join('tbl_location l', 'l.idtbl_location = sg.site_location_id', 'left');
        $this->db->where('sg.idtbl_sorting_goods', $sorting_id);
        $this->db->where('sg.status', 2);
        $header_query = $this->db->get();
        $header = $header_query->row_array();

        if (!$header) {
            return array('status' => false, 'message' => 'Sorting not found or cannot be edited');
        }

        $this->db->select('sd.*, rm.materialname as sorted_material_name');
        $this->db->from('tbl_sorting_details sd');
        $this->db->join('tbl_print_material_info rm', 'rm.idtbl_print_material_info = sd.sorted_material_id');
        $this->db->where('sd.sorting_id', $sorting_id);
        $items_query = $this->db->get();
        $items = $items_query->result_array();

        return array(
            'status' => true,
            'header' => $header,
            'items' => $items
        );
    }

    /**
     * Batch number no longer comes from tbl_allocation — sd.batch_no
     * (already null now since ProcessSorting stopped setting it) is used
     * directly instead of joining tbl_allocation for a.batch_number.
     */
    public function ApproveSorting($sorting_id)
    {
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $approval_date = date('Y-m-d H:i:s');

        $this->db->set('status', 1);
        $this->db->set('approved_by', $userID);
        $this->db->set('approved_at', $approval_date);
        $this->db->where('idtbl_sorting_goods', $sorting_id);
        $this->db->update('tbl_sorting_goods');

        $this->db->set('status', 1);
        $this->db->where('sorting_id', $sorting_id);
        $this->db->update('tbl_sorting_details');

        $this->db->select('sd.*');
        $this->db->from('tbl_sorting_details sd');
        $this->db->where('sd.sorting_id', $sorting_id);
        $query = $this->db->get();
        $sorting_items = $query->result_array();

        foreach ($sorting_items as $item) {
            $material_id = $item['sorted_material_id'];
            $quantity = $item['quantity'];
            $site_location = $item['site_location_id'];
            $batch_no = $item['batch_no']; // always null now, kept for schema compatibility

            $this->db->where('tbl_print_material_info_idtbl_print_material_info', $material_id);
            $this->db->where('location', $site_location);
            $stock_query = $this->db->get('tbl_print_stock');

            if ($stock_query->num_rows() > 0) {
                $existing_stock = $stock_query->row();
                $new_qty = $existing_stock->qty + $quantity;

                $this->db->set('qty', $new_qty);
                $this->db->set('updatedatetime', $approval_date);
                $this->db->where('idtbl_print_stock', $existing_stock->idtbl_print_stock);
                $this->db->update('tbl_print_stock');
            } else {
                $stock_data = array(
                    'batchno' => $batch_no ?: ('SORT-' . $sorting_id),
                    'grndate' => date('Y-m-d'),
                    'supplier_id' => 0,
                    'location' => $site_location,
                    'qty' => $quantity,
                    'measure_type_id' => 0,
                    'unitprice' => 0,
                    'saleprice' => 0,
                    'total' => 0,
                    'status' => 1,
                    'insertdatetime' => $approval_date,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_print_material_info_idtbl_print_material_info' => $material_id,
                    'tbl_company_idtbl_company' => 1,
                    'tbl_company_branch_idtbl_company_branch' => 1                );
                $this->db->insert('tbl_print_stock', $stock_data);
            }
        }

        $sorting_details = $this->db->get_where(
            'tbl_sorting_goods',
            array('idtbl_sorting_goods' => $sorting_id)
        )->row_array();

        if ($sorting_details) {
            $this->db->set('sorting_complete', 1);
            $this->db->where('idtbl_allocation', $sorting_details['allocation_id']);
            $this->db->update('tbl_allocation');
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Error approving sorting', 'type' => 'danger');
        } else {
            $this->db->trans_commit();
            return array('status' => true, 'message' => 'Sorting approved and inventory updated successfully', 'type' => 'success');
        }
    }

    public function RejectSorting($sorting_id)
    {
        $this->db->trans_begin();

        $this->db->set('status', 3);
        $this->db->where('idtbl_sorting_goods', $sorting_id);
        $this->db->update('tbl_sorting_goods');

        $this->db->set('status', 3);
        $this->db->where('sorting_id', $sorting_id);
        $this->db->update('tbl_sorting_details');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Error rejecting sorting');
        } else {
            $this->db->trans_commit();
            return array('status' => true, 'message' => 'Sorting rejected successfully');
        }
    }

    public function UpdateSorting()
    {
        $this->db->trans_begin();

        $sorting_id = $this->input->post('sorting_id');
        $sorting_date = $this->input->post('sorting_date') . ' ' . date('H:i:s');
        $allocation_id = $this->input->post('allocation_id');
        $site_location_id = $this->input->post('site_location');
        $items = $this->input->post('items');

        $update_date = date('Y-m-d H:i:s');

        $this->db->set('sorting_date', $sorting_date);
        $this->db->set('allocation_id', $allocation_id);
        $this->db->set('site_location_id', $site_location_id);
        $this->db->where('idtbl_sorting_goods', $sorting_id);
        $this->db->update('tbl_sorting_goods');

        $this->db->where('sorting_id', $sorting_id);
        $this->db->delete('tbl_sorting_details');

        $allocation = $this->db->get_where(
            'tbl_allocation',
            array('idtbl_allocation' => $allocation_id)
        )->row_array();

        foreach ($items as $item) {
            $detail_data = array(
                'sorting_id' => $sorting_id,
                'allocation_id' => $allocation_id,
                'site_location_id' => $site_location_id,
                'allocation_material_id' => $allocation['material_id'],
                'sorted_material_id' => $item['material_id'],
                'quantity' => $item['quantity'],
                'batch_no' => null,
                'remark' => $item['remark'],
                'status' => 2,
                'created_at' => $update_date
            );
            $this->db->insert('tbl_sorting_details', $detail_data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Error updating sorting', 'type' => 'danger');
        } else {
            $this->db->trans_commit();
            return array('status' => true, 'message' => 'Sorting updated successfully', 'type' => 'success');
        }
    }

    public function DeleteSorting($sorting_id)
    {
        $this->db->trans_begin();

        $this->db->set('status', 0);
        $this->db->where('idtbl_sorting_goods', $sorting_id);
        $this->db->update('tbl_sorting_goods');

        $this->db->set('status', 0);
        $this->db->where('sorting_id', $sorting_id);
        $this->db->update('tbl_sorting_details');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Error deleting sorting', 'type' => 'danger');
        } else {
            $this->db->trans_commit();
            return array('status' => true, 'message' => 'Sorting deleted successfully', 'type' => 'success');
        }
    }
}
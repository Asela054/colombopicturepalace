<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SortingAllocate extends CI_Controller
{
    public function index()
    {
        $this->load->model('Commeninfo');
        $this->load->model('SortingAllocateinfo');
        $result['materiallist'] = $this->SortingAllocateinfo->GetMaterials();
        $result['menuaccess'] = $this->Commeninfo->Getmenuprivilege();
        $this->load->view('sortingallocate', $result);
    }

    public function get_available_qty($material_id)
    {
        $this->load->model('SortingAllocateinfo');
        $qty = $this->SortingAllocateinfo->GetAvailableQty($material_id);
        echo json_encode(['available_qty' => $qty]);
    }

    public function save_allocation()
    {
        $this->load->model('SortingAllocateinfo');
        $result = $this->SortingAllocateinfo->SaveAllocation();
        echo json_encode($result);
    }

    public function get_allocations($status = 1)
    {
        $this->load->model('SortingAllocateinfo');
        $allocations = $this->SortingAllocateinfo->GetAllocations($status);
        echo json_encode($allocations);
    }

    public function delete_allocation($allocation_id)
    {
        $this->load->model('SortingAllocateinfo');
        $result = $this->SortingAllocateinfo->DeleteAllocation($allocation_id);
        echo json_encode($result);
    }

    public function update_allocation($allocation_id)
    {
        $this->load->model('SortingAllocateinfo');
        $result = $this->SortingAllocateinfo->UpdateAllocation($allocation_id);
        echo json_encode($result);
    }

    public function approve_allocation($allocation_id)
    {
        $this->load->model('SortingAllocateinfo');
        $result = $this->SortingAllocateinfo->ApproveAllocation($allocation_id);
        echo json_encode($result);
    }

    public function reject_allocation($allocation_id)
    {
        $this->load->model('SortingAllocateinfo');
        $result = $this->SortingAllocateinfo->RejectAllocation($allocation_id);
        echo json_encode($result);
    }

    public function get_allocation_details($allocation_id)
    {
        $this->load->model('SortingAllocateinfo');
        $allocation = $this->SortingAllocateinfo->GetAllocationDetails($allocation_id);
        echo json_encode($allocation);
    }

    public function update_sorting_complete($allocation_id)
    {
        $this->load->model('SortingAllocateinfo');
        $result = $this->SortingAllocateinfo->UpdateSortingComplete($allocation_id);
        echo json_encode($result);
    }
}
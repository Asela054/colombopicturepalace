<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SortingGoods extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Commeninfo');
        $this->load->model('Sortinggoodsinfo');
    }

    public function index()
    {
        $result['site_locations'] = $this->Sortinggoodsinfo->GetSiteLocations();
        $result['menuaccess'] = $this->Commeninfo->Getmenuprivilege();
        $this->load->view('sortinggoods', $result);
    }

    public function GetActiveAllocations()
    {
        $allocations = $this->Sortinggoodsinfo->GetActiveAllocations();
        echo json_encode($allocations);
    }
    public function GetZonesByLocation()
    {
        $location_id = $this->input->post('location_id');
        $zones = $this->Sortinggoodsinfo->GetZonesByLocation($location_id);
        echo json_encode($zones);
    }

    public function GetRawMaterials()
    {
        $materials = $this->Sortinggoodsinfo->GetRawMaterials();
        echo json_encode($materials);
    }
    public function GetNextJobCardNo()
    {
        $next_job_card = $this->Sortinggoodsinfo->GetNextJobCardNo();
        echo json_encode(array('job_card_no' => $next_job_card));
    }

    public function ProcessSorting()
    {
        $result = $this->Sortinggoodsinfo->ProcessSorting();
        echo json_encode($result);
    }

    public function GetSortingRecords()
    {
        $sortings = $this->Sortinggoodsinfo->GetSortingRecords();
        echo json_encode($sortings);
    }

    public function GetSortingDetails()
    {
        $sorting_id = $this->input->post('sorting_id');
        $details = $this->Sortinggoodsinfo->GetSortingDetails($sorting_id);
        echo json_encode($details);
    }

    public function GetSortingForEdit()
    {
        $sorting_id = $this->input->post('sorting_id');
        $result = $this->Sortinggoodsinfo->GetSortingForEdit($sorting_id);
        echo json_encode($result);
    }

    public function ApproveSorting()
    {
        $sorting_id = $this->input->post('sorting_id');
        $result = $this->Sortinggoodsinfo->ApproveSorting($sorting_id);
        echo json_encode($result);
    }

    public function RejectSorting()
    {
        $sorting_id = $this->input->post('sorting_id');
        $result = $this->Sortinggoodsinfo->RejectSorting($sorting_id);
        echo json_encode($result);
    }

    public function UpdateSorting()
    {
        $result = $this->Sortinggoodsinfo->UpdateSorting();
        echo json_encode($result);
    }

    public function DeleteSorting()
    {
        $sorting_id = $this->input->post('sorting_id');
        $result = $this->Sortinggoodsinfo->DeleteSorting($sorting_id);
        echo json_encode($result);
    }

    public function GetZoneCapacity()
{
    $zone_id = $this->input->post('zone_id');
    $capacity = $this->Sortinggoodsinfo->GetZoneCapacity($zone_id);
    echo json_encode($capacity);
}

public function CalculateZoneUsage()
{
    $zone_id = $this->input->post('zone_id');
    $current_items = json_decode($this->input->post('current_items'), true);
    $usage = $this->Sortinggoodsinfo->CalculateZoneUsage($zone_id, $current_items);
    echo json_encode($usage);
}
}
<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Grnreqinfo extends CI_Model {

    public function Printinvoice($x){
        $recordID=$x;

        $this->db->select('*');
        $this->db->from('tbl_grn_req');
		$this->db->join('tbl_grn_req_detail', 'tbl_grn_req.idtbl_grn_req = tbl_grn_req_detail.tbl_grn_req_idtbl_grn_req', 'left');
		$this->db->join('tbl_print_material_info', 'tbl_grn_req_detail.tbl_material_id = tbl_print_material_info.idtbl_print_material_info', 'left');
		$this->db->join('tbl_material_type', 'tbl_print_material_info.tbl_material_type_idtbl_material_type = tbl_material_type.idtbl_material_type', 'left');

        $this->db->join('tbl_measurements', 'tbl_grn_req_detail.tbl_measurements_id = tbl_measurements.idtbl_mesurements', 'left');
        $this->db->join('tbl_location', 'tbl_grn_req.company_id = tbl_location.idtbl_location', 'left');
        $this->db->join('employees', 'tbl_grn_req.employee_id = employees.id', 'left');
        $this->db->join('tbl_material_group', 'tbl_grn_req.tbl_material_group_idtbl_material_group = tbl_material_group.idtbl_material_group', 'left');
        $this->db->where('tbl_grn_req.idtbl_grn_req', $recordID);
        
        $query = $this->db->get();
    

		$this->load->library('pdf');

		$fontDir = 'fonts/';
        $options = new Options();
        $options->set('fontDir', $fontDir);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Purchase Order Request</title>
            <style>
                
                body {
                    margin: 5px;
                    padding: 5px;
                    font-family: Arial, sans-serif;
                    width: 100%;
                }
                p {
                    font-size: 14px;
                    line-height: 3px;
                }
                .pheader {
                    font-size: 12px;
                    line-height: 1.5px;
                }
                .tablec {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .thc, .tdc {
                    padding: 5px;
                    text-align: left;
                    border: 1px solid black;
                }
                .thc {
                    background-color: #f2f2f2;
                   
                }
                hr {
                    border: 1px solid #ddd;
                }
                .postion {
                    position: relative;
                }
                .pos{
                    padding-bottom: -20px; 
                }
                .hedfont {
                    font: 20px comicz;
                }
            </style>
        </head>
        <body>

            <table border="0" width="100%">

                <tr>
                    <th width="15%" valign="top"></th>
                    <td align="center">
                        <h3><i>MULTI OFFSET PRINTERS (PVT) LTD</i></h3>
                        <p class="pheader"><i>345,NEGOMBO ROAD MUKALANGAMUWA, SEEDUWA</i></p>
                        <p class="pheader"><i>Phone : +94-11-2253505, 2253876, 2256615</i></p>
                        <p class="pheader"><i>E-Mail : multioffsetprinters@gmail.com</i></p>
                        <p class="pheader"><i>Fax : +94-11-2254057</i></p>
                    </td>
                    <th width="15%"></th>
                </tr>

                <tr>
                    <th colspan="3" height="10px"></th>
                </tr>

                <tr>
                    <td colspan="3">
                        <table width="100%" border="0" cellspacing="0">
                            <tr>
                                <td class="postion"><h3 class="pos">Internal Item Request</h3></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <p><b>Location: </b>' .$query->row()->location. '</p>
                                    
                                    <p><b>Employee: </b>' .$query->row()->emp_name_with_initial. '-'.$query->row()->emp_id.'</p>
									
                                    <p><b>Order Type: </b>' .$query->row()->group. '</p>
                                    
                                      
                                </td>
                                <td></td>
                                <td align="right" width="30%" valign="top">
                                    <p>MO/GRNR-<b>'.$query->row()->idtbl_grn_req. '</b></p>
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="3"><hr></td>
                </tr>

                <tr>
                    <td colspan="3">
                        <table class="tablec">
                            <thead class="thc">
                                <tr>
                                    <th class="thc" style="text-align:center;" width="25%">Item Name</th>
                                    <th class="thc" style="text-align:center;" width="25%">UOM</th>
                                    <th class="thc" style="text-align:center;" width="25%">Qty</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="tdc">';

                            foreach ($query->result() as $row) {
			
                                $html .= '
                                <tr>';

                                $html .= '<td class="tdc">'. $row->materialname . ' / ' . $row->materialinfocode .' - ' . $row->group .'</td>';
                                $html .= '<td class="tdc" style="text-align:center;">'.$row->measure_type.'</td>';
                                $html .= '<td class="tdc" style="text-align:center;">'.$row->qty.'</td>
                                </tr>';
                            }
                            $html .= '
                            </tbody>
                        </table>
                    </td>
                </tr>

            </table>
        </body>
        </html>
        
        ';
         
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Good Receive Note Request - '.$recordID.'.pdf', ["Attachment"=>0]);
    }

}

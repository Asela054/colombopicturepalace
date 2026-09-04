<?php
	include "include/header.php"; 
	include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
        		<div class="container-fluid">
        			<div class="page-header-content py-3">
        				<h1 class="page-header-title font-weight-light">
        					<div class="page-header-icon"><i class="fas fa-exchange-alt"></i></div>
        					<span>UOM Conversions</span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Uomconversions/UOMconversionsinsertupdate" method="post" autocomplete="off">
        							<div class="form-group mb-1">
        								<label class="small font-weight-bold text-dark">Main UOM*</label>
        								<select class="form-control form-control-sm" name="mainuom" id="mainuom">
        									<option value="">Select</option>
        									<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
        									<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
        										<?php echo $rowmeasurelist->measure_type ?></option>
        									<?php } ?>
        								</select>
        							</div>
                                    <div class="form-group mb-1">
        								<label class="small font-weight-bold">Qty*</label>
        								<input type="text" class="form-control form-control-sm" name="qty"
        									id="qty" required>
        							</div>
                                    <div class="form-group mb-1">
        								<label class="small font-weight-bold text-dark">Convert UOM*</label>
        								<select class="form-control form-control-sm" name="convertuom" id="convertuom">
        									<option value="">Select</option>
        									<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
        									<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
        										<?php echo $rowmeasurelist->measure_type ?></option>
        									<?php } ?>
        								</select>
        							</div>
        							<div class="form-group mt-2 text-right">
        								<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
        									<?php if($addcheck==0){echo 'disabled';} ?>><i
        										class="far fa-save"></i>&nbsp;Add</button>
        							</div>
        							<input type="hidden" name="recordOption" id="recordOption" value="1">
        							<input type="hidden" name="recordID" id="recordID" value="">
        						</form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
        								<thead>
        									<tr>
        										<th>#</th>
        										<th>Main UOM</th>
                                                <th>Qty</th>
        										<th>Convert UOM</th>
        										<th class="text-right"></th>
        									</tr>
        								</thead>
        							</table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Service Types', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { 
                    extend: 'pdf', 
                    className: 'btn btn-danger btn-sm', 
                    title: 'Location Information', 
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    customize: function(doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                },
                { 
                    extend: 'print', 
                    title: 'Service Types',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/uomconversionslist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.settings._iRecordsDisplay - meta.row;
                    }
                },
                {
                    "data": "main_uom"
                },
                {
                    "data": "qty"
                },
                {
                    "data": "convert_uom"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';

                        if(editcheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_uom_conversions']+'"><i class="fas fa-pen"></i></button>';
                        }
                        if(full['status']==1 && statuscheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Active" data-url="Uomconversions/Uomconversionsstatus/'+full['idtbl_uom_conversions']+'/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        }else if(full['status']==2 && statuscheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Deactive" data-url="Uomconversions/Uomconversionsstatus/'+full['idtbl_uom_conversions']+'/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 text-light btntableaction"><i class="fas fa-times"></i></button>';
                        }
                        if(deletecheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-url="Uomconversions/Uomconversionsstatus/'+full['idtbl_uom_conversions']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
                        }
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', async function() {
            var r = await Otherconfirmation("You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Uomconversions/Uomconversionsedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#mainuom').val(obj.main_uom);  
                        $('#convertuom').val(obj.convert_uom);                                            
                        $('#qty').val(obj.qty);                                                                                      
                            
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });
</script>

<?php include "include/footer.php"; ?>
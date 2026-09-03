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
        					<div class="page-header-icon"><i data-feather="activity"></i></div>
        					<span><b>Measurements</b></span>
        				</h1>
        			</div>
        		</div>
        	</div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Measurements/Measurementsinsertupdate" method="post" autocomplete="off">
        							<div class="form-group mb-1">
        								<label class="small font-weight-bold">Measure type*</label>
        								<input type="text" class="form-control form-control-sm" name="measure_type"
        									id="measure_type" required>
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
        										<th>Measure type</th>
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Measurements Types', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
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
                    title: 'Measurements Types',
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
                url: "<?php echo base_url() ?>scripts/measurements.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "asc" ]],
            "columns": [
                // {
                //     "data": null,
                //     "render": function(data, type, full, meta) {
                //         return meta.settings._iRecordsDisplay - meta.row;
                //     }
                // },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart;
                    }
                },
                {
                    "data": "measure_type"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';

                        if(editcheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_mesurements']+'"><i class="fas fa-pen"></i></button>';
                        }
                        if(full['status']==1 && statuscheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Active" data-url="Measurements/Measurementstatus/'+full['idtbl_mesurements']+'/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        }else if(full['status']==2 && statuscheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Deactive" data-url="Measurements/Measurementstatus/'+full['idtbl_mesurements']+'/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 text-light btntableaction"><i class="fas fa-times"></i></button>';
                        }
                        if(deletecheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-url="Measurements/Measurementstatus/'+full['idtbl_mesurements']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
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
                    url: '<?php echo base_url() ?>Measurements/Measurementsedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#measure_type').val(obj.measure_type);                                            
                            
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });
</script>

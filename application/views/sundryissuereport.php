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
						<h1 class="page-header-title">
							<div class="page-header-icon"><i class="fa fa-tags"></i></div>
                            <span>&nbsp; Sundry Items Issue Report</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<form id="searchsundryissuereport">
								<div class="col-12">
									<div class="form-row">
										<div class="col-3">
											<label class="small font-weight-bold">Date From</label>
											<input type="date" class="form-control form-control-sm" id="date_from" name="date_from">
										</div>
										<div class="col-3">
											<label class="small font-weight-bold">Date To</label>
											<input type="date" class="form-control form-control-sm" id="date_to" name="date_to">
										</div>
										<div class="col-3">
											<label class="small font-weight-bold">Material</label>
											<input type="text" class="form-control form-control-sm" id="material" name="material" placeholder="Material name">
										</div>
										<div class="col-3"><br>
										<button type="submit" id="searchButton" class="btn btn-info mb-2"><span id="boot-icon" class="bi bi-search" style="font-size: 15px;">&nbsp;Search</span></button>
									</div>
									</div>
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
								</div>

								<div class="col-12">
									<div class="form-group mb-1">
										<hr style="border: 1px solid #ddd;">
									</div>
								</div>
							</form>
							<div class="col-12 mt-4">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap w-100"
										id="dataTable">
										<thead class="thead-light">
											<tr>
												<th>Date</th>
												<th>Material</th>
												<th>Group</th>
												<th>Batch No</th>
												<th>Qty</th>
												<th>Unit Price</th>
												<th>Total</th>
												<th>Issued To</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									
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
	$(document).ready(function () {
		$("#searchsundryissuereport").submit(function (event) {
			event.preventDefault();

			var table = $('#dataTable').DataTable({
				"destroy": true,
				"processing": true,
				"serverSide": true,
				ajax: {
					url: "<?php echo base_url() ?>scripts/sundryissuereportlistreport.php",
					type: "POST",
					"data": function (d) {
						return $.extend({}, d, {
							"search_from_date": $("#date_from").val(),
							"search_to_date": $("#date_to").val(),
							"material": $("#material").val(),
							"company_id": '<?php echo $_SESSION['company_id']; ?>',
						});
					}
				},
				"order": [
					[0, "desc"]
				],
				"columns": [
					{ "data": "issuedate" },
					{ "data": "materialname" },
					{ "data": "materialgroup" },
					{ "data": "batchno" },
					{ "data": "qty" },
					{ "data": "unitprice" },
					{ "data": "total" },
					{ "data": "employee" },
					{
						"data": "approvestatus",
						"render": function (data) {
							if (data == 1) {
								return '<span class="badge badge-success">Approved</span>';
							} else if (data == 2) {
								return '<span class="badge badge-danger">Rejected</span>';
							} else {
								return '<span class="badge badge-warning">Pending Approval</span>';
							}
						}
					}
				],
				dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				responsive: true,
				lengthMenu: [
					[10, 25, 50, -1],
					[10, 25, 50, 'All'],
				],
				buttons: [{
						extend: 'pdf',
						className: 'btn btn-primary btn-sm',
						text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
						title: 'Sundry Items Issue Report',
						filename: 'Sundry Items Issue Report',
						footer: true,
						messageTop: {
							text: 'Sundry Items Issue Report',
							fontSize: 15,
							bold: true,
							alignment: 'center'
						},
						customize: function (doc) {
							doc.styles.title = {
								color: 'black',
								fontSize: '30',
								alignment: 'center',
							}
						}
					},
					{
						extend: 'excel',
						className: 'btn btn-success btn-sm',
						filename: 'Sundry Items Issue Report',
						text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
						footer: true,
						title: 'Sundry Items Issue Report'
					},
					{
						extend: 'csv',
						className: 'btn btn-info btn-sm',
						filename: 'Sundry Items Issue Report',
						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
						footer: true
					},
					{
						extend: 'print',
						className: 'btn btn-warning btn-sm',
						text: '<i class="fas fa-print mr-2"></i> PRINT',
						title: 'Sundry Items Issue Report',
						filename: 'Sundry Items Issue Report',
						footer: true,
						messageTop: 'Sundry Items Issue Report',
						customize: function (doc) {
							doc.styles.title = {
								color: 'black',
								fontSize: '30',
								alignment: 'center',
							}
						}
					}
				],
				drawCallback: function (settings) {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		});
	});
</script>

<?php include "include/footer.php"; ?>
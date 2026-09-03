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
							<div class="page-header-icon">
								<i class="fas fa-coins"></i>
							</div>
							<span>&nbsp; Stock Valuation Report</span>
						</h1>
					</div>
				</div>
			</div>


			<div class="container-fluid mt-2 p-0 p-2">

				<div class="card">

					<div class="card-body p-0 p-2">

						<div class="col-12">


							<form id="searchstock">


								<div class="col-12">

									<div class="form-row">


										<div class="col-3">

											<label class="small font-weight-bold">
												Material Group
											</label>

											<select class="form-control form-control-sm selecter2" 
												id="group">

												<option value="all">
													All
												</option>


												<?php foreach($materialgroup->result() as $row){ ?>

												<option value="<?php echo $row->idtbl_material_group; ?>">
													<?php echo $row->group; ?>
												</option>

												<?php } ?>


											</select>


										</div>


										<div class="col-2">

											<label class="small font-weight-bold">
												Date From
											</label>

											<input type="date" 
											class="form-control form-control-sm"
											id="date_from">

										</div>


										<div class="col-2">

											<label class="small font-weight-bold">
												Date To
											</label>

											<input type="date" 
											class="form-control form-control-sm"
											id="date_to">

										</div>


										<div class="col-3">

											<label class="small font-weight-bold">
												Product Name / Batch
											</label>


											<input type="text" 
											class="form-control form-control-sm"
											id="search"
											placeholder="Search">


										</div>




										<div class="col-2">
											<br>

											<button type="submit" 
											class="btn btn-info btn-sm">

												<i class="fas fa-search"></i>
												&nbsp;Search

											</button>


										</div>



									</div>


								</div>



								<div class="col-12">

									<div class="form-group mb-1">

										<hr style="border:1px solid #ddd;">

									</div>

								</div>


							</form>





							<div class="col-12 mt-4">


								<div class="scrollbar pb-3" id="style-2">


									<table class="table table-bordered table-striped table-sm nowrap w-100"
									id="dataTable">


										<thead class="thead-light">

											<tr>

												<th>Code</th>
												<th>Product Name</th>
												<th>Category</th>
												<th>Batch</th>
												<th>Date</th>
												<th>Qty</th>
												<th>UOM</th>
												<th>Unit Price</th>
												<th>Total</th>

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

$(document).ready(function(){


	$('.selecter2').select2();



	$("#searchstock").submit(function(event){

		event.preventDefault();



		$('#dataTable').DataTable({

			"destroy":true,

			"processing":true,

			"serverSide":true,


			ajax:{

				url:"<?php echo base_url()?>scripts/stockvaluationlistreport.php",

				type:"POST",


				data:function(d){

					return $.extend({},d,{

						"group":$("#group").val(),

						"date_from":$("#date_from").val(),

						"date_to":$("#date_to").val(),

						"search":$("#search").val(),

						"company_id":'<?php echo $_SESSION['company_id']; ?>'

					});

				}

			},



			"order":[
				[4,"desc"]
			],



			"columns":[

				{
					data:'code'
				},

				{
					data:'product_name'
				},

				{
					data:'category'
				},

				{
					data:'batch'
				},

				{
					data:'date'
				},

				{
					data:'qty',
					className:'text-right',
					render:function(data){

						return Number(data).toLocaleString();

					}
				},

				{
					data:'uom'
				},

				{
					data:'unit_price',
					className:'text-right',
				},

				{
					data:'total',
					className:'text-right',
					render:function(data){

						return Number(data).toLocaleString();

					}
				}


			],




			dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",



			responsive:true,


			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],



			buttons:[


				{
					extend:'pdf',
					className:'btn btn-primary btn-sm',
					text:'<i class="fas fa-file-pdf mr-2"></i> PDF',
					title:'Stock Valuation Report'
				},


				{
					extend:'excel',
					className:'btn btn-success btn-sm',
					text:'<i class="fas fa-file-excel mr-2"></i> EXCEL',
					title:'Stock Valuation Report'
				},


				{
					extend:'csv',
					className:'btn btn-info btn-sm',
					text:'<i class="fas fa-file-csv mr-2"></i> CSV'
				},


				{
					extend:'print',
					className:'btn btn-warning btn-sm',
					text:'<i class="fas fa-print mr-2"></i> PRINT',
					title:'Stock Valuation Report'
				}


			]



		});


	});


});


</script>


<?php include "include/footer.php"; ?>
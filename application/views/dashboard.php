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
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<h1 class="page-header-title ">
									<div class="page-header-icon"><i class="fas fa-desktop"></i></div>
									<span>Dashboard</span>
								</h1>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body">
						<div class="row row-cols-1 row-cols-md-5">
							<div class="col">
								<div class="card border border-success mb-3 shadow-none h-100" id="materialCard">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-success">
											<i class="fas fa-file-alt fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-success m-0 font-weight-bold"><a
														class="text-success"
														href="#"> Print Materials
														(<?php if($materialinfo->num_rows() > 0){ foreach($materialinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-success" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card border border-danger mb-3 shadow-none h-100"  id="matchineCard">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-danger">
											<i class="fas fa-cogs fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-danger m-0 font-weight-bold"><a
														class="text-danger"
														href="#"> Machine
														(0)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-danger" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card border border-warning mb-3 shadow-none h-100" id="sparepartsCard">
									<div class="row no-gutters h-100">
										<div class="col-auto p-2 text-warning">
											<i class="fas fa-tools fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-warning m-0 font-weight-bold"><a
														class="text-warning"
														href="#"> Spare Parts
														(0)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-warning" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="card border border-primary mb-3 shadow-none h-100" id="zrostockCard">
									<div class="row no-gutters h-100">
									<div class="col-auto p-2 text-primary">
											<i class="fas fa-file-invoice-dollar fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-primary m-0 font-weight-bold"><a
														class="text-primary"
														href="#"> Zero Stock Procucts
														(<?php if($zerostockinfo->num_rows() > 0){ foreach($zerostockinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-primary" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <div class="col">
								<div class="card border border-info mb-3 shadow-none h-100" id="lowstockCard">
									<div class="row no-gutters h-100">
									<div class="col-auto p-2 text-info">
											<i class="fas fa-exclamation-triangle fa-3x"></i>
										</div>
										<div class="col">
											<div class="card-body p-0 px-2 py-3 text-right">
												<h3 class="card-title text-info m-0 font-weight-bold"><a
														class="text-info"
														href="#"> Low Stock
														(<?php if($lowstockinfo->num_rows() > 0){ foreach($lowstockinfo->result() as $rowlist){ echo $rowlist->stockcount; }}?>)</a>
												</h3>
											</div>
										</div>
									</div>
									<div class="row no-gutters h-100">
										<div class="col">
											<div class="card-body p-0 p-2 text-right">
												<div class="progress" style="height: 3px;">
													<div class="progress-bar bg-info" role="progressbar"
														style="width: 100%;" aria-valuenow="" aria-valuemin="0"
														aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-6">
								<h6 class="small title-style"><span>Last Five Purchase</span></h6>
								<table class="table table-striped table-bordered table-sm small">
									<thead  class="bg-danger-soft">
										<tr>
											<th>Material</th>
											<th>Date</th>
											<th>Qty</th>
											<th>Unit</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($resultdate->num_rows() > 0) {
											foreach ($resultdate->result() as $item) {
										?>
											<tr>
												<td><?php echo $item->materialname; ?></td>
												<td><?php echo $item->date; ?></td>
												<td class="text-right"><?php echo $item->qty; ?></td>
												<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
												<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
											</tr>
										<?php
											}
										} 
										?>
									</tbody>
								</table>
							</div>
							<div class="col-6">
								<h6 class="small title-style"><span>Top Five Purchase</span></h6>
								<table class="table table-striped table-bordered table-sm small">
									<thead  class="bg-warning-soft">
										<tr>
											<th>Material</th>
											<th>Date</th>
											<th>Qty</th>
											<th>Unit</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($resultqty->num_rows() > 0) {
											foreach ($resultqty->result() as $item) {
										?>
											<tr>
												<td><?php echo $item->materialname; ?></td>
												<td><?php echo $item->date; ?></td>
												<td class="text-right"><?php echo $item->qty; ?></td>
												<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
												<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
											</tr>
										<?php
											}
										} 
										?>
									</tbody>
								</table>
							</div>
							<div class="col-12">
								<h6 class="small title-style"><span>Non Moving Materials</span></h6>
								<table class="table table-striped table-bordered table-sm small">
									<thead  class="bg-secondary-soft">
										<tr>
											<th>Material</th>
											<th>Date</th>
											<th>Qty</th>
											<th>Unit Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($resultnonmove->num_rows() > 0) {
											foreach ($resultnonmove->result() as $item) {
										?>
											<tr>
												<td><?php echo $item->materialname; ?></td>
												<td><?php echo $item->grndate; ?></td>
												<td class="text-right"><?php echo $item->qty; ?></td>
												<td class="text-right">Rs.<?php echo $item->unitprice; ?></td>
												<td class="text-right">Rs.<?php echo number_format($item->total, 2); ?></td>
											</tr>
										<?php
											}
										} 
										?>
									</tbody>
								</table>
							</div> 
						</div> 	
					</div>  
				</div>
			</div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Model of View Material  -->
<div class="modal fade" id="tableModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="tableModalLabel">Print Material Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="scrollbar pb-3" id="style-2">
								<table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable">
									<thead>
										<tr>
										<th>#ID</th>
										<th>GRN Date</th>
										<th>Suplier Name</th>
										<th>Qty</th>
										<th>Unit Price</th>
										<th>Material Name</th>
										<th>Total</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>    
    </div>
</div>
<!-- Model of View Machine stock  -->
<!-- <div class="modal fade" id="tableModal2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Machine Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="scrollbar pb-3" id="style-2">
							<table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable2">
								<thead>
									<tr>
										<th>#ID</th>
										<th>GRN Date</th>
										<th>Supplier Name</th>
										<th>Qty</th>
										<th>Unit Price</th>
										<th>Machine</th>
										<th>Total</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div> -->
<!-- Model of Spare Parts stock  -->
<!-- <div class="modal fade" id="tableModal3" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tableModalLabel">Spare Parts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="scrollbar pb-3" id="style-2">
								<table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable3">
									<thead>
										<tr>
										<th>#ID</th>
										<th>GRN Date</th>
										<th>Qty</th>
										<th>Unit Price</th>
										<th>Spare Parts Name</th>
										<th>Total</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>    
    </div>
</div> -->
<!-- Model Zero stock Product -->
<div class="modal fade" id="tableModal4" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tableModalLabel">Zero Product stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="scrollbar pb-3" id="style-2">
								<table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable4">
									<thead>
										<tr>
										<th>#ID</th>
										<th>GRN Date</th>
										<th>Suplier Name</th>
										<th>Material Name</th>
										<th>Qty</th>
										<th>Unit Price</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>    
    </div>
</div>
<!-- Model low stock Product  -->
<div class="modal fade" id="tableModal5" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tableModalLabel">Low stock Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="scrollbar pb-3" id="style-2">
								<table class="table table-bordered table-striped nowrap w-100 table-sm small" id="dataTable5">
									<thead>
										<tr>
										<th>#ID</th>
										<th>GRN Date</th>
										<th>Suplier Name</th>
										<th>Material Name</th>
										<th>Qty</th>
										<th>Unit Price</th>
										<th>Total</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>    
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
		$('#dataTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalmateriallist.php",
				type: "POST",
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "suppliername"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
				{
					"data": "materialname"
				},
				{
					"data": "total"
				},
				

			],
		});
		// $('#dataTable2').DataTable({
		// 	"destroy": true,
		// 	"processing": true,
		// 	"serverSide": true,
		// 	ajax: {
		// 		url: "<?php echo base_url() ?>scripts/totalMachinelist.php",
		// 		type: "POST",
		// 	},
		// 	"order": [
		// 		[0, "desc"]
		// 	],
		// 	"columns": [

		// 		{
		// 			"data": "idtbl_print_stock"
		// 		},
		// 		{
		// 			"data": "grndate"
		// 		},
		// 		{
		// 			"data": "suppliername"
		// 		},
		// 		{
		// 			"data": "qty"
		// 		},
		// 		{
		// 			"data": "unitprice"
		// 		},
		// 		{
		// 			"data": "machine"
		// 		},
		// 		{
		// 			"data": "total"
		// 		},
				

		// 	],
		// });
		// $('#dataTable3').DataTable({
		// 	"destroy": true,
		// 	"processing": true,
		// 	"serverSide": true,
		// 	ajax: {
		// 		url: "<?php echo base_url() ?>scripts/totalsparepartslist.php",
		// 		type: "POST",
		// 	},
		// 	"order": [
		// 		[0, "desc"]
		// 	],
		// 	"columns": [

		// 		{
		// 			"data": "idtbl_print_stock"
		// 		},
		// 		{
		// 			"data": "grndate"
		// 		},
		// 		{
		// 			"data": "qty"
		// 		},
		// 		{
		// 			"data": "unitprice"
		// 		},
		// 		{
		// 			"data": "spare_part_name"
		// 		},
		// 		{
		// 			"data": "total"
		// 		},
				

		// 	],
		// });
		$('#dataTable4').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totalZeroProductlist.php",
				type: "POST",
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "suppliername"
				},
				{
					"data": "materialname"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
				

			],
		});
        $('#dataTable5').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: "<?php echo base_url() ?>scripts/totallowProductlist.php",
				type: "POST",
			},
			"order": [
				[0, "desc"]
			],
			"columns": [

				{
					"data": "idtbl_print_stock"
				},
				{
					"data": "grndate"
				},
				{
					"data": "suppliername"
				},
				{
					"data": "materialname"
				},
				{
					"data": "qty"
				},
				{
					"data": "unitprice"
				},
                {
					"data": "total"
				},
				

			],
		});
		$('#materialCard').on('click', function() {
			$('#tableModal').modal('show');
		});
		$('#matchineCard').on('click', function() {
			$('#tableModal2').modal('show');
		});
		$('#sparepartsCard').on('click', function() {
			$('#tableModal3').modal('show');
		});
		$('#zrostockCard').on('click', function() {
			$('#tableModal4').modal('show');
		});
		$('#lowstockCard').on('click', function() {
			$('#tableModal5').modal('show');
		});
	});
</script>
<?php include "include/footer.php"; ?>

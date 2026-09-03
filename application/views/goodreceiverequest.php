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
							<div class="page-header-icon"><i class="fa fa-folder-open"></i></div>
							<span><b>Internal Item Request</b></span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-2">
				<div class="card">
					<div class="card-body p-2">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
								<form id="createorderform" autocomplete="off">
									<div class="form-group mb-1">
										<input type="hidden" id="company" name="company"
											class="form-control form-control-sm"
											value="<?php echo $_SESSION['branch_id']; ?>"
											required readonly>
									</div>

									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold text-dark">Employee*</label>
											<select class="form-control form-control-sm" name="employee"
												id="employee" required>
												<option value="">Select</option>
												<?php foreach($employeelist->result() as $rowemployeelist){ ?>
												<option value="<?php echo $rowemployeelist->id ?>">
													<?php echo $rowemployeelist->emp_name_with_initial .'-'. $rowemployeelist->emp_id?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">Order Type*</label>
											<select class="form-control form-control-sm" name="ordertype"
												id="ordertype" required>
												<option value="">Select</option>
												<?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
												<option
													value="<?php echo $rowordertypelist->idtbl_material_group ?>">
													<?php echo $rowordertypelist->group ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div id="ordertypeError" class="text-danger" style="display: none;">
										Select only items related to one Order type per GRN equest!
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold text-dark">Item*</label>
											<select class="form-control form-control-sm" name="product"
												id="product">
												<option value="">Select</option>
											</select>
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">UOM*</label>
											<select class="form-control form-control-sm" name="uom" id="uom"
												required>
												<option value="">Select</option>
												<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
												<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
													<?php echo $rowmeasurelist->measure_type ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="form-row mb-1">
										<div class="col" id="newQtyFields" style="display: none;">
											<label class="small font-weight-bold text-dark">Qty*</label>
											<input type="text" id="newqty" name="newqty"
												class="form-control form-control-sm" required>
										</div>
									</div>


									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Reason</label>
										<textarea name="comment" id="comment"
											class="form-control form-control-sm"></textarea>
									</div>
									<div class="form-group mt-3 text-right">
										<button type="button" id="formsubmit"
											class="btn btn-warning font-weight-bold btn-sm px-4"
											<?php if($addcheck==0){echo 'disabled';} ?>><i
												class="fas fa-plus"></i>&nbsp;Add
											to
											list</button>
										<input name="submitBtn" type="submit" value="Save" id="submitBtn"
											class="d-none">
									</div>
									<input type="hidden" name="refillprice" id="refillprice" value="">
								</form>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
								<div id="materialmachinetblpart">
									<table class="table table-striped table-bordered table-sm small"
										id="tableorder">
										<thead>
											<tr>
												<th>Item</th>
												<th>UOM</th>
												<th class="d-none">UOMID</th>
												<th class="d-none">ProductID</th>
												<th class="text-center">Qty</th>
												<th class="text-center">Reason</th>
												<th class="text-right">Action</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>

								<hr>

								<div class="form-group mt-2">
									<button type="button" id="btncreateorder"
										class="btn btn-primary btn-sm fa-pull-right"><i
											class="fas fa-save"></i>&nbsp;Create
										Request</button>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
								<div class="col-12">
									<div class="scrollbar pb-3" id="style-2">
										<table class="table table-bordered table-striped table-sm nowrap"
											id="dataTable">
											<thead>
												<tr>
													<th>Request No.</th>
													<th>Employee</th>
													<th>Order Type</th>
													<th>Approve Status</th>
													<th class="text-right">Actions</th>
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

<!-- Modal -->
<div id="purchaseview">
	<div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">View Internal Item Request</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div id="viewhtml"></div>
				</div>
				<div class="modal-footer">
					<button type="button" id="printporder" class="btn btn-outline-primary btn-sm fa-pull-right"
						<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Print Internal Item Request</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		$('#vehicletblpart').hide();
		$('#newQtyFields').show();

		$('#product').select2({
                width: '100%'
            });
	});

</script>
<script>
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';


		$('#printporder').click(function () {

			printJS({
				printable: 'purchaseview',
				type: 'html',
				css: 'assets/css/styles.css',
				header: 'Purchase Order Request',
				onPrintSuccess: function () {
					var printButton = document.getElementById('printporder');
					printButton.style.display = 'none';
				}
			});
		});


		$('#dataTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			responsive: true,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			"buttons": [{
					extend: 'csv',
					className: 'btn btn-success btn-sm',
					title: 'Good Receive Note Request Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Good Receive Note Request Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Good Receive Note Request Information',
					className: 'btn btn-primary btn-sm',
					text: '<i class="fas fa-print mr-2"></i> Print',
					customize: function (win) {
						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
				},
				// 'copy', 'csv', 'excel', 'pdf', 'print'
			],
			ajax: {
				url: "<?php echo base_url() ?>scripts/goodreceiverequestlist.php",
				type: "POST", // you can use GET
				"data": function(d) {
                return $.extend({}, d, {
                    "company_id": '<?php echo ($_SESSION['company_id']); ?>',
                });
            }
			},
			"order": [
				[0, "desc"]
			],
			"columns": [
				{
					"data": "idtbl_grn_req",
					"render": function(data, type, row) {
						return "IR000" + data;
					}
				},
				{
					"data": "empid",
					"render": function(data, type, row) {
						return row.employeename + ' - ' + row.empid;
					}
				},
				{
					"data": "group"
				},
				{
					"targets": -1,
					"className": '',
					"data": "confirmstatus_display",
					"render": function(data, type, row) {
						return data;
					}
				}, 
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<a href="<?php echo base_url() ?>Goodreceiverequest/Printinvoice/' +
							full['idtbl_grn_req'] +
							'" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print Request" class="btn btn-secondary btn-sm mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-file-pdf mr-2"></i></a>';

						button += '<button data-toggle="tooltip" data-placement="bottom" title="View Request" class="btn btn-dark btn-sm btnview mr-1" id="' + full[
							'idtbl_grn_req'] + '"><i class="fas fa-eye"></i></button>';
						if (full['confirmstatus'] == 1) {
							button += '<button data-toggle="tooltip" data-placement="bottom" title="Active" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></button>';
						} else {
							button +=
								'<a href="<?php echo base_url() ?>Goodreceiverequest/Goodreceiverequeststatus/' +
								full['idtbl_grn_req'] +
								'/1" onclick="return handleConfirm(event, this.href)" target="_self" data-toggle="tooltip" data-placement="bottom" title="Approve" class="btn btn-danger btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#dataTable tbody').on('click', '.btnview', function () {
			var id = $(this).attr('id');
			$('#procode').html(id);
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Goodreceiverequest/Grnorderview',
				success: function (result) { //alert(result);

					$('#porderviewmodal').modal('show');
					$('#viewhtml').html(result);
				}
			});

		});

		$("#product").select2({
			width: '100%',
			ajax: {
				url: "<?php echo base_url() ?>Goodreceiverequest/GetProductList",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						searchTerm: params.term,
						ordertype: $('#ordertype').val()
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});

		$("#formsubmit").click(function () {
			if (!$("#createorderform")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.F
				$("#submitBtn").click();
			} else {

					var productID = $('#product').val();
					var comment = $('#comment').val();
					var product = $("#product option:selected").text();
					var unitprice = parseFloat($('#unitprice').val());
					var newqty = parseFloat($('#newqty').val());
					var uomID = parseFloat($('#uom').val());
					var uom = $("#uom option:selected").text();

					$('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product +
						'</td><td>' + uom +
						'</td><td class="d-none">' + uomID + '</td><td class="d-none">' + productID + '</td><td class="text-center">' +
						newqty + '</td><td class="text-center">' +
						comment +
						'</td><td><button type="button" onclick= "productDelete(this);" id="btnDeleterow" class=" btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td> </tr>'
					);

					$('#product').val('');
					$('#unitprice').val('');
					$('#saleprice').val('');
					$('#comment').val('');
					$('#newqty').val('0');
					$('#product').focus();
			}
		});
		$('#tableorder').on('click', 'tr', function () {
			var r = confirm("Are you sure, You want to remove this product ? ");
			if (r == true) {
				$(this).closest('tr').remove();

				var sum = 0;
				$(".total").each(function () {
					sum += parseFloat($(this).text());
				});

				var showsum = addCommas(parseFloat(sum).toFixed(2));

				$('#divtotal').html('Rs. ' + showsum);
				$('#hidetotalorder').val(sum);
				$('#product').focus();
			}
		});

		$('#btncreateorder').click(function () {
				$('#btncreateorder').prop('disabled', true).html(
					'<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
				var tbody = $("#tableorder tbody");

				if (tbody.children().length > 0) {
					jsonObj = [];
					$("#tableorder tbody tr").each(function () {
						item = {}
						$(this).find('td').each(function (col_idx) {
							item["col_" + (col_idx + 1)] = $(this).text();
						});

						jsonObj.push(item);
					});
					console.log("tableorder");
					console.log(jsonObj);

					var employee = $('#employee').val();
					var reason = $('#reason').val();
					var company = $('#company').val();
					var ordertype = $('#ordertype').val();

					Swal.fire({
						title: "",
						html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
						allowOutsideClick: false,
						showConfirmButton: false,
						backdrop: "rgba(255, 255, 255, 0.5)",
						customClass: {
							popup: "fullscreen-swal"
						},
						didOpen: () => {
							document.body.style.overflow = "hidden";

							$.ajax({
								type: "POST",
								data: {
									tableData: jsonObj,
									employee: employee,
									ordertype: ordertype,
									reason: reason,
									company: company,

								},
								url: 'Goodreceiverequest/Goodreceiverequestinsertupdate',
								success: function (result) {
									Swal.close();
									document.body.style.overflow = "auto";

									var response = JSON.parse(result);
									if (response.status == 1) {
										Swal.fire({
											icon: "success",
											title: "Item Request!",
											text: "Request created successfully!",
											timer: 2000,
											showConfirmButton: false
										}).then(() => {
											window.location.reload();
										});
									} else {
										Swal.fire({
											icon: "error",
											title: "Error",
											text: "Something went wrong. Please try again later.",
										});
									}
								},
								error: function () {
									Swal.close();
									document.body.style.overflow = "auto";
									Swal.fire({
										icon: "error",
										title: "Error",
										text: "Something went wrong. Please try again later.",
									});
								}
							});
						},
					});
				}
		});
	});

	function deactive_confirm() {
		return confirm("Are you sure you want to deactive this?");
	}

	async function active_confirm() {
		const result = await Swal.fire({
			title: "Are you sure?",
			text: "You want to confirm this Good Receive Note Request?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, confirm!",
			cancelButtonText: "No, cancel!"
		});

		return result.isConfirmed;
	}

	async function handleConfirm(event, url) {
		event.preventDefault();

		const confirmed = await active_confirm();
		if (confirmed) {
			window.location.href = url;
		}
	}

	function delete_confirm() {
		return confirm("Are you sure you want to remove this?");
	}

	function addCommas(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

	function action(data) { //alert(data);
		var obj = JSON.parse(data);
		$.notify({
			// options
			icon: obj.icon,
			title: obj.title,
			message: obj.message,
			url: obj.url,
			target: obj.target
		}, {
			// settings
			element: 'body',
			position: null,
			type: obj.type,
			allow_dismiss: true,
			newest_on_top: false,
			showProgressbar: false,
			placement: {
				from: "top",
				align: "center"
			},
			offset: 100,
			spacing: 10,
			z_index: 1031,
			delay: 5000,
			timer: 1000,
			url_target: '_blank',
			mouse_over: null,
			animate: {
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutUp'
			},
			onShow: null,
			onShown: null,
			onClose: null,
			onClosed: null,
			icon_type: 'class',
			template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
				'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
				'<span data-notify="icon"></span> ' +
				'<span data-notify="title">{1}</span> ' +
				'<span data-notify="message">{2}</span>' +
				'<div class="progress" data-notify="progressbar">' +
				'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
				'</div>' +
				'<a href="{3}" target="{4}" data-notify="url"></a>' +
				'</div>'
		});
	}

</script>
<?php include "include/footer.php"; ?>

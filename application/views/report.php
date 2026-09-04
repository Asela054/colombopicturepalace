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
							<div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
							<span>Material Stock Category Wise Report</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="col-12">
							<form id="searchStock">
								<div class="col-12">
									<div class="form-row mt-2">
										<div class="col-2">
											<label class="small font-weight-bold">Type*</label>
											<select class="form-control form-control-sm selecter2 px-0" name="category"
												id="category" required>
												<option value="">Select</option>
												<option value="0">All</option>
												<?php foreach ($getcategory->result() as $rowgetcategory) { ?>
												<option value="<?php echo $rowgetcategory->idtbl_material_group ?>">
													<?php echo $rowgetcategory->group ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-auto align-self-end">
											<button type="submit" id="submitBtnStock" name="submitBtnStock"
												class="btn btn-info btn-sm px-4"
												<?php if($addcheck==0){echo 'disabled';} ?>>
												<i class="fas fa-search"></i>&nbsp;Search
											</button>
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
							<button onclick="exportToPDF()" class="btn-light-green">Export to PDF</button>

							<div class="col-12 mt-4" id="mainTable">

							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<style>
    .btn-light-green {
        background-color: lightgreen;
        border: none;
        color: black;
        border-radius: 25px; /* Rounded corners */
        padding: 10px 20px; /* Optional: Add padding */
        font-size: 14px; /* Optional: Adjust font size */
    }
</style>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>

<script>
$(document).ready(function () {

    $("#searchStock").submit(function (event) {
        event.preventDefault(); // stops page refresh

        var category = $("#category").val();
        $('#mainTable').empty();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Report/stockReport",
            data: { category: category },
            success: function (result) {

                var dataArray = JSON.parse(result);

                var groupWiseList = {};

                dataArray.forEach(function (item) {

                    // ✅ FIXED
                    var materialGroup = item.group || 'No Group';

                    if (!groupWiseList[materialGroup]) {
                        groupWiseList[materialGroup] = [];
                    }

                    groupWiseList[materialGroup].push(item);
                });

                $.each(groupWiseList, function (groupName, items) {
                    $('#mainTable').append(generateTable(groupName, items));
                });

                // Initialize DataTables for each table
                $('#mainTable table').each(function() {
                    $(this).DataTable({
                        "pageLength": 25,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "ordering": true,
                        "searching": true,
                        "paging": true,
                        "info": true,
                        "dom": 'frtip'
                    });
                });
            }
        });
    });

});


function generateTable(type, items) {

    let tableId = 'table_' + type.replace(/\s+/g, '_').toLowerCase();
    
    let tableHtml = `
        <div class="scrollbar pb-3">
            <h3>${type}</h3>
            <table id="${tableId}" class="table table-striped table-bordered table-sm w-100">
                <thead class="thead-light">
                    <tr>
                        <th>Product Name</th>
                        <th>Batch No</th>
                        <th>Warehouse</th>
                        <th class="text-center">Quantity</th>
                        <th>UOM</th>
                        <th class="text-right">Unit Price</th>
                        <th>Category</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
    `;

    let typeTotal = 0; 

    items.forEach(function (item) {
        let qty = parseFloat(item.qty) || 0;
        let unitprice = parseFloat(item.unitprice) || 0;
        let calculatedTotal = qty * unitprice;

        typeTotal += calculatedTotal;

        tableHtml += `
            <tr>
                <td>${item.materialname}</td>
                <td>${item.batchno}</td>
                <td>${item.wh_name}</td>
                <td class="text-center">${qty}</td>
                <td>${item.measure_type}</td>
                <td class="text-right">${unitprice}</td>
                <td>${item.group}</td>
                <td class="text-right">${calculatedTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            </tr>
        `;
    });

    tableHtml += `
            </tbody>
            <tfoot class="thead-light">
                <tr>
                    <th colspan="7" class="text-right">Total</th>
                    <th>${typeTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    `;

    return tableHtml;
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>


<?php include "include/footer.php"; ?>

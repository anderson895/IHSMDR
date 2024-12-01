<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<style>
    p{
        font-size: .75em;
        font-weight: 100;
    }
    th{
        border: 1px solid black;
        text-align: center;
    }
</style>
<div class="page-wrapper">
    <div class="content" style="justify-content: center;">
    <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>Patient Management</h4>
                <h6>View/Search Patients</h6>
            </div>
            <div class="page-btn">
                <button class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Add Patient
                </button>
            </div>
        </div> 
        <div class="table-top">
                    <div class="row">
                        <div class="col-md-3">
                            <select id="dispensingOfficerFilter" class="form-control">
                                <option value="">Section B<br>(Maternal Care and Services)</option>
                                <option value="">Section C<br>(Child Care and Services)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" id="startDate" class="form-control" placeholder="Start Date">
                        </div>
                        <div class="col-md-3">
                            <input type="date" id="endDate" class="form-control" placeholder="End Date">
                        </div>
                        <div>
                        <select id="dispensingOfficerFilter" class="form-control">
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                                <option value="">Barusbus</option>
                            </select>
                            </div>
                        <div class="col-md-6 mt-3">
                            <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
                            <button id="exportReport" class="btn btn-success">Export Report</button>
                            <button id="printReport" class="btn btn-info">Print Report</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table hover nowrap">
                        <thead>
                            <tr>
                                <th rowspan="4">No.</th>
                                <th rowspan="4">Date of Registration<br><p>(mm/dd/yy)</p></th>
                                <th rowspan="4">Date of Birth<br><p>(mm/dd/yy)</p></th>
                                <th rowspan="4">Date of Birth<br><p>(mm/dd/yy)</p></th>
                                <th rowspan="4">Family Serial Number</th>
                                <th rowspan="4">SE Status<br><p>1: NHTS<br>2: Non-NHTS</p></th>
                                <th rowspan="4">Name of Child<br><p>(First Name, Middle Initial, Last Name)</p></th>
                                <th rowspan="4">Sex<br><p>(M or F)</p></th>
                                <th rowspan="4">Complete Name of Mother<br><p>(LN, FN, MI)</p></th>
                                <th rowspan="4">Complete Address</th>
                                <th colspan="2">Child Protected at Birth (CPAB)<br><p>(Place a √)<br>(counts should be consistent with Maternal TCL Livebirths)</p></th>
                                <th colspan="6">Newborn (0-28 days old)</th>
                                <th colspan="17">1-3 months old</th>
                                <th colspan="4" rowspan="3">Exclusive Breastfeeding*<br><p>During the following immunization visits of the child at 1 ½, 2 ½ and 3 ½ months old (or at 4-5 mos.),<br>ask the mother if the child continues to be exclusively breastfed. <br>Write Y if still EBF or N if no longer EBF then write the date below when the infant was assessed.</p></th>
                                <th rowspan="4">No.</th>
                                <th colspan="11">6-11 months old</th>
                                <th colspan="6">12 months old</th>
                                <th rowspan="4">CIC<br><p>(date)</p></th>
                                <th colspan="8">0-11 months old</th>
                                <th rowspan="4">Remarks</th>
                            </tr>
                            <tr>
                                <th rowspan="3">TT2/Td2 given to the mother a month<br> prior to delivery (for mothers<br> pregnant for the first time) </th>
                                <th rowspan="3">TT3/Td3 to TT5/Td5 (or TT1/Td1 to TT5/Td5)<br> given to the mother anytime<br> prior to delivery</th>
                                <th rowspan="3">Length at Birth<br><p>(cm)</p></th>
                                <th rowspan="3">Weigh at Birth<br><p>(kg)</p></th>
                                <th>Status<br><p>(Birth Weight)</p></th>
                                <th rowspan="3">Initiated breast<br><p>feeding immediately after birth lasting for 90 minutes<br>(date)</p></th>
                                <th colspan="2">Immunization</th>
                                <th colspan="4">Nutritional Status Assessment</th>
                                <th colspan="3">Low birth weight given Iron<br><p>(Write the date)</p></th>
                                <th colspan="10">Immunization<br><p>(Write the date)</p></th>
                                <th colspan="4">Nutritional Status Assessment</th>
                                <th rowspan="3">Exclusively Breastfed* up to 6 months<br><p>Write Y if Yes or N if No <br>then write the date below when the infant was assessed</p></th>
                                <th colspan="2">Introduction of Complementary Feeding**<br> at 6 months old</th>
                                <th rowspan="3">Vitamin A<br><p>(date given)</p></th>
                                <th rowspan="3">MNP<br><p>(date when 90 sachets given)</p></th>
                                <th rowspan="3">MMR<br><p>Dose 1 at 9th month<br>(date given)</p></th>
                                <th rowspan="3">IPV<br><p>Dose 2 at 9th month (Routine)<br>(date given)</p></th>
                                <th colspan="4">Nutritional Status Assessment</th>
                                <th rowspan="3">MMR<br><p>Dose 2 at 12th month<br>(date given)</p></th>
                                <th rowspan="3">FIC***<br><p>(date)</p></th>
                                <th colspan="4">MAM</th>
                                <th colspan="4">SAM without Complication</th>
                            </tr>
                            <tr>
                                <th rowspan="2">L: low: <2,500gms<br>N: normal: ≥2,500gms<br>U: unknown</th>
                                <th rowspan="2">BCG<br><p>(date)</p></th>
                                <th rowspan="2">Hepa B-BD<br><p>(date)</p></th>
                                <th rowspan="2">Age in months</th>
                                <th rowspan="2">Length<br><p>(cm) <br>& date taken</p></th>
                                <th rowspan="2">Weight <p>(kg)<br>& date  taken</p></th>
                                <th rowspan="2">Status<br><p>S = stunted<br>W-MAM = wasted-MAM<br>W-SAM = wasted-SAM<br>O = obese/ overweight<br>N = normal</p></th>
                                <th rowspan="3">1mo</th>
                                <th rowspan="3">2mos</th>
                                <th rowspan="3">3mos</th>
                                <th colspan="3">DPT-HiB-HepB</th>
                                <th colspan="3">OPV</th>
                                <th colspan="3">IPV</th>
                                <th>IPV</th>
                                <th rowspan="2">Age in months</th>
                                <th rowspan="2">Length<br><p>(cm) <br>& date taken</p></th>
                                <th rowspan="2">Weight <p>(kg)<br>& date  taken</p></th>
                                <th rowspan="2">Status<br><p>S = stunted<br>W-MAM = wasted-MAM<br>W-SAM = wasted-SAM<br>O = obese/ overweight<br>N = normal</p></th>
                                <th rowspan="2">Y or N</th>
                                <th rowspan="2">1 - With continuous breastfeeding<br>2 - no longer breastfeeding or never breastfed</th>
                                <th rowspan="2">Age in months</th>
                                <th rowspan="2">Length<br><p>(cm) <br>& date taken</p></th>
                                <th rowspan="2">Weight <p>(kg)<br>& date  taken</p></th>
                                <th rowspan="2">Status<br><p>S = stunted<br>W-MAM = wasted-MAM<br>W-SAM = wasted-SAM<br>O = obese/ overweight<br>N = normal</p></th>
                                <th>Admitted in SFP</th>
                                <th>Cured</th>
                                <th>Defaulted</th>
                                <th>Died</th>
                                <th>Admitted in OTC</th>
                                <th>Cured</th>
                                <th>Defaulted</th>
                                <th>Died</th>
                            </tr>
                            <tr>
                                <th>1st dose<br>1 ½ mos</th>
                                <th>2nd dose<br>2 ½ mos</th>
                                <th>3rd dose<br>3 ½ mos</th>
                                <th>1st dose<br>1 ½ mos</th>
                                <th>2nd dose<br>2 ½ mos</th>
                                <th>3rd dose<br>3 ½ mos</th>
                                <th>1st dose<br>1 ½ mos</th>
                                <th>2nd dose<br>2 ½ mos</th>
                                <th>3rd dose<br>3 ½ mos</th>
                                <th>1st dose<br>3 ½ mos</th>
                                <th>1 ½ mos.</th>
                                <th>2 ½ mos.</th>
                                <th>3 ½ mos.</th>
                                <th>4-5 mos.</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
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

<?php //include 'modal/dispensed medicine/modal.php'; ?>
<!-- js -->
<?php include 'includes/footer.php'; ?>
<!--
<script>
$(document).ready(function() {
    // Function to fetch dispensed medicines and populate the DataTable
    function fetchDispensedMedicines() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        var dataTable = $('#dataTable').DataTable({
            columns: [
                //{ data: 'patient_id', orderable: true }, // Dispensed ID
                //{ data: 'patient_no', orderable: true }, // Patient Number
                //{ data: 'patient_name', orderable: true }, // Patient Name
                { data: 'medicine_brand', orderable: true }, // Medicine Brand
                { data: 'generic', orderable: true }, // Generic
                { data: 'medicine_name', orderable: true }, // Medicine Name
                { data: 'available_quantity', orderable: true }, // Quantity Dispensed
                { data: 'category', orderable: true }, // Category
                { data: 'quantity_dispensed', orderable: true }, // Quantity Dispensed
                { data: 'lot_number', orderable: true }, // Lot Number
                // { data: 'expiry_date', orderable: true }, // Expiry Date
                // { data: 'dispensed_date', orderable: true }, // Dispensed Date
                //{ data: 'prescribing_doctor', orderable: true }, // Prescribing Doctor
                //{ data: 'dispensing_officer', orderable: true } // Dispensing Officer
                // Uncomment the action column if you decide to implement it
                // {
                //     data: null,
                //     orderable: false,
                //     render: function(data) {
                //         return `
                //         <div class="table-actions">
                //             <a href="#" class="edit-btn" data-id="${data.dispensed_id}">
                //                 <img src="assets/img/icons/edit.svg" alt="Edit">
                //             </a>
                //             <a href="#" class="delete-btn" data-id="${data.dispensed_id}">
                //                 <img src="assets/img/icons/delete.svg" alt="Delete">
                //             </a>
                //         </div>`;
                //     }
                // }
            ]
        });

        $.ajax({
            url: 'model/reports/low_stock.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                dataTable.clear().rows.add(data).draw();
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed: ' + status + ', ' + error);
                $('#errorContainer').text('Error loading data: ' + error).show();
            }
        });
    }

    // // Add dispensed medicine form submission
    // $('#addDispensedMedicineForm').submit(function(e) {
    //     e.preventDefault();

    //     $.ajax({
    //         type: "POST",
    //         url: "model/dispensed_medicine/add_.php",
    //         data: $(this).serialize(),
    //         success: function(response) {
    //             $('#addDispensedMedicineModal').modal('hide');
    //             $('#addDispensedMedicineForm')[0].reset();
    //             Swal.fire({
    //                 title: 'Success!',
    //                 text: 'Dispensed medicine added successfully',
    //                 icon: 'success',
    //                 confirmButtonText: 'OK'
    //             }).then(function() {
    //                 fetchDispensedMedicines();
    //             });
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire({
    //                 title: 'Warning!',
    //                 text: 'Error adding dispensed medicine: ' + error,
    //                 icon: 'warning',
    //                 confirmButtonText: 'OK'
    //             });
    //         }
    //     });
    // });

    // // Edit dispensed medicine button click event
    // $('#dataTable').on('click', '.edit-btn', function(e) {
    //     e.preventDefault();
    //     var dispensedId = $(this).data('id');
    //     $.ajax({
    //         url: 'model/dispensed_medicine/get_.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         data: { dispensedId: dispensedId },
    //         success: function(response) {
    //             $('#editDispensedId').val(response.dispensed_id);
    //             $('#editPatientName').val(response.patient_name);
    //             $('#editMedicineName').val(response.medicine_name);
    //             $('#editQuantityDispensed').val(response.quantity_dispensed);
    //             $('#editDispensedDate').val(response.dispensed_date);
    //             $('#editDispensedMedicineModal').modal('show');
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Error fetching dispensed medicine data:', error);
    //         }
    //     });
    // });

    // // Edit dispensed medicine form submission
    // $('#editDispensedMedicineForm').submit(function(e) {
    //     e.preventDefault();
        
    //     $.ajax({
    //         type: "POST",
    //         url: "model/dispensed_medicine/edit_.php",
    //         data: $(this).serialize(),
    //         success: function(response) {
    //             $('#editDispensedMedicineModal').modal('hide');
    //             Swal.fire({
    //                 title: 'Success!',
    //                 text: 'Dispensed medicine updated successfully',
    //                 icon: 'success',
    //                 confirmButtonText: 'OK'
    //             }).then(function() {
    //                 fetchDispensedMedicines();
    //             });
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire({
    //                 title: 'Warning!',
    //                 text: 'Error updating dispensed medicine: ' + error,
    //                 icon: 'warning',
    //                 confirmButtonText: 'OK'
    //             });
    //         }
    //     });
    // });

    // // Delete dispensed medicine button click event
    // $('#dataTable').on('click', '.delete-btn', function(e) {
    //     e.preventDefault();
    //     var dispensedId = $(this).data('id');

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: 'You are about to delete this dispensed medicine. This action cannot be undone.',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!',
    //         cancelButtonText: 'Cancel'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             deleteDispensedMedicine(dispensedId);
    //         }
    //     });
    // });

    // function deleteDispensedMedicine(dispensedId) {
    //     $.ajax({
    //         url: 'model/dispensed_medicine/del_.php',
    //         type: 'GET',
    //         data: { dispensedId: dispensedId },
    //         success: function(response) {
    //             Swal.fire({
    //                 title: 'Success!',
    //                 text: 'Dispensed medicine deleted successfully',
    //                 icon: 'success',
    //                 confirmButtonText: 'OK'
    //             }).then(function() {
    //                 fetchDispensedMedicines();
    //             });
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire({
    //                 title: 'Error!',
    //                 text: 'Error deleting dispensed medicine: ' + error,
    //                 icon: 'error',
    //                 confirmButtonText: 'OK'
    //             });
    //         }
    //     });
    // }

    fetchDispensedMedicines();
});
</script>

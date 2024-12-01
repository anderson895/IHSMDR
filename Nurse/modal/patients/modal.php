<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Add Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addPatientForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="patientNo" class="form-label">Patient No</label>
                            <input type="text" class="form-control" id="patientNo" name="patient_no" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middleName" name="middle_name">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="sex" class="form-label">Sex</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="" disabled selected>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="medicineId" class="form-label">Medicine</label>
                            <select class="form-control" id="medicineId" name="medicine_id" required>
                                <option value="" selected disabled>Choose Medicine</option>
                                <!-- PHP for fetching medicines -->
                                <?php
                                    $MedicineClass = new MedicineClass($conn);
                                    $Medicines = $MedicineClass->fetchMedicines();
                                    if ($Medicines->num_rows > 0) {
                                        while ($medicines = $Medicines->fetch_assoc()) {
                                            echo '<option value="' . $medicines['medicine_id'] . '">' . $medicines['medicine_name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No medicines available</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="qty" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="quantity" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="prescribingDoctor" class="form-label">Prescribing Doctor</label>
                            <input type="text" class="form-control" id="prescribingDoctor" name="prescribing_doctor" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="dispensingOfficer" class="form-label">Dispensing Officer</label>
                            <input type="text" class="form-control" id="dispensingOfficer" name="dispensing_officer" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editPatientForm">
                <div class="modal-body">
                    <input type="hidden" id="editPatientId" name="id">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="editPatientNo" class="form-label">Patient No</label>
                            <input type="text" class="form-control" id="editPatientNo" name="patient_no" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editMiddleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="editMiddleName" name="middle_name">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" name="last_name" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editAge" class="form-label">Age</label>
                            <input type="number" class="form-control" id="editAge" name="age" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editSex" class="form-label">Sex</label>
                            <select class="form-control" id="editSex" name="sex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editMedicineId" class="form-label">Medicine</label>
                            <input type="text" class="form-control" id="editMedicineId" name="medicine_id" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editDate" name="date" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editPrescribingDoctor" class="form-label">Prescribing Doctor</label>
                            <input type="text" class="form-control" id="editPrescribingDoctor" name="prescribing_doctor" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editDispensingOfficer" class="form-label">Dispensing Officer</label>
                            <input type="text" class="form-control" id="editDispensingOfficer" name="dispensing_officer" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

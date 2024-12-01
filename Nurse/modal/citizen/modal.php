<!-- Modal for Adding/Editing Citizen -->
<div class="modal fade" id="citizenModal" tabindex="-1" role="dialog" aria-labelledby="citizenModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header ">
            <h5 class="modal-title text-gray" id="citizenModalLabel" >Register a New Citizen</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
            </button>
         </div>
         <form id="citizenForm" class="p-3">
            <!-- Step 1: Personal Details -->
            <h5 class="alert alert-light" style="background-color:#ff9f301f;">Personal Details</h5>
            <section>
               <div class="row">
                  <div class="col-md-3 mb-3 form-group">
                     <label for="firstName">First Name</label>
                     <input type="text" class="form-control" id="firstName" name="firstName" required />
                  </div>
                  <div class="col-md-3 mb-3 form-group">
                     <label for="lastName">Last Name</label>
                     <input type="text" class="form-control" id="lastName" name="lastName" required />
                  </div>
                  <div class="col-md-3 mb-3 form-group">
                     <label for="middleName">Middle Name</label>
                     <input type="text" class="form-control" id="middleName" name="middleName" />
                  </div>
                  <div class="col-md-3 mb-3 form-group">
                     <label for="suffix">Suffix</label>
                     <select class="form-control" id="suffix" name="suffix">
                        <option value="" selected disabled>Select Suffix</option>
                        <option value="">N/A</option>
                        <option value="Jr">Jr</option>
                        <option value="Sr">Sr</option>
                        <option value="III">III</option> <!-- You can add more suffix options as needed -->
                        <option value="IV">IV</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3 form-group">
                     <label for="birthdate">Birthdate</label>
                     <input type="date" class="form-control" id="birthdate" name="birthdate" required />
                  </div>
                  <div class="col-md-6 mb-3 form-group">
                     <label for="gender">Gender</label>
                     <select class="form-control" id="gender" name="gender" required>
                        <option value="" selected disabled>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3 form-group">
                     <label for="mobileNo">Mobile No.</label>
                     <input type="text" class="form-control" id="mobileNo" name="mobileNo" placeholder="Enter your mobile number" required />
                  </div>
                  <div class="col-md-6 mb-3 form-group">
                     <label for="email">Email</label>
                     <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required />
                  </div>
               </div>
            </section>
            <!-- Step 2: Address Details -->
            <h5 class="alert alert-light" style="background-color:#ff9f301f;">Address Details</h5>
            <section>
               <div class="row">
                  <div class="col-md-6 mb-3 form-group">
                     <label for="province">Province</label>
                     <select class="form-control" id="province" name="province" onchange="populateMunicipalities()" required>
                        <option value="" selected disabled>Select Province</option>
                     </select>
                  </div>
                  <div class="col-md-6 mb-3 form-group">
                     <label for="municipality">City</label>
                     <select class="form-control" id="municipality" name="municipality" onchange="populateBarangays()" required>
                        <option value="" selected disabled>Select City</option>
                     </select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3 form-group">
                     <label for="barangay">Barangay</label>
                     <select class="form-control" id="barangay" name="barangay" required>
                        <option value="" selected disabled>Select Barangay</option>
                     </select>
                  </div>
                  <div class="col-md-6 mb-3 form-group">
                     <label for="address">House No./Street/Purok</label>
                     <input type="text" class="form-control" id="address" name="address" placeholder="House No./Street/Purok"  />
                  </div>
               </div>
            </section>
                    <!-- Add Head of Family Section -->
                 <h5 class="alert alert-light" style="background-color:#ff9f301f;">Family Information</h5>
                     <section>
                        <div class="form-floating mb-3">
                           <select class="form-select" id="headOfFamily" name="headOfFamily" aria-label="Head of Family">
                              <option value="" disabled selected>Are you the head of the family?</option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                           </select>
                           <label for="headOfFamily">Head of Family</label>
                        </div>

                        <!-- Family Members List -->
                        <div class="mb-3">
                           <label for="familyMembers" class="form-label">List of Family Members:</label>
                           <textarea class="form-control" id="familyMembers" name="familyMembers" rows="3" placeholder="Enter family members (e.g., Name)"></textarea>
                        </div>
                     </section>
            <!-- Step 3: Other Details -->
            <h5 class="alert alert-light" style="background-color:#ff9f301f;">Other Details</h5>
            <section>
               <div class="row">
                  <div class="col-md-4 mb-3 form-group">
                     <label for="sector">Sector</label>
                     <select class="form-control form-select" id="sector" name="sector" placeholder="Sector">
                        <option value="" selected disabled>Select</option>
                        <option value="Women">Women</option>
                        <option value="Man">Man</option>
                        <option value="Youth">Youth</option>
                        <option value="Senior Citizens">Senior Citizens</option>
                        <option value="Deceased">Deceased</option>
                        <option value="Patient">Patient</option>
                     </select>
                  </div>
                  <div class="col-md-4 mb-3 form-group">
                     <label for="registeredVoter">Registered Voter</label>
                     <select class="form-control" id="registeredVoter" name="registeredVoter" >
                        <option value="" selected disabled>Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                     </select>
                  </div>
                  <div class="col-md-4 mb-3 form-group">
                     <label for="religion">Religion</label>
                     <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion" />
                  </div>
               </div>
               <div class="mb-3">
                  <div class="form-floating form-floating-outline">
                     <select class="form-control form-select" id="affiliation" name="affiliation"  >
                        <option value="" selected disabled></option>
                        <option value="Atin">Atin</option>
                        <option value="Hindi">Hindi</option>
                        <option value="Undecided">Undecided</option>
                        <option value="Unidentified">Unidentified</option>
                     </select>
                     <label for="affiliation">Affiliation</label>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 mb-3 form-group">
                     <label for="frontValidId">Front Valid ID</label>
                     <input type="file" class="form-control" id="frontValidId" name="frontValidId" accept="image/*"  />
                  </div>
                  <div class="col-md-6 mb-3 form-group">
                     <label for="backValidId">Back Valid ID</label>
                     <input type="file" class="form-control" id="backValidId" name="backValidId" accept="image/*"  />
                  </div>
               </div>

               <div class="row uploaded-id-section">
               <div class="col-md-6 mb-3">
                  <div class="container">
                        <h5 class="alert alert-light">Uploaded Valid ID</h5>
                        <div class="row id-images-container">
                           <div class="col-md-6 mb-3">
                              <div class="image-container">
                                    <img id="frontValidIdImage" src="path_to_front_image.jpg" alt="Front Valid ID" class="id-image" data-bs-toggle="modal" data-bs-target="#imageModal"/>
                                    <span class="image-label">Front</span>
                              </div>
                           </div>
                           <div class="col-md-6 mb-3">
                              <div class="image-container">
                                    <img id="backValidIdImage" src="path_to_back_image.jpg" alt="Back Valid ID" class="id-image" data-bs-toggle="modal" data-bs-target="#imageModal"/>
                                    <span class="image-label">Back</span>
                              </div>
                           </div>
                        </div>
                  </div>
               </div>
            </div>
            <div class="mb-3 d-flex justify-content-end">
               <button type="submit" class="btn btn-primary">Save</button>
            </div>

            </section>
         
         </form>
      </div>
   </div>
</div>


<!-- Bootstrap Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel"> Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
            </button>
         </div>
         <div class="modal-body text-center">
            <img src="" class="img-fluid" id="modalImage" alt="ID Image" width="60%">
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Assistance History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
            </button>
            </div>
                <div id="citizenDetails" class="mb-3">
                </div>
                <div class="table-responsive">
                <table id="historyTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type of Assistance</th>
                            <th>Endorsed By</th>
                            <th>Amount Redeemed</th>
                            <th>Date Redeemed</th>
                            <th>Files</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

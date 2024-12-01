<!-- Add User Modal -->
<div class="modal fade" id="adduserModal" tabindex="-1" role="dialog" aria-labelledby="adduserModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header text-dark">
            <h5 class="modal-title" id="adduserModalLabel">New User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
         </div>
         <form id="addUserForm">
            <div class="modal-body">
               <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" class="form-control" id="firstName" name="firstName" required>
               </div>
               <div class="form-group">
                  <label for="lastName">Last Name</label>
                  <input type="text" class="form-control" id="lastName" name="lastName" required>
               </div>
             
               <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
               </div>
               <div class="form-group">
                  <label for="password" class="mr-2">Password</label>
                  <div class="input-group">
                     <input type="password" class="form-control mr-2" id="password" name="password" minlength="8" required>
                     <button class="btn btn-outline-secondary mr-2" type="button" id="generatePassword">Generate</button>
                     <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                     </button>
                  </div>
                  <small class="form-text text-muted ml-2">Should be 8 characters long with uppercase, lowercase, number, and special character.</small>
               </div>
               <div class="form-group" hidden>
                  <label for="userType">User Type</label>
                  <select class="form-control" id="userType" name="userType" required>
                     <option value="staff">Staff</option>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>

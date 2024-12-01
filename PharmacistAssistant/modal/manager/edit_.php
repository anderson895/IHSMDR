<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-dark">
                <h5 class="modal-title" id="editUserModalLabel">Edit Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                   <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editUserForm">
                <input type="hidden" id="editUserId" name="editUserId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editFirstName">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="editFirstName" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" name="editLastName" required>
                    </div>
               
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="editPassword" class="mr-2">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control mr-2" id="editPassword" name="editPassword" minlength="8">
                            <button class="btn btn-outline-secondary mr-2" type="button" id="generateEditPassword">Generate</button>
                            <button class="btn btn-outline-secondary" type="button" id="toggleEditPassword">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted ml-2">Optional. Should be 8 characters long with uppercase, lowercase, number, and special character.</small>
                    </div>
                    <div class="form-group" hidden>
                        <label for="editUserType">User Type</label>
                        <select class="form-control" id="editUserType" name="editUserType" required>
                            <option value="barangay">Barangay User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


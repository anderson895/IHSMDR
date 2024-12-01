
<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMedicineLabel">Add Medicine</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
      </div>
      <div class="modal-body">
        <form id="addMedicineForm">
          <div class="mb-3">
            <label for="medicineBrand" class="form-label">Medicine Brand</label>
            <input type="text" class="form-control" id="medicineBrand" name="medicineBrand" required>
          </div>
          <div class="mb-3">
            <label for="generic" class="form-label">Generic</label>
            <input type="text" class="form-control" id="generic" name="generic" required>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="Tablet">Tablet</option>
                <option value="Capsule">Capsule</option>
            </select>
        </div>
          <div class="mb-3">
            <label for="medicineName" class="form-label">Medicine Name</label>
            <input type="text" class="form-control" id="medicineName" name="medicineName" required>
          </div>
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
          <div class="mb-3">
            <label for="lotNumber" class="form-label">Lot Number</label>
            <input type="text" class="form-control" id="lotNumber" name="lotNumber" required>
          </div>
          
          <div class="mb-3">
            <label for="expiryDate" class="form-label">Expiry Date</label>
            <input type="date" class="form-control" id="expiryDate" name="expiryDate" required>
          </div>
          
          <button type="submit" class="btn btn-primary">Add Medicine</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Edit Medicine Modal -->
<div class="modal fade" id="editMedicineModal" tabindex="-1" aria-labelledby="editMedicineLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMedicineLabel">Edit Medicine</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
               <i class="fas fa-times"></i>
            </button>
      </div>
      <div class="modal-body">
        <form id="editMedicineForm">
          <input type="hidden" id="editMedicineId" name="medicineId">
          <div class="mb-3">
            <label for="editMedicineBrand" class="form-label">Medicine Brand</label>
            <input type="text" class="form-control" id="editMedicineBrand" name="medicineBrand" required>
          </div>
          <div class="mb-3">
            <label for="editGeneric" class="form-label">Generic</label>
            <input type="text" class="form-control" id="editGeneric" name="generic" required>
          </div> 
          <div class="mb-3">
            <label for="editCategory" class="form-label">Category</label>
            <select class="form-select" id="editCategory" name="category" required>
                <option value="">Select Category</option>
                <option value="Tablet">Tablet</option>
                <option value="Capsule">Capsule</option>
            </select>
        </div>
          <div class="mb-3">
            <label for="editMedicineName" class="form-label">Medicine Name</label>
            <input type="text" class="form-control" id="editMedicineName" name="medicineName" required>
          </div>
          
          <div class="mb-3">
            <label for="editQuantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
          </div>
          <div class="mb-3">
            <label for="editLotNumber" class="form-label">Lot Number</label>
            <input type="text" class="form-control" id="editLotNumber" name="lotNumber" required>
          </div>
          <div class="mb-3">
            <label for="editExpiryDate" class="form-label">Expiry Date</label>
            <input type="date" class="form-control" id="editExpiryDate" name="expiryDate" required>
          </div>
         
          <button type="submit" class="btn btn-primary">Update Medicine</button>
        </form>
      </div>
    </div>
  </div>
</div>

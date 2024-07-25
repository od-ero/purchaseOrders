<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="update_role_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Supplier</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="update_role_form">
      @csrf
      <input class="form-control" id="role_id" type="text" name="role_id" placeholder="role_id" hidden/>
            <div class="form-floating login_form_password my-3">
                <input class="form-control" id="role_name" type="text" name="role_name" placeholder="role_name" />
                <label for="role_name">Role Name<strong class="text-danger">*</strong></label>
                <div id="role_name_error" class="text-danger mt-2" style="display: none;">
                    <!-- Error message will be inserted here by jQuery -->
                </div>
            </div>
            <div class="form-group">
                <strong>Permission:</strong>
                <div id="permissions_container">
                    <!-- Checkboxes will be inserted here by jQuery -->
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Save
                </button>
            </div> 
        </form>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="delete_role_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">Delete Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       Are you sure you want to delete this Role?
       <form >
        <input type="text" id="delete_role_id" name="delete_role_id" hidden>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="delete_role_button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="activate_supplier_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">Activate Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       Are you sure you want to active this Supplier?
       <form >
        <input type="text" id="activate_supplier_id" name="activate_supplier_id" hidden>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="activate_supplier" class="btn btn-success">Activate</button>
      </div>
    </div>
  </div>
</div>
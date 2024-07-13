<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="update_employees_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="update_employee_form" name="update_employee_form" >
        @csrf
        <div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>
        <input type="hidden" name="user_id" id="update_user_id">
        <div class="row mb-3">
        
                <div class="col-md-4">
                    <div class="form-floating  mb-3 mb-md-0">
                        <input class="form-control" id="register_first_name" name="first_name" value="" type="text" placeholder="Enter user first name"   />
                        <label for="inputPassword">First Name  &emsp; <strong class="text-danger" >*</strong></label>
                        @if ($errors->has('first_name'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('first_name') }}
                            </div>
                        @endif
                    </div>
                </div>
                    <div class="col-md-4">
                <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="register_middle_name" name="middle_name" type="text" placeholder="Enter other names" />
                        <label for="inputPassword">Middle Names</label>
                        @if ($errors->has('mName'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('mName') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="register_last_name" name="last_name" type="text" placeholder="Enter your last name"   />
                        <label for="inputPassword">Last Name &emsp; <strong class="text-danger text-right" >*</strong></label>
                        @if ($errors->has('lName'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('lName') }}
                            </div>
                        @endif
                    </div>
                </div>
                
            </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" id="register_id_no" name="id_no" type="text" placeholder="Enter user id number"   />
                <label for="inputPassword">Id Number &emsp; <strong class="text-danger text-right" >*</strong></label>
                @if ($errors->has('id_no'))
                    <div class="text-danger mt-2">
                        {{ $errors->first('id_no') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" id="register_staff_no" name="staff_no" type="text" placeholder="Enter user staff number"   />
                <label for="inputPassword">Staff Number </label>
                @if ($errors->has('staff_no'))
                    <div class="text-danger mt-2">
                        {{ $errors->first('staff_no') }}
                    </div>
                @endif
        </div>
    </div>
            
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" id="register_phone" name="phone" type="tel" placeholder="Enter user phone No"   />
                <label for="inputPassword">Phone Number &emsp; <strong class="text-danger text-right" >*</strong></label>
                @if ($errors->has('phone'))
                    <div class="text-danger mt-2">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>
        </div>
    <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" id="register_second_phone" name="second_phone" type="text" placeholder="Enter user second phone No" />
                <label for="inputPassword">Phone Number 2</label>
                @if ($errors->has('sPhone'))
                    <div class="text-danger mt-2">
                        {{ $errors->first('sPhone') }}
                    </div>
                @endif
            </div>
    </div>
    </div>  
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" id="register_email" name="email" type="email" placeholder="Enter user email"   />
                <label for="inputEmail">Email</label>
                @if ($errors->has('email'))
                    <div class="text-danger mt-2">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            </div>
        <div class="col-md-6">
            <div class="form-floating mb-3 mb-md-0">
                <input class="form-control" id="register_phy_address" name="phy_address" type="text" placeholder="Enter user physical address"   />
                <label for="inputPassword">Address</label>
                @if ($errors->has('phy_address'))
                    <div class="text-danger mt-2">
                        {{ $errors->first('phy_address') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
        </form>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="delete_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">Delete Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       Are you sure you want to delete this employee?
       <form >
        <input type="text" id="delete_user_id" name="delete_user_id" hidden>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="delete_user" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="activate_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title" id="exampleModalLabel">Activate Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       Are you sure you want to active this employee?
       <form >
        <input type="text" id="activate_user_id" name="activate_user_id" hidden>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="activate_user" class="btn btn-success">Activate</button>
      </div>
    </div>
  </div>
</div>
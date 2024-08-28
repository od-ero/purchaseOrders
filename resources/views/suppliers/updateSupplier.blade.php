<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="update_supplier_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Supplier</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="update_supplier_form" >
                            @csrf
                            <input class="form-control" id="update_supplier_id" name="update_supplier_id" type="text" placeholder="Enter user first name"  hidden/>
                            <div class="row mb-3">
                                        <div class="form-floating  mb-3 mb-md-0">
                                            <input class="form-control" id="create_supplier_name" name="create_supplier_name" type="text" placeholder="Enter user first name"   />
                                            <label for="inputPassword">Name &emsp; <strong class="text-danger" >*</strong></label>
                                            @if ($errors->has('first_name'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="create_supplier_kra" name="create_supplier_kra" type="text" placeholder="Enter user id number"   />
                                            <label for="inputPassword">KRA PIN &emsp; </label>
                                            @if ($errors->has('id_no'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('id_no') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="create_supplier_number" name="create_supplier_number" type="text" placeholder="Enter supplier number"   />
                                            <label for="inputsupplierNumber">Supplier Number &emsp; </label>
                                            @if ($errors->has('supplier_number'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('supplier_number') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="create_supplier_phone" name="create_supplier_phone" type="tel" placeholder="Enter user phone No"   />
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
                                            <input class="form-control" id="create_supplier_second_phone" name="create_supplier_second_phone" type="tel" placeholder="Enter user second phone No" />
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
                                                <input class="form-control" id="create_supplier_email" name="create_supplier_email" type="email" placeholder="Enter user email"   />
                                                <label for="inputEmail">Email&emsp; <strong class="text-danger text-right" >*</strong></label>
                                                @if ($errors->has('email'))
                                                    <div class="text-danger mt-2">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="create_supplier_phy_address" name="create_supplier_phy_address" type="text" placeholder="Enter user physical address"   />
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



<div class="modal fade" id="delete_supplier_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">Delete Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       Are you sure you want to delete this supplier?
       <form >
        <input type="text" id="delete_supplier_id" name="delete_supplier_id" hidden>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="delete_supplier" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="activate_supplier_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
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
        <button type="button" id="activate_supplier" class="btn btn-primary">Activate</button>
      </div>
    </div>
  </div>
</div>
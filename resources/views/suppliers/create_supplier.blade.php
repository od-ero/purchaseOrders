@extends('layouts.my_app')
@section('subtitle')
    Create Supplier
@endsection

@section('contentheader_title')
  Create Supplier
@endsection


@section('content')

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create a Supplier</h3></div>
                        <div class="card-body">
                            <form id="create_supplier_form" >
                            @csrf
                            <div class="row mb-3">
                                        <div class="form-floating  mb-3 mb-md-0">
                                            <input class="form-control" id="create_supplier_name" name="create_supplier_name" type="text" placeholder="Enter user first name"   />
                                            <label for="inputPassword">Name </label>
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
                                            <label for="inputPassword">Supplier Number &emsp; </label>
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
                                
                                <div class="mt-4 mb-0 text-center">
                                    <button type="submit" id="register_save_view" class="btn btn-primary  btn-submit">Save and View</button>  
                                        <button type="submit" id="register_save_and_add_new" class="btn btn-secondary">Save and Add New</button>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

          
       

          
@endsection



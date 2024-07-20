@extends('layouts.my_app')
@section('subtitle')
View Suppliers
@endsection

@section('contentheader_title')
  View Suppliers
@endsection

@section('content')
<div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Supplier Details</h3></div>
                        <div class="card-body">
                        @include('suppliers.updateSupplier');
                    <table  class="table table-bordered data-table">
                      <form>
                        <input type="text" value="view" id="action_url" name="action_url" hidden>
                      </form>
                         <thead>
                              
                            </thead>
                            <tbody>
                              <tr>
                                <td style="font-weight: bold;">Name</td>
                                <td>{{$supplier_details['supplier_name']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Number</td>
                                <td>{{$supplier_details['supplier_no']}}</td>
                              </tr>

                              <tr>
                                <td style="font-weight: bold;">KRA PIN</td>
                                <td>{{$supplier_details['supplier_kra_pin']}}</td>
                              </tr>
                              
                              <tr>
                                <td style="font-weight: bold;">Phone</td>
                                
                                <td>{{$supplier_details['supplier_phone']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Second Phone</td>
                                
                                <td>{{$supplier_details['supplier_second_phone']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Email</td>
                                <td>{{$supplier_details['supplier_email']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Address</td>
                                <td>{{$supplier_details['supplier_phy_address']}}</td>
                              </tr>
                            </tbody>
                          </table>
                          <a class="btn btn-info btn-sm" id="back_button"
                          style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                          <a class="btn btn-primary btn-sm"  data-id="{{ base64_encode($supplier_details['id'])}}" id="update_suppliers_details" href="#">Edit</i></a>
                          @if ($supplier_details['deleted_at'] == null)
                          <a class="btn btn-success btn-sm"  data-id="{{ base64_encode($supplier_details['id'])}}" id="delete_supplier_button" href="#">Delete</i></a>
                          @endif
                          @if ($supplier_details['deleted_at'])
                          <a class="btn btn-success btn-sm" data-id="{{ base64_encode($supplier_details['id'])}}" id="activate_supplier_button" href="#">Activate</i></a>
                          @endif
                         
                      </div>
                    </div>
                </div>
            </div>
@endsection
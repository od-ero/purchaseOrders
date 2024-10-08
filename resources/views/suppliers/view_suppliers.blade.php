@extends('layouts.my_app')
@section('subtitle')
View Suppliers
@endsection

@section('contentheader_title')
  View Suppliers
@endsection

@section('content')
<div class="row justify-content-center">
              <div class="col-lg-12">
                    <div class="card shadow-lg border-0 rounded-lg mt-2">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Supplier Details</h3></div>
                            <div class="card-body">
                                @include('suppliers.updateSupplier')

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
                                                  <td>{{$supplier_details['supplier_number']}}</td>
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
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                            <a class="btn btn-info btn-sm" id="back_button"
                                            style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                                            @can('edit-supplier')
                                            <a class="btn btn-primary btn-sm"  data-id="{{ base64_encode($supplier_details['id'])}}" id="update_suppliers_details" href="#">Edit</i></a>
                                            @endcan
                                            @if ($supplier_details['deleted_at'] == null)
                                              @can('destroy-supplier')
                                                <a class="btn btn-success btn-sm"  data-id="{{ base64_encode($supplier_details['id'])}}" id="delete_supplier_button" href="#">Delete</i></a>
                                              @endcan
                                            @endif
                                            @can('activate-supplier')
                                              @if ($supplier_details['deleted_at'])
                                                <a class="btn btn-success btn-sm" data-id="{{ base64_encode($supplier_details['id'])}}" id="activate_supplier_button" href="#">Activate</i></a>
                                              @endif
                                            @endcan
                                    </div>

                                    <nav>
                                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-imported-orders-tab" data-bs-toggle="tab" data-bs-target="#nav-imported-orders" type="button" role="tab" aria-controls="nav-imported-orders" aria-selected="true">Imported Orders</button>
                                        <button class="nav-link" id="nav-send-orders-tab" data-bs-toggle="tab" data-bs-target="#nav-send-orders" type="button" role="tab" aria-controls="nav-send-orders" aria-selected="false">Send Orders</button>
                                        
                                      </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                      <div class="tab-pane fade show active" id="nav-imported-orders" role="tabpanel" aria-labelledby="nav-imported-orders-tab">
                                        @include('orders.imported_orders_table')
                                      </div>
                                      <div class="tab-pane fade hide active" id="nav-send-orders" role="tabpanel" aria-labelledby="nav-send-orders-tab">
                                         @include('orders.send_orders_table')
                                      </div>
                                    </div>
                          </div>
                        </div>
                    </div>
                </div>
@endsection
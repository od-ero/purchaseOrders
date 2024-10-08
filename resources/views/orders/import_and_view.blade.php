@extends('layouts.my_app')

@section('subtitle')
 Import View
@endsection

@section('contentheader_title')
 Import View
@endsection

@section('content')
<div class="container-fluid px-4">
                        <h1 class="mt-4">Uploaded Orders</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Uploaded Orders</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                              Uploaded Orders
                            </div>
                            <div class="card-body">
                            <div class="row mb-3">
                               
                               <div class="col-md-3">
                                   <div class="form-floating  mb-3 mb-md-0">
                                    
                                       <input class="form-control" id="upload_and_view_batch_name" value="{{session('batch_details')[0]['batch_name']}}" name="batch_name" type="text" placeholder="Enter Batch Name"   />
                                       <label for="inputBatchName">Batch Name  </label>
                                       @if ($errors->has('supplier_name'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('mName') }}
                                           </div>
                                       @endif
                                   </div>
                               </div>
                                <div class="col-md-6">
                                    <div class="form-floating login_form_userid mb-3 mb-md-0">
                                    <select class="form-control appselect2" id="upload_and_view_supplier_id" name="supplier_id">
  
                                        @if(session('batch_details') && isset(session('batch_details')[0]['supplier_id']))
                                            @php
                                        
                                                $sessionSupplierId = session('batch_details')[0]['supplier_id'];
                                                $sessionSupplierName = session('batch_details')[0]['supplier_name'];

                                            @endphp
                                            
                                                <option value="{{ base64_encode($sessionSupplierId) }}" selected>
                                                    {{ $sessionSupplierName }} <strong class="text-danger">*</strong>
                                                </option>
                                        
                                        @endif
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ base64_encode($supplier['id']) }}">{{ $supplier['supplier_name'] }}</option>
                                        @endforeach
                                    </select>

                                            @if ($errors->has('supplier_name'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('supplier_name') }}
                                                </div>
                                            @endif
                                        </div>
                               </div>
                               <div class="col-md-3">
                               <div class="form-floating mb-3 mb-md-0">
                                       <input class="form-control" id="upload_and_view_order_number" name="order_number" type="text" value="{{session('batch_details')[0]['order_no']}}" placeholder="Enter Your Order Number"   />
                                       <label for="inputPassword">Order Number &emsp; <strong class="text-danger text-right" >*</strong></label>
                                       @if ($errors->has('lName'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('lName') }}
                                           </div>
                                       @endif
                                   </div>
                               </div>
                           </div>
                <table class="table table-bordered data-table" id="purchaseOrdersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 80px;">Quantity</th>
                            <th>Product Name</th>
                            <th style="width: 80px;">Cost</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $total_price=0 ?>
                
                        <form>
                                @foreach(session('data') as $index => $row)
                                <tr>
                                    <td class="order-id">{{ $index + 1 }}</td>
                                    <td  class="quantity"> <input id="quantity" value="{{ $row['quantity'] ?? '0' }}" style="width: 80px;"> </td>
                                    <td > <input id="product_name" value="{{ $row['product_name'] ?? '0' }}" style="width: 350px;"></td>
                                    <td class="price text-end"> <input id="price" value="{{ $row['price'] ?? '0' }}" class="text-end" style="width: 80px;"> </td> 
                                    <td class="subtotal text-end">{{$row['price'] * $row['quantity']}}</td>
                                </tr>
                                @endforeach
                        </form>
                    </tbody>
                </table>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <a class="btn btn-info btn-sm" id="back_button">
                        <i class="fa fa-backward"></i>
                    </a>
                    
                    @can('import-excel')
                    <button id="save_and_view" class="btn btn-primary">Save and View </button>
                    <button id="save_and_view_with_prices" class="btn btn-primary">Save and View PDF With Prices</button>
                    <button id="save_and_view_with_no_prices" class="btn btn-primary">Save and View PDF With No Prices</button>
                    @endcan

                    @can('send-order')
                    <button id="save_and_send" data-id="Yes" class="btn btn-primary">Save and Send Order With Prices</button>
                    <button id="save_and_send_with_no_prices" data-id="No" class="btn btn-primary">Save and Send Order With No Prices</button>
                    @endcan
                </div>
            
            </div>
                        </div>
                    </div>
</main>
<style>
    .total-row {
    font-weight: bold;
    background-color: #f9f9f9;
    text-align: right;
}
</style>                 
@endsection                   



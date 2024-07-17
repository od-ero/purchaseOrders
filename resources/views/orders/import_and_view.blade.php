@extends('layouts.my_app')

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
    <!-- Check if session has batch details and set the default selected option -->

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


                                            <!-- Display error message if there are any errors for 'supplier_name' -->
                                            @if ($errors->has('supplier_name'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('supplier_name') }}
                                                </div>
                                            @endif
                                        </div>
                               <!-- <div class="form-floating mb-3 mb-md-0">
                                       <input class="form-control" id="upload_and_view_supplier_name" name="supplier_name" type="text" value="{{ session('batch_details')[0]['supplier_name']}}" placeholder="Enter other names" />
                                       <label for="inputPassword">Supplier &emsp; <strong class="text-danger text-right" >*</strong></label>
                                       @if ($errors->has('supplier_name'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('mName') }}
                                           </div>
                                       @endif
                                   </div> -->
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
                <td class="price"> <input id="price" value="{{ $row['price'] ?? '0' }}" style="width: 80px;"> </td> 
                <td class="subtotal">{{$row['price'] * $row['quantity']}}</td>
            </tr>
           
            @endforeach
            </form>
            </tbody>
            </table>
            <button id="save_and_view" class="btn btn-primary">Save and View</button>
            <button id="save_and_send" class="btn btn-primary">Save and Send</button>
            </div>
                        </div>
                    </div>
</main>
<style>
    .total-row {
    font-weight: bold;
    background-color: #f9f9f9;
}
</style>                 
@endsection                   



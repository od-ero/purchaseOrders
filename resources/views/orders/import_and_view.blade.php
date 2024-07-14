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
                            <table class="table table-bordered data-table" id="purchaseOrdersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
            <?php $total_price=0 ?>
           
                @foreach(session('data') as $index => $row)

                <tr>
                    <td class="order-id">{{ $index + 1 }}</td>
                    <td contenteditable="true">{{ $row['product_name'] }}</td>
                    <td contenteditable="true" class="quantity">{{  $row['quantity'] }}</td>
                    <td contenteditable="true" class="price"> {{  $row['price'] }}</td>
                    <td contenteditable="true">{{ $row['description'] }}</td>
                    <td class="subtotal">{{ number_format($row['quantity'] * $row['price']) }}</td>
                </tr>
                <?php $total_price += $row['quantity'] * $row['price']; ?>
                @endforeach
            </tbody>
            </table>
            <button id="save_and_view" class="btn btn-primary">Save and View</button>
            </div>
                        </div>
                    </div>
                    </main
@endsection                   



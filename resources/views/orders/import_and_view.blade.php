@extends('layouts.my_app')

@section('content')
<div class="container">
    <!-- Table to display the uploaded data -->
    
    <div id="tableContainer" style="margin-top: 20px;">
        <table class="table table-bordered" id="purchaseOrdersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('data') as $index => $row)
                <tr>
                    <td class="order-id">{{ $index + 1 }}</td>
                    <td contenteditable="true">{{ $row['product_name'] }}</td>
                    <td contenteditable="true">{{ $row['quantity'] }}</td>
                    <td contenteditable="true">{{ $row['price'] }}</td>
                    <td contenteditable="true">{{ $row['description'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="save_and_view" class="btn btn-primary">Save and View</button>
    </div>
</div>


@endsection

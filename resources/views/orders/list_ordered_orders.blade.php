@extends('layouts.my_app')
@section('subtitle')
 Active suppliers
@endsection

@section('contentheader_title')
 Active Suppliers
@endsection

@section('content')
@include('orders.delete_orders')
<div class="container-fluid px-4">
                        <h1 class="mt-4">Ordered Batches</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Ordered Batches</li>
                        </ol>
                        @include('orders.send_orders_table')
                             
                    </div>
                    </main
@endsection                   
@extends('layouts.my_app')
@section('subtitle')
 Imported Batches
@endsection

@section('contentheader_title')
 Imported Batches
@endsection

@section('content')
@include('orders.delete_orders')
<div class="container-fluid px-4">
                        <h1 class="mt-4">Imported Batches</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Imported Batches</li>
                        </ol>
                        @include('orders.imported_orders_table')
                       
                    </div>
                    </main
@endsection                   
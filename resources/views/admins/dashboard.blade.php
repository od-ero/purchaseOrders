@extends('layouts.my_app')
@section('subtitle')
 Home
@endsection

@section('contentheader_title')
 Home
@endsection

@section('content')


    <main>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Home</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Home</li>
                </ol>
                <div class="row">
                @can('import-excel')
                    <div class="col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Import Excel</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="/import">Import</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                @endcan    
                @can('list-imported-batch')  
                    <div class="col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Imported Excel</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{route('orders.listImportedOrders')}}">List</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                @endcan    
               
                 @can('list-send-batch') 
                    <div class="col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Send Orders</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{route('orders.listOrderedOrders')}}">list</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                 @endcan
                 @can('list-active-supplier')   
                    <div class="col-md-6">
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body">Suppliers  ({{$suppliers}})</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{route('suppliers.listActiveSuppliers')}}">list</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                 @endcan   
                </div>
                
            </div>
        </div>  
    </div>

    </main>
@endsection
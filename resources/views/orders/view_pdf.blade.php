<!-- ttt -->
@extends('layouts.my_app')
@section('subtitle')
  Preview pdf
@endsection

@section('contentheader_title')
    Preview pdf
@endsection

@section('content')
<div class="container-fluid px-4">
<div class="container">
                        <div class="card mb-4">
                           
                            <div class="card-body">
                            <iframe src="data:application/pdf;base64,{{ $pdfContent }}" width="100%" height="600px"></iframe>
                                
                            </div>
                    </div>
        <div class="row">
        <div class="mb-4 col-auto">
        <a class="btn btn-info btn-sm" id="back_button"
        style="color: #fff !important;"><i class="fa fa-backward"></i></a>        
            </div>
           
            <div class="mb-4 col-auto">
                @can('send-order')
                    <a href="/make-orders/{{base64_encode($encoded_product_batch_id)}}?Query={{base64_encode('Yes')}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">Email PDF With Prices</a>   
                    <a href="/make-orders/{{base64_encode($encoded_product_batch_id)}}?Query={{base64_encode('No')}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">Email PDF With No Prices</a> 
                @endcan  
                 <a href="/orders/pdf/{{base64_encode($encoded_product_batch_id)}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">View With Prices</a>   
                 <a href="/orders/no-cost-pdf/{{base64_encode($encoded_product_batch_id)}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">View With No Prices</a>      
            </div>
        </div>
           


                    @endsection
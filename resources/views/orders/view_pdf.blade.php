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
            @can('send-order')
            <div class="mb-4 col-auto">

                 <a href="/make-orders/{{base64_encode($encoded_product_batch_id)}}?Query={{base64_encode('Yes')}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">Email PDF With Prices</a>   
                 <a href="/make-orders/{{base64_encode($encoded_product_batch_id)}}?Query={{base64_encode('No')}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">Email PDF With No Prices</a>       
            </div>
            @endcan
        </div>
           


                    @endsection
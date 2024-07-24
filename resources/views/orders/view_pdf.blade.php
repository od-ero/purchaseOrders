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
                 <a href="/create/fpdf/download/{{$encoded_product_batch_id}}" class="btn btn-outline-success btn-sm" tabindex="-1" role="button">back</a>        
            </div>
            <div class="mb-4 col-auto">
                 <a href="/send/mail/{{$encoded_product_batch_id}}" class="btn btn-outline-secondary btn-sm" tabindex="-1" role="button">Email PDF</a>        
            </div>
        </div>
           

<script>
                function setUnitId(unitId) {
                    document.getElementById('unitIdInput').value = unitId;
                }
            </script>
                    @endsection
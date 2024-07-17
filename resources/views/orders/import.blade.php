@extends('layouts.my_app')
@section('subtitle')
 Import product
@endsection

@section('contentheader_title')
  Import Product
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Import Excell</h3></div>
            <div class="card-body">
                <form id="import_and_view_form" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="batch_name" type="text" name="batch_name" placeholder="Batch Name" />
                        <label for="batch_name">Enter batch name</label>
                        @if ($errors->has('batch_name'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('batch_name') }}
                            </div>
                        @endif
                    </div>
                    <label for="file_name">Select Excel File <strong class="text-danger">*</strong></label>
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="file_name" type="file"  accept=".csv" name="file_name" placeholder="Select file name" />
                        
                        @if ($errors->has('file_name'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('file_name') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        
                        <button type="submit" id="import_and_view_button" class="btn btn-primary">Import and View</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>


@endsection

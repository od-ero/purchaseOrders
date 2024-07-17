@extends('layouts.my_app')
@section('subtitle')
 Make order
@endsection

@section('contentheader_title')
  Make Order
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Make Order</h3></div>
            <div class="card-body">
                <form id="import_and_view_form">
                    @csrf
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="batch_name" type="text" name="batch_name" placeholder="Batch Name" />
                        <label for="batch_name">Enter batch name <strong class="text-danger">*</strong></label>
                        @if ($errors->has('batch_name'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('batch_name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-floating my-3 mb-md-0">
                        <input class="form-control" id="email_subject" type="text" name="email_subject" value="{{$mail['email_subject']}}" placeholder="Batch Name" />
                        <label for="batch_name">Subject<strong class="text-danger">*</strong></label>
                        @if ($errors->has('batch_name'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('batch_name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-floating my-3">
                        <textarea id="email_subject" value="'email_body'" class="form-control">{{$mail['email_body']}}</textarea>
                        <label for="textareaID">Body</label>
                    </div>

                    <div class="form-floating mb-3 mb-md-0">
                    <div class="form-floating">
                    <textarea class="form-control" id="email_body" type="text" name="email_body" value="{{$mail['email_body']}}" placeholder="Body"> </textarea>
                        
                        <label for="batch_name">Body<strong class="text-danger">*</strong></label>
                        @if ($errors->has('email_body'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('email_body') }}
                            </div>
                        @endif
                    </div>

                   

                    
                    
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        
                        <button type="submit" id="make_order" class="btn btn-primary">Make Order</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>


@endsection

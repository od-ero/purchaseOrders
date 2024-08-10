@extends('layouts.my_app')
@section('subtitle')
 Send Order
@endsection

@section('contentheader_title')
  Send Order
@endsection

@section('content')
@include('orders.make_order_modal')
<div class="row justify-content-center" id="pdfPage">
    <div class="col-lg-7 make_orders_page">
        <div class="card shadow-lg border-0 rounded-lg mt-2">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Send Order</h3></div>
            <div class="card-body">
            <form id="make_order_form">
                @csrf
                <input class="form-control" id="batch_id" type="text" name="batch_id" value="{{$batch_details['id']}}" hidden/>
                <div class="form-floating my-3 ">
                    <input class="form-control" id="order_no" type="text" name="order_no" value="{{$batch_details['order_no']}}" disabled />
                    <label for="order_no">Order Number</label>
                    @if ($errors->has('order_no'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('order_no') }}
                        </div>
                    @endif
                </div>

                <div class="form-floating mb-3 ">
                    <input class="form-control" id="supplier_name" type="text" name="supplier_name" value="{{$batch_details['supplier_name']}}" disabled />
                    <label for="batch_name">Supplier </label>
                    @if ($errors->has('batch_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('batch_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-floating mb-3 ">
                    <input class="form-control" id="supplier_" tyemailpe="email" name="supplier_email" value="{{$batch_details['supplier_email']}}" disabled />
                    <label for="batch_name">Email </label>
                    @if ($errors->has('batch_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('batch_name') }}
                        </div>
                    @endif
                </div>
                
                <div class="form-floating my-3 ">
                    <input class="form-control" id="people_cc" type="number" name="people_cc" value={{0}} hidden/>
                   
                   
                </div>
                @if ($mail['email_cc'])
                <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="default_cc" type="email" name="default_cc" value="{{$mail['email_cc']}}" placeholder="Default cc"  readonly/>
                        <label for="login_password">Default CC<strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                
                @endif
               

                <div class="form-floating my-3 mb-md-0">
                    <div id="ccEmailsContainer"></div>
                        
                </div>
                <div class="my-3">
                <button class="btn btn-outline-primary" id="make_order_add_cc">Add CC</button>
            </div>
                <div class="form-floating my-3 mb-md-0">
                    <input class="form-control" id="subject" type="text" name="subject" value="{{$mail['email_subject']}}" placeholder="Batch Name" />
                    <label for="email_subject">Subject<strong class="text-danger">*</strong></label>
                    @if ($errors->has('batch_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('batch_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-floating my-3 mb-md-0">
                    <textarea id="email_body" name="email_body" class="form-control" style="height: 100px">{{$mail['email_body']}}</textarea>
                    <label for="email_body">Body</label>
                </div>
                <label class="my-3 mx-4">Send with Price</label>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="with_prices" id="with_prices_yes" value="Yes" 
                @if ($with_prices =='Yes') checked @endif>
                <label class="form-check-label" for="exampleRadios1">
                Yes
                </label>
                </div>
                <div class="form-check form-check-inline">
                <input class="form-check-input " type="radio" name="with_prices" id="with_prices_no" value="No"
                @if ($with_prices == 'No') checked @endif>
              
                <label class="form-check-label" for="exampleRadios2">
                    No
                </label>
                </div>
                <iframe id="pdfIframe" width="100%" height="400px"></iframe>
              
                

        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
        <a class="btn btn-info btn-sm" id="back_button"
        style="color: #fff !important;"><i class="fa fa-backward"></i></a>
            <button type="submit" id="make_order" class="btn btn-primary">Send Order</button>
        </div>
            </form>

            </div>
            
        </div>
    </div>
</div>


@endsection

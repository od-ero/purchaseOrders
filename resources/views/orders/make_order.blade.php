@extends('layouts.my_app')
@section('subtitle')
 Make order
@endsection

@section('contentheader_title')
  Make Order
@endsection

@section('content')
@include('orders.make_order_modal');
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Make Order</h3></div>
            <div class="card-body">
            <form id="make_order_form">
                @csrf
                <input class="form-control" id="batch_id" type="text" name="batch_id" value="{{$batch_details['order_id']}}" hidden/>

                <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="supplier_name" type="text" name="supplier_name" value="{{$batch_details['supplier_name']}}" disabled />
                    <label for="batch_name">Supplier </label>
                    @if ($errors->has('batch_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('batch_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-floating my-3 mb-md-0">
                    <input class="form-control" id="order_no" type="text" name="order_no" value="{{$batch_details['order_no']}}" disabled />
                    <label for="order_no">Order Number</label>
                    @if ($errors->has('order_no'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('order_no') }}
                        </div>
                    @endif
                </div>
                
                <label class="my-3">Send with Price</label>
                <div class="form-floating my-3 mb-md-0">
                    <select class="form-control appselect2" name="with_prices" id="with_prices">
                        <option value="Yes" selected >Yes</option>
                        <option value="No">No</option>
                    </select>
                    @if ($errors->has('supplier_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('supplier_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-floating my-3 mb-md-0">
                    <input class="form-control" id="email_subject" type="text" name="email_subject" value="{{$mail['email_subject']}}" placeholder="Batch Name" />
                    <label for="email_subject">Subject<strong class="text-danger">*</strong></label>
                    @if ($errors->has('batch_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('batch_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-floating my-3 mb-md-0">
                    <textarea id="email_body" name="email_body" class="form-control">{{$mail['email_body']}}</textarea>
                    <label for="email_body">Body</label>
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

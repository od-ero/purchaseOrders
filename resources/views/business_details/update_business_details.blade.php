@extends('layouts.my_app')
@section('subtitle')
 Update Business Details
@endsection

@section('contentheader_title')
Update Business Details
@endsection


@section('content')

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Update Business Details</h3></div>
                        <div class="card-body">
                            <form id="update_business_details_form" >
                            @csrf
                            <div class="row mb-3">
                                        <div class="form-floating  mb-3 mb-md-0">
                                            <input class="form-control" id="update_company_name" name="company_name" value="{{$business_details['company_name']}}" type="text" placeholder="Enter company name"   />
                                            <label for="inputPassword">Business Name  &emsp; <strong class="text-danger" >*</strong></label>
                                            @if ($errors->has('first_name'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                       
                                   
                                </div>
                                <div class="row mb-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="update_head_1" name="head_1" value="{{$business_details['head_1']}}" type="text" placeholder="Enter first heading"   />
                                            <label for="inputPassword">Heading One &emsp; <strong class="text-danger text-right" >*</strong></label>
                                            @if ($errors->has('id_no'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('id_no') }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                </div>

                                <div class="row mb-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="update_head_2" name="head_2" type="text" value="{{$business_details['head_2']}}" placeholder="Enter second heading"   />
                                            <label for="inputPassword">Heading Two &emsp; <strong class="text-danger text-right" >*</strong></label>
                                            @if ($errors->has('id_no'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('id_no') }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                </div>

                                <div class="row mb-3">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="update_head_3" name="head_3" type="text" value="{{$business_details['head_3']}}" placeholder="Enter user phone No"   />
                                        <label for="inputPassword">Heading Three &emsp; <strong class="text-danger text-right" >*</strong></label>
                                        @if ($errors->has('phone'))
                                            <div class="text-danger mt-2">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                               
                                
                                </div>  
                                <div class="row mb-3">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="update_kra_pin" name="kra_pin" value="{{$business_details['kra_pin']}}" type="text" placeholder="Enter kra pin"   />
                                            <label for="inputPassword">KRA Pin &emsp; <strong class="text-danger text-right" >*</strong></label>
                                            @if ($errors->has('id_no'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('id_no') }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="update_signatory_name" name="signatory_name"  value="{{$business_details['signatory_name']}}"type="text" placeholder="Enter Signatory name" />
                                        <label for="inputPassword">Signatory Name &emsp; &emsp; <strong class="text-danger text-right" > *</strong></label>
                                        @if ($errors->has('signatory_name'))
                                            <div class="text-danger mt-2">
                                                {{ $errors->first('signatory_name') }}
                                            </div>
                                        @endif
                                    </div>
                                       
                                </div>
                                
                                <div class="mt-4 mb-0 text-center">
                                    <button type="submit" id="register_save_view" class="btn btn-primary  btn-submit">Update</button>  
                                        
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

          
       

          
@endsection



@extends('layouts.my_app')
@section('subtitle')
 Business Details
@endsection

@section('contentheader_title')
  Business Details
@endsection

@section('content')
@include('business_details.update_business_details');
<div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Order PDF Details</h3></div>
                        <div class="card-body">
                        @include('suppliers.updateSupplier');
                    <table  class="table table-bordered data-table">
                      <form>
                        <input type="text" value="view" id="action_url" name="action_url" hidden>
                      </form>
                         <thead>
                              
                            </thead>
                            <tbody>
                              <tr>
                                <td style="font-weight: bold;">Business Name</td>
                                <td>{{$business_details['company_name']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;"> Heading One</td>
                                <td>{{$business_details['head_1']}}</td>
                              </tr>

                              <tr>
                                <td style="font-weight: bold;">Heading Two</td>
                                <td>{{$business_details['head_2']}}</td>
                              </tr>
                              
                              <tr>
                                <td style="font-weight: bold;">Heading Three</td>
                                
                                <td>{{$business_details['head_3']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">KRA Pin</td>
                                
                                <td>{{$business_details['kra_pin']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Signatory Name</td>
                                <td>{{$business_details['signatory_name']}}</td>
                              </tr>
                             
                            </tbody>
                          </table>
                          <a class="btn btn-info btn-sm" id="back_button"
                          style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                          <a class="btn btn-primary btn-sm"  data-id="{{$business_details['id']}}" id="update_business_details_button" href="#">Edit</i></a>
                         
                         
                      </div>
                    </div>
                </div>
            </div>
@endsection
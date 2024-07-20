@extends('layouts.my_app')
@section('subtitle')
 Email Content
@endsection

@section('contentheader_title')
 Email Content
@endsection

@section('content')
@include('business_details.update_email_content');
<div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Default Email Content</h3></div>
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
                                <td style="font-weight: bold;"> Subject</td>
                                <td>{{$email_content['email_subject']}}</td>
                              </tr>

                              <tr>
                                <td style="font-weight: bold;">Body</td>
                                <td>{{$email_content['email_body']}}</td>
                              </tr>
                              @if ($email_content['email_cc']!= null)
                                <tr>
                                    <td style="font-weight: bold;">Heading Three</td>
                                    
                                    <td>{{$email_content['email_cc']}}</td>
                                </tr>
                              @endif
                              
                             
                             
                            </tbody>
                          </table>
                          <a class="btn btn-info btn-sm" id="back_button"
                          style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                          <a class="btn btn-primary btn-sm"  data-id="{{$email_content['id']}}" id="update_email_content_button" href="#">Edit</i></a>
                         
                         
                      </div>
                    </div>
                </div>
            </div>
@endsection
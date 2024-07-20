@extends('layouts.my_app')
@section('subtitle')
View Order Mail Content
@endsection

@section('contentheader_title')
  View Order Mail Content
@endsection

@section('content')
<div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Order Mail Content</h3></div>
                        <div class="card-body">
                        @include('suppliers.updateSupplier');
                    <table  class="table table-bordered data-table">
                      
                         <thead>
                              
                            </thead>
                            <tbody>
                              <tr>
                                <td style="font-weight: bold;">Supplier</td>
                                <td>{{$send_mail_details['supplier_name']}}</td>
                              </tr>

                              <tr>
                                <td style="font-weight: bold;">Email</td>
                                <td>{{$send_mail_details['supplier_email']}}</td>
                              </tr>

                              @if ($cc_details->isNotEmpty())
                                    @foreach ($cc_details as $index => $cc_detail)
                                        <tr>
                                            <td style="font-weight: bold;">CC {{ $index + 1 }}</td>
                                            <td>{{ $cc_detail['cc_email'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                              <tr>
                                <td style="font-weight: bold;">Date</td>
                                <td>{{$send_mail_details['created_at']}}</td>
                              </tr>
                              
                              <tr>
                                <td style="font-weight: bold;">Subject</td>
                                
                                <td>{{$send_mail_details['email_subject']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Body</td>
                                
                                <td>{{$send_mail_details['email_body']}}</td>
                              </tr>
                              
                              
                            </tbody>
                          </table>
                          <a class="btn btn-info btn-sm" id="back_button"
                          style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                          <a data-id="{{$send_mail_details['batch_id']}}" href="/view/batch/{{base64_encode($send_mail_details['batch_id'])}}" class="btn btn-primary">View</a>
                          
                         
                      </div>
                    </div>
                </div>
            </div>
@endsection
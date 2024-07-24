@extends('layouts.my_app')
@section('subtitle')
 View User
@endsection

@section('contentheader_title')
  View User
@endsection

@section('content')
<div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-2">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">User Details</h3></div>
                        <div class="card-body">
                        @include('admins.updateUser')
                    <table  class="table table-bordered data-table">
                      <form>
                        <input type="text" value="view" id="action_url" name="action_url" hidden>
                      </form>
                         <thead>
                              
                            </thead>
                            <tbody>
                              <tr>
                                <td style="font-weight: bold;">First Name</td>
                                <td>{{$user_details['first_name']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Midddle Name</td>
                                
                                <td>{{$user_details['middle_name']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Last Name</td>
                                
                                <td>{{$user_details['last_name']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">ID Number</td>
                                <td>{{$user_details['id_no']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Staff Number</td>
                                <td>{{$user_details['staff_no']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Permission Level</td>
                                <td>{{$user_details['role_name']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Phone</td>
                                
                                <td>{{$user_details['phone']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Second Phone</td>
                                
                                <td>{{$user_details['second_phone']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Email</td>
                                <td>{{$user_details['email']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Address</td>
                                <td>{{$user_details['phy_address']}}</td>
                              </tr>
                              <tr>
                                <td style="font-weight: bold;">Login_access</td>
                                <td>{{ $user_details['login_access'] == 1 ? 'Yes' : 'No' }}</td>
                              </tr>
                              
                            </tbody>
                          </table>
                          <a class="btn btn-info btn-sm" id="back_button"
                          style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                          <a class="btn btn-primary btn-sm" data-id="{{ base64_encode($user_details['id'])}}" id="update_employees_details" href="#">Edit</i></a>
                          @if ($user_details['login_access'] == 1 )
                          <a class="btn btn-success btn-sm"  data-id="{{ base64_encode($user_details['id'])}}" id="delete_user_button" href="#">Delete</i></a>
                          @endif
                          @if ($user_details['login_access'] == 0 )
                          <a class="btn btn-success btn-sm" data-id="{{ base64_encode($user_details['id'])}}" id="activate_user_button" href="#">Activate</i></a>
                          @endif
                          
</div>
                    </div>
                </div>
            </div>
@endsection
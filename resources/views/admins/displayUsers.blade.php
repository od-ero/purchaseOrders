@extends('layouts.my_app')
@section('subtitle')
  Dashoard
@endsection

@section('contentheader_title')
  Dashboard
@endsection
@livewireStyles
@section('content')
    <div class="card-body">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="container-fluid px-4">
                        <h2 class="mt-4 text-white">Users</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">users</li>
                        </ol>
                        <div class="card mb-4">
                            <!-- <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div> -->
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-house-medical me-1"></i>
                               Users
                            </div>
                            @livewire('users')
                        </div>
                    </div>
    @livewireScripts
    <script type="text/javascript">
        window.livewire.on('userStore', () => {
            $('#exampleModal').modal('hide');
        });
    </script>
@endsection
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="" />
        <title>{{ENV('APP_NAME')}} -@yield('subtitle')</title> 
        @include('layouts.partials.imported_styles')
        <!-- @vite(['resources/css/app.css']) -->

      
    </head>
    <body class="sb-nav-fixed">
       
        @include('layouts.partials.header')
        <div id="layoutSidenav">
            @include('layouts.partials.sidebar')
            
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                    @include('layouts.partials.scripts')
                </main>
                @include('layouts.partials.footer')
                 
            </div>
        </div>
      
    </body>
</html>

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
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

      
    </head>
    <body class="sb-nav-fixed">
       
        @include('layouts.partials.header')
        <div id="layoutSidenav">
            @include('layouts.partials.sidebar')
            
            <div id="layoutSidenav_content">
                <main>
               
                    @yield('content')
                </main>
                @include('layouts.partials.footer')
                
            </div>
        </div>




        @vite(['resources/js/app.js'])
        
    </body>
</html>

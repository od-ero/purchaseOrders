<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ENV('APP_NAME')}} -@yield('subtitle')</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="sb-nav-fixed">
       
        @include('layouts.partials.header')
        <div id="layoutSidenav">
            @include('layouts.partials.sidebar')
            @include('layouts.partials.scripts')
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                @include('layouts.partials.footer')
                
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <!-- <script src="js/datatables-simple-demo.js"></script> -->
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ENV('APP_NAME')}} -@yield('subtitle')</title>
       
        @include('layouts.partials.imported_styles')
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                       
                            @yield('content')
                            @include('layouts.partials.scripts')
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                 @include('layouts.partials.footer')
            </div>
        </div>
       
    </body>
</html>

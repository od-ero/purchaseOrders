<!DOCTYPE html>
<html>
<head>
    <title>Laravel 11 Livewire BootStrap Modal Crud Example - ItcodStuff.com</title>
   
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Laravel 11 Livewire BootStrap Modal Crud - ItcodStuff.com</h2>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @livewire('users')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
    <script type="text/javascript">
        window.livewire.on('userStore', () => {
            $('#exampleModal').modal('hide');
        });
    </script>
</body>
</html>
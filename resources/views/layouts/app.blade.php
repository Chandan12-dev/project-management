<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Project Management') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-toggle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/select2/select2.min.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap-toggle.min.js') }}" defer></script>
        <script src="{{ asset('js/datepicker.js') }}" defer></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}" defer></script>
        <script src="{{ asset('js/dataTables.bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('js/dataTables.fixedHeader.min.js') }}" defer></script>
        <script src="{{ asset('js/dataTables.responsive.min.js') }}" defer></script>
        <script src="{{ asset('js/responsive.bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('js/custom.js') }}" defer></script>
        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <?php if(auth()->user()->role == 'admin'){ ?>
            @include('layouts.navigation')
            <?php }elseif(auth()->user()->role == 'user'){ ?>
            @include('layouts.navigation_user')
            <?php }else{ ?>
            @include('layouts.guest')
            <?php } ?>
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
            $(document).ready(function() {
                var table = $('.filter-Table').DataTable( {
                    responsive: true,
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": true,
                    "bInfo": false,
                    "bAutoWidth": false
                } );
            
                new $.fn.dataTable.FixedHeader( table );
            } );
        </script>
    </body>
</html>

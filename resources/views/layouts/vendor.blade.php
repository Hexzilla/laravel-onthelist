<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard - Vendor Panel</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('vendor/calender/calender.css') }}">
    <link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Inline styles -->
    @yield('styles')
</head>

<body>

    <div id="preloader"><div class="spinner"><div class="spinner-a"></div><div class="spinner-b"></div></div></div>

    <div id="main-wrapper">

        <div class="nav-header">
            <a href="{{ route('vendors.dashboard') }}" class="brand-logo">
                <img src="{{asset('images/logo-abbr.png')}}" class="logo-abbr" height="30" />
                <span class="logo-compact">On The List</span>
                <img src="{{asset('images/logo.png')}}" class="brand-title" height="30" />
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                </div>
            </div>
        </div>

        @include('partials.vendor-header')

        @include('partials.vendor-sidebar')

        @yield('content')

        @include('partials.vendor-footer')

    </div>

    <!-- Required vendors -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <!-- Here is navigation script -->
    <script src="{{ asset('vendor/quixnav/quixnav.min.js') }}"></script>
    <script src="{{ asset('js/quixnav-init.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!-- Demo scripts -->
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>

    <!-- Daterange picker library -->
    <script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>

    <!-- Vectormap -->
    <script src="{{ asset('vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('vendor/jqvmap/js/jquery.vmap.world.js') }}"></script>


    <!-- calender -->
    <script src="{{ asset('vendor/calender/calender.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/calender-init.js') }}"></script>

    <!-- Chart Morris plugin files -->
    <script src="{{ asset('vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('vendor/morris/morris.min.js') }}"></script>

    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>

    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/html5-qrcode/html5-qrcode.min.js') }}"></script>
    
    <!-- Inline scripts -->
    @yield('scripts')

    <script>
        toastr.options = {
            "preventDuplicates": true
        }
        @if(is_string($errors))
            toastr.error("{{ $errors }}");
        @endif
        @if(is_array($errors) && count($errors) > 0)
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
</body>
</html>

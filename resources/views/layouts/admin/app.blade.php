<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="/admin/library/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="/admin/css/style.css">
    <link rel="stylesheet" href="/admin/css/components.css">

    {{--
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- END GA --> --}}
    <livewire:styles />
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</head>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.admin.header')

            <!-- Sidebar -->
            @include('components.admin.sidebar')

            <!-- Content -->
            @yield('main')

            <!-- Footer -->
            @include('components.admin.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="/admin/library/jquery/dist/jquery.min.js"></script>
    <script src="/admin/library/popper.js/dist/umd/popper.js"></script>
    <script src="/admin/library/tooltip.js/dist/umd/tooltip.js"></script>
    <script src="/admin/library/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/admin/library/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
    <script src="/admin/library/moment/min/moment.min.js"></script>
    <script src="/admin/js/stisla.js"></script>
    <script src="/admin/library/ijaboViewer/jquery.ijaboViewer.min.js"></script>

    @stack('scripts')

    <!-- Template JS File -->
    <script src="/admin/js/scripts.js"></script>
    <script src="/admin/js/custom.js"></script>
    <livewire:scripts />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.15/dist/sweetalert2.all.min.js"></script>

    @yield('ck-editor')
</body>

</html>

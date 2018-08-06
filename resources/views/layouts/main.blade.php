<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Informasi Rumah Sakit Kayen</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/assets/global/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/assets/global/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/theme/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/theme/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/theme/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/theme/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/theme/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/assets/global/js/main/jquery.min.js"></script>
    <script src="/assets/global/js/main/bootstrap.bundle.min.js"></script>
    <script src="/assets/global/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="/assets/theme/js/app.js"></script>
    <script src="/assets/global/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/assets/global/js/plugins/forms/styling/uniform.min.js"></script>
    <script>
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });
    </script>
    @yield('script')
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-light">

        <!-- Header with logos -->
        <div class="navbar-header navbar-dark d-none d-md-flex align-items-md-center">
            <div class="navbar-brand navbar-brand-md">
                <a href="{{ route('home') }}" class="d-inline-block">
                    <img src="/assets/global/images/logo_light.png" alt="">
                </a>
            </div>
            
            <div class="navbar-brand navbar-brand-xs">
                <a href="{{ route('home') }}" class="d-inline-block">
                    <img src="/assets/global/images/logo_icon_light.png" alt="">
                </a>
            </div>
        </div>
        <!-- /header with logos -->
    

        <!-- Mobile controls -->
        <div class="d-flex flex-1 d-md-none">
            <div class="navbar-brand mr-auto">
                <a href="{{ route('home') }}" class="d-inline-block">
                    <img src="/assets/global/images/logo_dark.png" alt="">
                </a>
            </div>  

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree5"></i>
            </button>

            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>
        <!-- /mobile controls -->


        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/global/images/image.png" class="rounded-circle" alt="">
                        <span>{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="icon-switch2"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /navbar content -->

    </div>
    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

            <!-- Sidebar mobile toggler -->
            <div class="sidebar-mobile-toggler text-center">
                <a href="#" class="sidebar-mobile-main-toggle">
                    <i class="icon-arrow-left8"></i>
                </a>
                Navigation
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                    <i class="icon-screen-normal"></i>
                </a>
            </div>
            <!-- /sidebar mobile toggler -->


            {{-- @include('layouts.sidebar') --}}
            
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">
            <h4 class="mt-4 ml-3"><span class="font-weight-semibold">@yield('title')</h4>
            <!-- Content area -->
            <div class="content pt-10">

                @yield('content')

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</body>
</html>

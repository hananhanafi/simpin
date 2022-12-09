<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>
           @yield('title') | {{ config('app.name') }}
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sistem Informasi Simpan Pinjam (SIMPIN)" name="description" />
        <meta content="SIMPIN" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('includes.link')
        @yield('css')
    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">


            @include('includes.header')

            <!-- ========== Left Sidebar Start ========== -->
            @include('includes.sidebar')
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        @yield('content')
                        <!-- end page title -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                @include('includes.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        @include('includes.right-bar')

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        @include('includes.script')

    </body>
</html>
@yield('footscript')
@yield('modal')

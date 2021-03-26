<!DOCTYPE html>
<html lang="en">
  <head>  
    <title>@yield('title')-{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/jquery.datetimepicker.css" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/bootstrap-toggle.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/bootstrap-notifications.css" />
    <!--Jquery ui CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/jqueryui/jquery-ui.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/bootstrap.min.css" />  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/main.css" /> 
    {{-- custom project css  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/style.css" />      
    
    @yield('styles')
  </head>

  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    @include('partials.header')
    @include('partials.sidebar')   
    <main class="app-content">
        @yield('content')
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('assets') }}/js/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/jquery.datetimepicker.full.min.js"></script>
    <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/bootstrap-toggle.min.js"></script>    
    <script src="{{ asset('assets') }}/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('assets') }}/js/plugins/pace.min.js"></script>
    <!--Jquery ui script -->
    <script src="{{ asset('assets') }}/jqueryui/jquery-ui.min.js" type="text/javascript"></script>    
    @stack('scripts')
  </body>
</html>

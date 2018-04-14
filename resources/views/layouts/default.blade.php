<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="Eduardo Judici">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
		<title>BYD ADMIN | @yield('title')</title>
        
		<!-- Bootstrap core CSS-->
		<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<!-- Custom fonts for this template-->
		<link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
		<!-- Page level plugin CSS-->
		<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
		<!-- Custom styles for this template-->
        <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
        <!-- Select color -->
		<link href="{{ asset('css/spectrum.css') }}" rel="stylesheet">
	</head>

	<body class="fixed-nav sticky-footer bg-dark" id="page-top">

        @include('layouts.header')        

        <div class="content-wrapper">

        	<div class="container-fluid">

	            @section('sidebar')
	            @show

                {{-- messages from success and error controller by message.blade.php --}}
                <div id="info-alert">

                    <div class="alert alert-success" style="display: none">
                        <h4>Success</h4>
                        <br />
                        <div data-bind="text: message"></div>
                    </div>

                    <div class="alert alert-danger" data-bind="visible: hasError" style="display: none">
                        <h4>Error</h4>
                        <br />
                        <pre data-bind="text: message"></pre>
                    </div>
                </div>

	            @yield('content')

        	</div>

            @include('layouts.footer')

            <script type="text/javascript">
                var 
                    repo_link = '{!! config('app.repo_link') !!}',
                    repo_token = '{!! config('app.repo_token') !!}';
            </script>

            <!-- Bootstrap core JavaScript-->
            <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <!-- Core plugin JavaScript-->
            <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
            <!-- Page level plugin JavaScript-->
            <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
            <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
            <!-- Custom scripts for all pages-->
            <script src="{{ asset('js/sb-admin.min.js') }}"></script>
            <!-- Custom scripts for this page-->
            <script src="{{ asset('js/sb-admin-datatables.min.js') }}"></script>

            <script src="{{ asset('js/bootstrap-waitingfor.js') }}"></script>

            <script src="{{ asset('js/knockout-3.4.0.js') }}"></script>
            <script src="{{ asset('js/knockout.validation.min.js') }}"></script>
            
            <script src="{{ asset('js/spectrum.js') }}"></script>

            <script src="{{ asset('js/Api.js') }}"></script>

            @include('layouts.confirmModal')
            @include('layouts.message')

            @yield('scripts')

        </div>    
    </body>
</html>



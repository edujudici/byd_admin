<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>BYD ADMIN | @yield('title')</title>
		<!-- Bootstrap core CSS-->
		<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<!-- Custom fonts for this template-->
		<link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
		<!-- Page level plugin CSS-->
		<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
		<!-- Custom styles for this template-->
		<link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
	</head>

	<body class="fixed-nav sticky-footer bg-dark" id="page-top">

        @include('layouts.header')

        <div class="content-wrapper">

        	<div class="container-fluid">

	            @section('sidebar')
	            @show

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

            <script src="{{ asset('js/knockout-3.4.0.js') }}"></script>
            <script src="{{ asset('js/knockout.validation.min.js') }}"></script>
            
            <script src="{{ asset('js/Api.js') }}"></script>

            @include('layouts.confirmModal')

            @yield('scripts')

        </div>    
    </body>
</html>



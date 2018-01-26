@extends('layouts.app')

@section('title', 'Services Offer')

@section('sidebar')
    @parent
    <!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{ route('home.show') }}">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Services Offer</li>
	</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
			<h1>Blank</h1>
			<p>This is an example of a blank page that you can use as a starting point for creating new ones.</p>
        </div>
  	</div>
@endsection

@section('scripts')
@endsection
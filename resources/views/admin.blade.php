@extends('layouts.app')

@section('content')
	<!-- Breadcrumbs line -->
    <div class="crumbs">
        <ul id="breadcrumbs" class="breadcrumb">
            <li class="current">
                <a href="{{ route('home') }}"><i class="icon-home"></i></a>
            </li>
        </ul>
    </div>
    <!-- /Breadcrumbs line -->
	
    <div class="page-header"></div>
    
	@include('layouts.alert')

    <div class="row">
        <div class="col-md-12">
            <div class="widget box">
            
                <div class="widget-header">
                    <h4>Admin Home</h4>
                </div>
                
                <div class="widget-content">
                	
                </div>
                
            </div>
        </div>
    </div>
            
@endsection

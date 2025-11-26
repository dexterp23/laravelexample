<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {!! config('defines.MetaTags') !!}

    <title>{{ config('app.name', 'Laravel') }}</title>
	
    <!--=== CSS ===-->
    <link href="/template_spark/css/modern.css" rel="stylesheet" type="text/css" />
    
    <!-- flags -->
    <link rel="stylesheet" href="/css/flag-icon-css/css/flag-icon.min.css">
    
    
    <!--=== JavaScript ===-->
    <script type="text/javascript" src="/template_spark/js/settings.js"></script>
    <script type="text/javascript" src="/template_spark/js/app.js"></script>
    

    <!-- Form Validation -->
	<script type="text/javascript" src="/template/plugins/validation/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/template/plugins/validation/additional-methods.min.js"></script>
    <!--<script type="text/javascript" src="/template/plugins/validation/localization/messages_de.js"></script>-->
    
    
    <!-- custom -->
	<link href="/css/extra.css?2" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="/js/custom.js?3"></script>
	<script type="text/javascript" src="/js/custom_ready.js?4"></script>

    
</head>
<body class="@if(Auth::user()){{ '' }}@else{{ 'login' }}@endif @if(Route::current()->getName() == 'login' || Route::current()->getName() == 'member'){{ 'login_page' }}@endif @if(Route::current()->getName() == 'register' && !empty($iframe_chk)){{ 'register_page' }}@endif">

	<div id="sys_messages_popup"></div>
    <div class="loading_page"></div>
	
    <div class="splash active">
		<div class="splash-icon"></div>
	</div>
    
    @if (Auth::user())
    	
        <div class="wrapper">
        
            @include('layouts.menu')
        
            <div class="main">
                
                @include('layouts.header')
                
                <main class="content">
					<div class="container-fluid">
                        
                        @yield('content')
        
                    </div>
                </main>
                
                @include('layouts.footer')
                
            </div>
            
        </div>
        
    @else
    
    	@yield('content')
    
    @endif
    
    

</body>
</html>

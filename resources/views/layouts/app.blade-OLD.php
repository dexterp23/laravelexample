<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Bootstrap -->
	<link href="/template/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- jQuery UI -->
	<!--<link href="/template/plugins/jquery-ui/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />-->
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="/template/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/>
	<![endif]-->

	<!-- Theme -->
	<link href="/template/assets/css/main.css" rel="stylesheet" type="text/css" />
	<link href="/template/assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="/template/assets/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="/template/assets/css/icons.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="/template/assets/css/fontawesome/font-awesome.min.css">
	<!--[if IE 7]>
		<link rel="stylesheet" href="/template/assets/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

	<!--[if IE 8]>
		<link href="/template/assets/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
    
	
    <!--=== JavaScript ===-->
	<script type="text/javascript" src="/template/assets/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="/template/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>

	<script type="text/javascript" src="/template/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/template/assets/js/libs/lodash.compat.min.js"></script>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="/template/assets/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Smartphone Touch Events -->
	<script type="text/javascript" src="/template/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="/template/plugins/event.swipe/jquery.event.move.js"></script>
	<script type="text/javascript" src="/template/plugins/event.swipe/jquery.event.swipe.js"></script>

	<!-- General -->
	<script type="text/javascript" src="/template/assets/js/libs/breakpoints.js"></script>
	<script type="text/javascript" src="/template/plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
	<!--<script type="text/javascript" src="/template/plugins/cookie/jquery_cookie_min.js"></script>-->
	<script type="text/javascript" src="/template/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="/template/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
    
	<!-- Noty -->
	<script type="text/javascript" src="/template/plugins/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="/template/plugins/noty/layouts/top.js"></script>
    <script type="text/javascript" src="/template/plugins/noty/layouts/center.js"></script>
	<script type="text/javascript" src="/template/plugins/noty/themes/default.js"></script>

	<!-- Forms -->
	<script type="text/javascript" src="/template/plugins/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="/template/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="/template/plugins/inputlimiter/jquery.inputlimiter.min.js"></script>
    <script type="text/javascript" src="/template/plugins/fileinput/fileinput.js"></script>
    
    <!-- Form Validation -->
	<script type="text/javascript" src="/template/plugins/validation/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/template/plugins/validation/additional-methods.min.js"></script>
    <!--<script type="text/javascript" src="/template/plugins/validation/localization/messages_de.js"></script>-->

	<!-- App -->
    <script type="text/javascript" src="/template/plugins/blockui/jquery.blockUI.min.js"></script>
	<script type="text/javascript" src="/template/assets/js/app.js"></script>
	<script type="text/javascript" src="/template/assets/js/plugins.js"></script>
	<script type="text/javascript" src="/template/assets/js/plugins.form-components.js"></script>
    

	<script>
	$(document).ready(function(){
		"use strict";

		App.init(); // Init layout and core plugins
		Plugins.init(); // Init all plugins
		FormComponents.init(); // Init all form-specific plugins
	});
	</script>


    <!-- custom -->
	<link href="/css/extra-2.css?5" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="/js/custom.js?3"></script>
	<script type="text/javascript" src="/js/custom_ready.js?4"></script>
    
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @if (Auth::user()->role == "admin")
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('users.list') }}">{{ __('Users') }}</a>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

@extends('layouts.app')

@section('content')


<main class="custom_content" style="margin-right: 12px;">
	<div class="row">
    
        <div class="col-lg-6">
            <main class="main h-100 w-100">
                <div class="container h-100">
                    <div class="row h-100">
                        <div class="col-sm-12 col-md-10 col-lg-8 mx-auto d-table h-100">
                            <div class="d-table-cell align-middle">
        
                                <div class="text-center mt-4">
                                    <img src="/images/logo_dark.png" title="{{ config('app.name', 'Laravel') }}" />
                        			<?php /* ?><h1 class="h2">{{ config('app.name', 'Laravel') }}</h1><?php */ ?>
                                    <p class="lead">
                                        Sign In to your Account
                                    </p>
                                </div>
        
                                <div class="card">
                                    <div class="card-body">
                                        <div class="m-sm-4">
                                        
                                            @include('layouts.alert')
        
                                            <form method="POST" action="{{ route('login') }}" id="login_form">
                                                @csrf
                                                
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-control form-control-lg required email" placeholder="E-Mail Address" autofocus="autofocus" autocomplete="off" />
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="password" class="form-control form-control-lg required" placeholder="Enter Your Password" />
                                                    <small>
                                                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                                    </small>
                                                </div>
                                                <div>
                                                    <div class="custom-control custom-checkbox align-items-center">
                                                        <input id="remember" type="checkbox" class="custom-control-input" value="1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="custom-control-label text-small" for="remember">Remember me</label>
                                                    </div>
                                                </div>
                                                <div class="text-center mt-3">
                                                    <button type="submit" class="submit btn btn-block btn-lg btn-primary">Sign In</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="card-footer text-center pt-0">
                                        <a href="{{ route('register') }}" class="text-muted">Don't have an account yet? <strong>Sign Up</strong></a>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        
        <div class="col-lg-6 login_holder">
            <div id="SaasOnBoardContainer_25"></div>
			<script type="text/javascript" src="https://app.saasonboard.com/assets/custom/js/iframe/loginscreenlibrary.js"></script>
            <script type="text/javascript">
              LoginScreenLibrary.init([
                  "SaasOnBoardContainer_25",
                  "https://app.saasonboard.com/",
                  "dqV0HQ3ImHYjbaN",
                  "SaasOnBoardIFrame_25"
              ]);
            </script>
        </div>
        
	</div>
</div>

@endsection

@extends('layouts.app')

@section('content')


<main class="main h-100 w-100">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <img src="/images/logo_dark.png" title="{{ config('app.name', 'Laravel') }}" />
                        <?php /* ?><h1 class="h2">{{ config('app.name', 'Laravel') }}</h1><?php */ ?>
                        <p class="lead">
                            {{ __('Confirm Password') }}
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                            	
                            	<div class="text-center">
                                    {{ __('Please confirm your password before continuing.') }}
                                </div>
                                    
                                @include('layouts.alert')

                                <form method="POST" action="{{ route('password.confirm') }}" id="login_form">
                                    @csrf
                                    
                                    <div class="form-group">
                                    	<input type="password" name="password" class="form-control form-control-lg required" placeholder="Password" autocomplete="current-password" />
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="submit btn btn-block btn-lg btn-primary">Confirm Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr />
                        <div class="card-footer text-center pt-0">
                        	<a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot Your Password?') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


@endsection

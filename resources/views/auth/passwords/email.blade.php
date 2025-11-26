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
                            {{ __('Reset Password') }}
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                            
                                @include('layouts.alert')

                                <form method="POST" action="{{ route('password.email') }}" id="login_form">
                                    @csrf
                                    
                                    <div class="form-group">
                                    	<input type="email" name="email" class="form-control form-control-lg required email" placeholder="E-Mail Address" autofocus="autofocus" autocomplete="off" />
                                    </div>
  
                                    <div class="text-center mt-3">
                                        <button type="submit" class="submit btn btn-block btn-lg btn-primary">{{ __('Send Password Reset Link') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr />
                        <div class="card-footer text-center pt-0">
                        	<a href="{{ route('login') }}" class="text-muted">{{ __('Sign In') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


@endsection

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
                            {{ __('Sign Up') }}
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                            
                                @include('layouts.alert')

                                <form method="POST" action="{{ route('register') }}" id="login_form" target="_parent">
                                    @csrf
                                    <?php /* ?><input type="hidden" name="token_register" value="{{ $token_register }}" ><?php */ ?>
                                    
                                    <div class="form-group">
                                    	<input type="text" name="name" class="form-control form-control-lg required" placeholder="Name" autofocus="autofocus" autocomplete="off" value="@if(old('name')) {{ old('name') }}@endif" />
										<?php /* ?><input type="text" name="name" class="form-control form-control-lg required" placeholder="Name" autofocus="autofocus" autocomplete="name" value="@if(old('name')) {{ old('name') }}@elseif(!empty($data->vendor_name)){{ $data->vendor_name }}@else{{ '' }}@endif" /><?php */ ?>
                                    </div>
                                    <div class="form-group">
                                    	<input type="email" name="email" class="form-control form-control-lg required email" placeholder="E-Mail Address" autofocus="email" autocomplete="off" value="{{ old('email') }}" />
                                    </div>
                                    <div class="form-group">
                                    	<input type="text" name="digi_id" class="form-control form-control-lg" placeholder="DigiStore24 ID" autofocus="autofocus" autocomplete="off" value="@if(old('digi_id')) {{ old('digi_id') }}@endif" />
                                    </div>
                                    <div class="form-group">
                                    	<input type="password" name="password" class="form-control form-control-lg required" placeholder="Enter Your Password" autocomplete="new-password"/>
                                    </div>
                                    <div class="form-group">
                                    	<input type="password" name="password_confirmation" class="form-control form-control-lg required" placeholder="Confirm Password" autocomplete="new-password"/>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="submit btn btn-block btn-lg btn-primary">Sign Up</button>
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

@extends('layouts.app')

@section('content')

	<div class="row">
        <div class="col-12">
            <div class="card">
            
            	<div class="card-header">
                    &nbsp;
                </div>
                
                <div class="card-body">

                    @if (session('resent'))
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <div class="alert-message">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif 
                    
                    <h3>{{ __('Verify Your Email Address') }}</h3>
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    <br /><br />
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        {{ __('If you did not receive the email') }} <button type="submit" class="btn btn-primary">{{ __('click here to request another') }}</button>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
@endsection

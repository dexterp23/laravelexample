@extends('layouts.app')

@section('content')

	@include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            {{ $data[0]->name }}
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">My Profile </li>
            </ol>
        </nav>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
            
            	<div class="card-header">
                    &nbsp;
                </div>
                
                <div class="card-body">
                	
					<form action="{{ route('user.profileUpdate') }}" method="post" name="form" id="form" class="">
                    	@method('POST')
                        @csrf
                        
                        @if(!empty($data[0]))
                            <input type="hidden" name="id" value="{{ $data[0]->id }}">
                        @endif
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Name <span class="required_asterix">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="name" class="form-control required" value="@if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        
                        <?php /* ?>
                        @if (Auth::user()->role == "user")
                            <div class="form-group row">
                                <label class="col-form-label col-sm-2 text-sm-right">API Key</label>
                                <div class="col-md-3">
                                    <input type="text" name="digi_api_key" class="form-control" value="@if(!empty($data[0]->digi_api_key)){{ $data[0]->digi_api_key }}@else{{ '' }}@endif" />
                                </div>
                            </div>
                        @endif
                        <?php */ ?>
                        
                        @if (Auth::user()->role == "user")
                            <div class="form-group row">
                                <label class="col-form-label col-sm-2 text-sm-right">DigiStore24 ID </label>
                                <div class="col-md-3">
                                    <input type="text" name="digi_id" class="form-control" value="@if(!empty($data[0]->digi_id)){{ $data[0]->digi_id }}@else{{ '' }}@endif" />
                                </div>
                            </div>
                        @endif
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Email Address <span class="required_asterix">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="email" class="form-control required" value="@if(!empty($data[0]->email)){{ $data[0]->email }}@else{{ '' }}@endif" readonly="readonly" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Time Zone</label>
                            <div class="col-md-3">
                                <ul class="display_none">
                                    <li>
                                        <strong>
                                            UTC time:
                                        </strong>
                                        <span class="js-TimeUtc"></span>
                                    </li>
                                    <li>
                                        <strong>
                                            Local time:
                                        </strong>
                                        <span class="js-TimeLocal"></span>
                                    </li>
                                </ul>
                                <select id="timeZone" class="form-control js-Selector" name="timeZone">
                                    <option value="-12.0">(GMT -12:00)</option>
                                    <option value="-11.0">(GMT -11:00)</option>
                                    <option value="-10.0">(GMT -10:00)</option>
                                    <option value="-9.0">(GMT -9:00)</option>
                                    <option value="-8.0">(GMT -8:00))</option>
                                    <option value="-7.0">(GMT -7:00))</option>
                                    <option value="-6.0">(GMT -6:00)</option>
                                    <option value="-5.0">(GMT -5:00)</option>
                                    <option value="-4.0">(GMT -4:00)</option>
                                    <option value="-3.0">(GMT -3:00)</option>
                                    <option value="-2.0">(GMT -2:00)</option>
                                    <option value="-1.0">(GMT -1:00)</option>
                                    <option value="0.0">(GMT)</option>
                                    <option value="1.0">(GMT +1:00)</option>
                                    <option value="2.0" selected="selected">(GMT +2:00)</option>
                                    <option value="3.0">(GMT +3:00)</option>
                                    <option value="4.0">(GMT +4:00)</option>
                                    <option value="5.0">(GMT +5:00)</option>
                                    <option value="6.0">(GMT +6:00)</option>
                                    <option value="7.0">(GMT +7:00)</option>
                                    <option value="8.0">(GMT +8:00)</option>
                                    <option value="9.0">(GMT +9:00)</option>
                                    <option value="9.5">(GMT +9:30)</option>
                                    <option value="10.0">(GMT +10:00)</option>
                                    <option value="11.0">(GMT +11:00)</option>
                                    <option value="12.0">(GMT +12:00)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row pt-5">
                            <div class="col-md-12 text-muted">Only if you want to change your password</div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">New Password (Optional)</label>
                            <div class="col-md-3">
                                <input type="password" name="password" id="password" class="form-control" value="" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Retype Password</label>
                            <div class="col-md-3">
                                <input type="password" name="password_confirmation" class="form-control" equalTo="#password" value="" />
                            </div>
                        </div>

                        <div class="form-actions">
                        	<input type="submit" value="Save" class="btn btn-primary float-right ml-1 dugme_submit">
                        </div>
                    
                    </form>
                                        
                </div>
                
            </div>
        </div>
    </div>
    
    <script src="https://momentjs.com/downloads/moment.js"></script>
	<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
    <script type="text/javascript" src="/js/custom_timezone.js?1"></script>
    
    <script type="text/javascript">
		$(document).ready(function() {
			
			document.querySelector(".js-Selector").value = "{{ $data[0]->timeZone }}";
			
		});
	</script>
            
@endsection

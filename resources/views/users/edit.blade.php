@extends('layouts.app')

@section('content')

	@include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            @if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ 'User' }}@endif
            @if(@$data[0]->email_verified_at)
                [Verified]
            @else
            	[Not-Verified]
            @endif
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.list') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if(empty($data[0]))
                        Add
                    @else
                        Edit
                    @endif
                </li>
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
                	
					<form action="{{ route('users.update') }}" method="post" name="form" id="form" class="">
                    	@method('POST')
                        @csrf
                        
                        <input type="hidden" name="id" value="{{ @$data[0]->id }}">
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Publish</label>
                            <div class="col-md-6">
                                <label class="checkbox-inline">
                                     <input name="publish" type="checkbox" class="uniform" value="1" @if(@$data[0]->publish == 1) {{ 'checked' }}@endif />
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-form-label col-sm-2 text-sm-right">User Name <span class="required_asterix">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="name" class="form-control required" value="@if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-form-label col-sm-2 text-sm-right">User Email </label>
                            <div class="col-md-3">
                                <input type="text" name="email" class="form-control" value="@if(!empty($data[0]->email)){{ $data[0]->email }}@else{{ '' }}@endif" disabled="disabled" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-form-label col-sm-2 text-sm-right">Member ID <span class="required_asterix">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="member_id" class="form-control required clean_slug" value="@if(!empty($data[0]->member_id)){{ $data[0]->member_id }}@else{{ '' }}@endif" />
                                <small class="form-text d-block text-muted">no space and no special characters</small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        	<label class="col-form-label col-sm-2 text-sm-right">Digi ID</label>
                            <div class="col-md-3">
                                <input type="text" name="digi_id" class="form-control" value="@if(!empty($data[0]->digi_id)){{ $data[0]->digi_id }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        
                        <?php /* ?>
                        <div class="form-group row">
							<label class="col-form-label col-sm-2 text-sm-right">>Digi API Key</label>
                            <div class="col-md-3">
                                <input type="text" name="digi_api_key" class="form-control" value="@if(!empty($data[0]->digi_api_key)){{ $data[0]->digi_api_key }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        <?php */ ?>
                        
                        <div class="form-actions">
                        	<input type="submit" value="Save" class="btn btn-primary float-right ml-1 dugme_submit">
							<?php /* ?>
                                <a href="{{ route('users.add') }}" class="btn btn-success float-right ml-1">Add New</a>
                            <?php */ ?>
                        </div>
                    
                    </form>
                                        
                </div>
                
            </div>
        </div>
    </div>
    
        <script type="text/javascript">
	
		function SlugUpdateType () {
			
			$('input.clean_slug').keyup(function(event) {
				
				// skip for arrow keys
				if(event.which >= 37 && event.which <= 40){
					event.preventDefault();
				}
				
				$(this).val(function(index, value) {
					return value
					.replace(/[^a-z0-9]/gi, "")
					;
				});
			  
			});
			
		}
		
		
		$(document).ready(function() {
		
			SlugUpdateType();
			
		});
	
	</script>
            
@endsection

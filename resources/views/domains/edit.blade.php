@extends('layouts.app')

@section('content')

	@include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            @if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ 'Domain' }}@endif
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('domains.list') }}">Domains</a></li>
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
                	
					<form action="{{ route('domains.update') }}" method="post" name="form" id="form" class="">
                    	@method('POST')
                        @csrf
                        
                        @if(!empty($data[0]))
                            <input type="hidden" name="id" value="{{ $data[0]->id }}">
                        @endif
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Name <span class="required">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="name" class="form-control required" value="@if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Slug <span class="required">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="slug" id="slug" class="form-control required clean_slug" autocomplete="off" value="@if(!empty($data[0]->slug)){{ $data[0]->slug }}@else{{ '' }}@endif" />
                                <span class="help-block" id="slug_error" style="color:#F00; display:none;"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">URL <span class="required">*</span></label>
                            <div class="col-md-6">
                                <input type="text" name="url" class="form-control required" value="@if(!empty($data[0]->url)){{ $data[0]->url }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Default URL</label>
                            <div class="col-md-6">
                                <input type="text" name="default_url" class="form-control" value="@if(!empty($data[0]->default_url)){{ $data[0]->default_url }}@else{{ '' }}@endif" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Retargeting Pixel</label>
                            <div class="col-md-6">
                                <textarea rows="5" name="pixel_code" class="form-control">@if(!empty($data[0]->pixel_code)){{ $data[0]->pixel_code }}@else{{ '' }}@endif</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">CName URL</label>
                            <div class="col-md-6">
                                <input type="text" name="invite_link" id="invite_link" class="form-control" onClick="this.setSelectionRange(0, this.value.length)" value="" readonly />
                                <input type="hidden" name="cname" id="cname" value="" />
                            </div>
                        </div>

                        <?php /* ?>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Is Forward Domain</label>
                            <div class="col-md-6">
                                <label class="checkbox-inline">
                                     <input name="is_forward" type="checkbox" class="uniform" value="1" @if(!empty($data[0]->is_forward)) @if($data[0]->is_forward == 1) {{ 'checked' }}@endif @endif />
                                </label>
                            </div>
                        </div>
						<?php */ ?>
                        
                        <div class="form-actions pt-5">
                        	@if(!empty($data[0]))
                        		<a href="{{ route('domains.download', [$data[0]->id, 'site']) }}" class="btn btn-info float-right float-sm-none mb-1 ml-1">Generate Files</a>
                            	<a href="{{ route('domains.download', [$data[0]->id, 'wordpress']) }}" class="btn btn-info float-right float-sm-none mb-1 ml-1">Download WP Plugin</a>
                            @endif
                            
                            <br clear="all" class="d-block d-sm-none" />
                        
                        	<input type="submit" value="Save" class="btn btn-primary float-right ml-1 dugme_submit">
							@if(!empty($data[0]))
                                <a href="{{ route('domains.add') }}" class="btn btn-success float-right ml-1">Add New</a>
                                <input type="button" name="del" value="Delete" class="btn btn-danger float-right ml-1" onClick="rusure(); return false;"/> 
                                <script>
                                    function rusure(){
                                        question = confirm("Are you sure you want to delete?")
                                        if (question !="0"){
                                            top.location = "{{ route('domains.delete', $data[0]->id) }}"
                                        }
                                    }
                                </script>
                            @endif
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
					var res = value.toLowerCase();
					return res
					.replace(/[^a-z0-9]/gi, "")
					;
				});
				
				SlugUpdateText();
				SlugUpdateAjax();
			  
			});
			
		}
		
		function SlugUpdateText () {
			
			var slug = $("#slug").val();
			$('#invite_link').val("{{ Auth::user()->member_id }}-"+slug+".{{ config('defines.MainTracker') }}");
			$('#cname').val("{{ Auth::user()->member_id }}-"+slug);
			
		}
		
		function SlugUpdateAjax () {

			var slug = $("#slug").val();
			
			if (slug) {
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'slug_chk', id: @if(!empty($data[0]->id)){{ $data[0]->id }}@else{{ '0' }}@endif, slug: slug},
					success: function(data) {
	
						if (data['chk'] === false) {
							$('#slug_error').show().html('You already have a slug like this.');
						} else {
							$('#slug_error').hide().html('');	
						}
						
					},
					async:true
				});
			}
			
		}
		
		
		$(document).ready(function() {
		
			SlugUpdateType();
			SlugUpdateText();
			
		});
	
	</script>
            
@endsection

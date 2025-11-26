@extends('layouts.app')

@section('content')

	@include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            @if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ 'Link' }}@endif
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('links.list') }}">Link Bank</a></li>
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
                	
					<form action="{{ route('links.update') }}" method="post" name="form" id="form" class="">
                    	@method('POST')
                        @csrf
                        
                        @if(!empty($data[0]))
                            <input type="hidden" name="id" value="{{ $data[0]->id }}">
                        @endif
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Choose Vendor</label>
                            <div class="col-md-3">
                                <select class="form-control" name="vendor_id">
                                	<option value="0">Select Vendor</option>
                                    @foreach ($vendors as $data_v)
                                        <option value="{{ $data_v->id }}"
                                         @if(!empty($data[0])) @if($data_v->id==$data[0]->vendor_id){{ ' selected="selected" ' }}@endif @endif
                                        >{{ $data_v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                            	<a href="javascript: void(0);" onclick="NewVendor_open();" class="btn btn-outline-info bs-tooltip" data-placement="top" data-original-title="Add New Vendor"><i class="fas fa-fw fa-plus"></i></a>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Name <span class="required_asterix">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="name" class="form-control required" value="@if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Destination Link <span class="required_asterix">*</span></label>
                            <div class="col-md-6">
                                <input type="text" name="url" class="form-control required" value="@if(!empty($data[0]->url)){{ $data[0]->url }}@else{{ '' }}@endif" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Choose Status</label>
                            <div class="col-md-3">
                                <select class="form-control" name="status">
                                    @foreach (config('defines.LinkStatus') as $data_k => $data_v)
                                        <option value="{{ $data_k }}"
                                         @if(!empty($data[0])) @if($data_k==$data[0]->status){{ ' selected="selected" ' }}@endif @endif
                                         @if(empty($data[0]) && $data_k==2){{ ' selected="selected" ' }}@endif
                                        >{{ $data_v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Choose Domain</label>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                     <input name="admin_domain" type="radio" class="uniform" value="1" onclick="VisibleLinkUpdateCheck();" @if(!empty($data[0]->admin_domain)) @if($data[0]->admin_domain == 1) {{ 'checked' }}@endif @else {{ 'checked' }} @endif />
                                     Use Admin Domain
                                </label>
                                &nbsp;
                                <label class="radio-inline">
                                     <input name="admin_domain" type="radio" class="uniform" value="2" onclick="VisibleLinkUpdateCheck();" @if(!empty($data[0]->admin_domain)) @if($data[0]->admin_domain == 2) {{ 'checked' }}@endif @endif />
                                     Use Custom Domain
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group row domain_id_hold">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <select class="form-control" name="domain_id" id="domain_id" onchange="VisibleLinkUpdateText();">
                                	<option value="0">Select Domain</option>
                                    @foreach ($domains as $data_v)
                                        <option value="{{ $data_v->id }}"
                                         @if(!empty($data[0])) @if($data_v->id==$data[0]->domain_id){{ ' selected="selected" ' }}@endif @endif
                                        >{{ $data_v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <?php /* ?>
                            <div class="col-md-2">
                            	<a href="javascript: void(0);" onclick="NewDomain_open();" class="btn btn-outline-info bs-tooltip domain_id_btn" data-placement="top" data-original-title="Add New Domain"><i class="fas fa-fw fa-plus"></i></a>
                            </div>
							<?php */ ?>
                        </div>
                        
                        <div class="form-group row">
                        	<div class="col-md-2"></div>
                            <div class="col-md-6">
                                <label class="checkbox-inline">
                                     <input name="cloak_url" type="checkbox" class="uniform" value="1" @if(!empty($data[0]->cloak_url)) @if($data[0]->cloak_url == 1) {{ 'checked' }}@endif @endif />
                                     Cloak URL
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Visible Link <span class="required_asterix">*</span></label>
                            <div class="col-md-3">
                                <input type="text" name="text_link" id="text_link" class="form-control required clean_link" autocomplete="off" value="@if(!empty($data[0]->text_link)){{ $data[0]->text_link }}@else{{ '' }}@endif" />
                                <span class="help-block" id="text_link_error" style="color:#F00; display:none;"></span>
                                <span class="help-block" id="text_link_hold" style="color:#069;"></span>
                                <input type="hidden" name="tracking_link" id="tracking_link" value="">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Choose Group</label>
                            <div class="col-md-3">
                                <select class="form-control" name="group_id">
                                	<option value="0">Select Group</option>
                                    @foreach ($groups as $data_v)
                                        <option value="{{ $data_v->id }}"
                                         @if(!empty($data[0])) @if($data_v->id==$data[0]->group_id){{ ' selected="selected" ' }}@endif @endif
                                        >{{ $data_v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                            	<a href="javascript: void(0);" onclick="NewGroup_open();" class="btn btn-outline-info bs-tooltip" data-placement="top" data-original-title="Add New Group"><i class="fas fa-fw fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <label class="col-form-label col-sm-2 text-sm-right">Extra Options</label>
                            <div class="col-md-10">
                               	<a href="javascript: void(0);" onclick="ExtraOption('rpixel_chk');" class="btn btn-outline-info rpixel_chk_button">Retargeting Pixel</a>
                                <a href="javascript: void(0);" onclick="ExtraOption('dates_chk');" class="btn btn-outline-info dates_chk_button">Dates</a>
                                <a href="javascript: void(0);" onclick="ExtraOption('pages_chk');" class="btn btn-outline-info pages_chk_button">Holding Pages</a>
                            </div>
                            <input type="hidden" name="rpixel_chk" value="@if(!empty($data[0]->rpixel_chk)) {{ $data[0]->rpixel_chk }} @endif">
                            <input type="hidden" name="dates_chk" value="@if(!empty($data[0]->dates_chk)) {{ $data[0]->dates_chk }} @endif">
                            <input type="hidden" name="pages_chk" value="@if(!empty($data[0]->pages_chk)) {{ $data[0]->pages_chk }} @endif">
                        </div>

                        <div class="card rpixel_chk_hold">
                            <div class="card-header">
                                <h4>Retargeting Pixel</h4>
                            </div>
                			<div class="card-body">
                            	<div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Choose Pixel</label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="rpixels_id">
                                            <option value="0">Select Retargeting Pixel</option>
                                            @foreach ($rpixel as $data_v)
                                                <option value="{{ $data_v->id }}"
                                                 @if(!empty($data[0])) @if($data_v->id==$data[0]->rpixels_id){{ ' selected="selected" ' }}@endif @endif
                                                >{{ $data_v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript: void(0);" onclick="NewRPixel_open();" class="btn btn-outline-info bs-tooltip" data-placement="top" data-original-title="Add New Retargeting Pixel"><i class="fas fa-fw fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card dates_chk_hold">
                            <div class="card-header">
                                <h4>Dates</h4>
                            </div>
                			<div class="card-body">
                            	<div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Start Date</label>
                                    <div class="col-md-3">
                                        <input type="text" name="date_start" class="form-control" value="" id="date_start" readonly />
                                        <input type="hidden" name="date_from_alt" id="date_from_alt" value="">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">End Date</label>
                                    <div class="col-md-3">
                                        <input type="text" name="date_end" class="form-control" value="" id="date_end" readonly />
                                        <input type="hidden" name="date_end_alt" id="date_end_alt" value="">
                                    </div>
                                </div>
                                <?php /* ?>
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-6">
                                        <label class="checkbox-inline">
                                             <input name="endless_chk" type="checkbox" id="endless_chk" class="uniform" value="1" onClick="EndlessChkUpdate();" @if(!empty($data[0]->endless_chk)) @if($data[0]->endless_chk == 1) {{ 'checked' }}@endif @endif />
                                             Endless
                                        </label>
                                    </div>
                                </div>
                                <?php */ ?>
                            </div>
                        </div>
                        
                        <div class="card pages_chk_hold">
                            <div class="card-header">
                                <h4>Holding Pages</h4>
                            </div>
                			<div class="card-body">
								<div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Choose Pending Page</label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="page_id_pending">
                                            <option value="0">Select Pending Page</option>
                                            @foreach ($pages as $data_v)
                                                <option value="{{ $data_v->id }}"
                                                 @if(!empty($data[0])) @if($data_v->id==$data[0]->page_id_pending){{ ' selected="selected" ' }}@endif @endif
                                                 @if(empty($data[0])) @if($data_v->panding_def==1){{ ' selected="selected" ' }}@endif @endif
                                                >{{ $data_v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript: void(0);" onclick="NewPendingPage_open();" class="btn btn-outline-info bs-tooltip" data-placement="top" data-original-title="Add New Pending Page"><i class="fas fa-fw fa-plus"></i></a>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Choose Complete Page</label>
                                    <div class="col-md-3">
                                        <select class="form-control" name="page_id_complete">
                                            <option value="0">Select Complete Page</option>
                                            @foreach ($pages as $data_v)
                                                <option value="{{ $data_v->id }}"
                                                 @if(!empty($data[0])) @if($data_v->id==$data[0]->page_id_complete){{ ' selected="selected" ' }}@endif @endif
                                                 @if(empty($data[0])) @if($data_v->complete_def==1){{ ' selected="selected" ' }}@endif @endif
                                                >{{ $data_v->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript: void(0);" onclick="NewCompletePage_open();" class="btn btn-outline-info bs-tooltip" data-placement="top" data-original-title="Add New Complete Page"><i class="fas fa-fw fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-actions">
                        	<input type="submit" value="Save" class="btn btn-primary float-right ml-1 dugme_submit">
							@if(!empty($data[0]))
                                <a href="{{ route('links.add') }}" class="btn btn-success float-right ml-1">Add New</a>
                                <input type="button" name="del" value="Delete" class="btn btn-danger float-right ml-1" onClick="rusure(); return false;"/> 
                                <script>
                                    function rusure(){
                                        question = confirm("Are you sure you want to delete?")
                                        if (question !="0"){
                                            top.location = "{{ route('links.delete', $data[0]->id) }}"
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
	
		var domain_array = new Array();
		@foreach ($domains as $data_v)
			domain_array[{{ $data_v->id }}] = '{{ $data_v->url }}';
		@endforeach
		
		
		function ExtraOption (type) {
			var value = $("input[name='"+type+"']").val();
			if (parseInt(value) == 1) {
				$("input[name='"+type+"']").val(0);
			} else {
				$("input[name='"+type+"']").val(1);
			}
			ExtraOptionChk (type);
		}
		
		function ExtraOptionChk (type) {
			var value = $("input[name='"+type+"']").val();
			if (parseInt(value) == 1) {
				$('.'+type+'_hold').show();
				$('.'+type+'_button').addClass('btn-success');
			} else {
				$('.'+type+'_hold').hide();
				$('.'+type+'_button').removeClass('btn-success');
			}
		}
		
		
		function VisibleLinkUpdateCheck () {
			if ($("input[name='admin_domain']:checked").val() == 1) {
				$('.domain_id_hold').hide();
				$('#domain_id, .domain_id_btn').attr('disabled', 'disabled').addClass('disable_input_custom');
			} else {
				$('.domain_id_hold').show();
				$('#domain_id, .domain_id_btn').removeAttr('disabled').removeClass('disable_input_custom');	
			}

			VisibleLinkUpdateText();
			
		}
		
		function VisibleLinkUpdateText () {
			
			var visible_link = '';
			var text_link = $("#text_link").val();
			
			if ($("input[name='admin_domain']:checked").val() == 1) {
				visible_link = "https://{{ Auth::user()->member_id }}.{{ config('defines.MainTracker') }}/" + text_link;
			} else {
				var domain_id = $("[name=domain_id] option:selected").val();
				if (typeof(domain_array[domain_id]) !== 'undefined') {
					visible_link = domain_array[domain_id] + '/' + text_link;
				}
			}
			
			$('#text_link_hold').html(visible_link);
			$('#tracking_link').val(visible_link);
			
		}
		
		function VisibleLinkUpdateType () {
			
			$('input.clean_link').keyup(function(event) {
				
				// skip for arrow keys
				if(event.which >= 37 && event.which <= 40){
					event.preventDefault();
				}
				
				$(this).val(function(index, value) {
					var res = value.toLowerCase();
					return res
					.replace(/[^a-z0-9-_]/gi, "")
					;
				});
				
				VisibleLinkUpdateText();
				VisibleLinkUpdateAjax();
			  
			});
			
		}
		
		function VisibleLinkUpdateAjax () {

			var text_link = $("#text_link").val();
			
			if (text_link) {
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'visible_link_chk', id: @if(!empty($data[0]->id)){{ $data[0]->id }}@else{{ '0' }}@endif, text_link: text_link},
					success: function(data) {
	
						if (data['chk'] === false) {
							$('#text_link_error').show().html('You already have a visible link like this.');
						} else {
							$('#text_link_error').hide().html('');	
						}
						
					},
					async:true
				});
			}
			
		}
		
		function EndlessChkUpdate () {
			
			if ($('#endless_chk').prop('checked')) {
				$('#date_end').attr('disabled', 'disabled').addClass('disable_input_custom');
			} else {
				$('#date_end').removeAttr('disabled').removeClass('disable_input_custom');	
			}
			
		}
		
		
		
		function NewVendor_open () {
			
			var html = '';
			var html_footer = '';
			
			html += '<form id="form_modal" class="form-horizontal row-border">';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Name <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="name" class="form-control required" value="" /></div></div>';
			html += '</form>';
			
			html_footer += '<a href="javascript: void(0);" data-dismiss="modal" class="btn btn-default">Close</a><a href="javascript: void(0);" onclick="NewVendor_send();" class="btn btn-success">Save</a>';
			
			sys_message_onload (html, 'popup', false, false, 'Add New Vendor', false, html_footer);	
			
		}
		function NewVendor_send () {
		
			if ($("#form_modal").valid() == true) {
				
				var name = $("#form_modal [name=name]").val();
				
				mouseLoader_2 ();
				
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'NewVendor', name: name},
					success: function(data) {
						
						mouseLoaderHide_2 ();
						modalClose ('#dModal', '#sys_messages_popup');

						var html = '<option value="0">Select Vendor</option>';
						for (var key in data['data_array']) {
							
							html += '<option value="'+data['data_array'][key]['id']+'"';
							if (parseInt(data['data_array'][key]['id']) == parseInt(data['last_id'])) html += ' selected="selected" ';
							html += '>'+data['data_array'][key]['name']+'</option>';
							
						}
						$('[name=vendor_id]').html(html);
						
					},
					async:true
				});
				
			}
			
		}
		
		
		function NewGroup_open () {
			
			var html = '';
			var html_footer = '';
			
			html += '<form id="form_modal" class="form-horizontal row-border">';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Name <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="name" class="form-control required" value="" /></div></div>';
			html += '</form>';
			
			html_footer += '<a href="javascript: void(0);" data-dismiss="modal" class="btn btn-default">Close</a><a href="javascript: void(0);" onclick="NewGroup_send();" class="btn btn-success">Save</a>';
			
			sys_message_onload (html, 'popup', false, false, 'Add New Group', false, html_footer);	
			
		}
		function NewGroup_send () {
		
			if ($("#form_modal").valid() == true) {
				
				var name = $("#form_modal [name=name]").val();
				
				mouseLoader_2 ();
				
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'NewGroup', name: name},
					success: function(data) {
						
						mouseLoaderHide_2 ();
						modalClose ('#dModal', '#sys_messages_popup');

						var html = '<option value="0">Select Group</option>';
						for (var key in data['data_array']) {
							
							html += '<option value="'+data['data_array'][key]['id']+'"';
							if (parseInt(data['data_array'][key]['id']) == parseInt(data['last_id'])) html += ' selected="selected" ';
							html += '>'+data['data_array'][key]['name']+'</option>';
							
						}
						$('[name=group_id]').html(html);
						
					},
					async:true
				});
				
			}
			
		}
		
		
		function NewRPixel_open () {
			
			var html = '';
			var html_footer = '';
			
			html += '<form id="form_modal" class="form-horizontal row-border">';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Name <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="name" class="form-control required" value="" /></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Code </label><div class="col-md-9"><textarea rows="5" name="code" class="form-control"></textarea></div></div>';
			html += '</form>';
			
			html_footer += '<a href="javascript: void(0);" data-dismiss="modal" class="btn btn-default">Close</a><a href="javascript: void(0);" onclick="NewRPixel_send();" class="btn btn-success">Save</a>';
			
			sys_message_onload (html, 'popup', false, false, 'Add New Retargeting Pixel', false, html_footer);	
			
		}
		function NewRPixel_send () {
		
			if ($("#form_modal").valid() == true) {
				
				var name = $("#form_modal [name=name]").val();
				var code = $("#form_modal [name=code]").val();
				
				mouseLoader_2 ();
				
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'NewRPixel', name: name, code: code},
					success: function(data) {
						
						mouseLoaderHide_2 ();
						modalClose ('#dModal', '#sys_messages_popup');

						var html = '<option value="0">Select Retargeting Pixel</option>';
						for (var key in data['data_array']) {
							
							html += '<option value="'+data['data_array'][key]['id']+'"';
							if (parseInt(data['data_array'][key]['id']) == parseInt(data['last_id'])) html += ' selected="selected" ';
							html += '>'+data['data_array'][key]['name']+'</option>';
							
						}
						$('[name=rpixels_id]').html(html);
						
					},
					async:true
				});
				
			}
			
		}
		
		
		function NewPendingPage_open () {
			
			var html = '';
			var html_footer = '';
			
			html += '<form id="form_modal" class="form-horizontal row-border">';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Name <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="name" class="form-control required" value="" /></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">URL <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="url" class="form-control required" value="" /></div></div>';
			html += '</form>';
			
			html_footer += '<a href="javascript: void(0);" data-dismiss="modal" class="btn btn-default">Close</a><a href="javascript: void(0);" onclick="NewPendingPage_send();" class="btn btn-success">Save</a>';
			
			sys_message_onload (html, 'popup', false, false, 'Add New Pending Page', false, html_footer);	
			
		}
		function NewPendingPage_send () {
		
			if ($("#form_modal").valid() == true) {
				
				var name = $("#form_modal [name=name]").val();
				var url = $("#form_modal [name=url]").val();
				
				mouseLoader_2 ();
				
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'NewPendingPage', name: name, url: url},
					success: function(data) {
						
						mouseLoaderHide_2 ();
						modalClose ('#dModal', '#sys_messages_popup');

						var html = '<option value="0">Select Pending Page</option>';
						for (var key in data['data_array']) {
							
							html += '<option value="'+data['data_array'][key]['id']+'"';
							if (parseInt(data['data_array'][key]['id']) == parseInt(data['last_id'])) html += ' selected="selected" ';
							html += '>'+data['data_array'][key]['name']+'</option>';
							
						}
						$('[name=page_id_pending]').html(html);
						
					},
					async:true
				});
				
			}
			
		}
		
		
		function NewCompletePage_open () {
			
			var html = '';
			var html_footer = '';
			
			html += '<form id="form_modal" class="form-horizontal row-border">';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Name <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="name" class="form-control required" value="" /></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">URL <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="url" class="form-control required" value="" /></div></div>';
			html += '</form>';
			
			html_footer += '<a href="javascript: void(0);" data-dismiss="modal" class="btn btn-default">Close</a><a href="javascript: void(0);" onclick="NewCompletePage_send();" class="btn btn-success">Save</a>';
			
			sys_message_onload (html, 'popup', false, false, 'Add New Complete Page', false, html_footer);	
			
		}
		function NewCompletePage_send () {
		
			if ($("#form_modal").valid() == true) {
				
				var name = $("#form_modal [name=name]").val();
				var url = $("#form_modal [name=url]").val();
				
				mouseLoader_2 ();
				
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'NewCompletePage', name: name, url: url},
					success: function(data) {
						
						mouseLoaderHide_2 ();
						modalClose ('#dModal', '#sys_messages_popup');

						var html = '<option value="0">Select Complete Page</option>';
						for (var key in data['data_array']) {
							
							html += '<option value="'+data['data_array'][key]['id']+'"';
							if (parseInt(data['data_array'][key]['id']) == parseInt(data['last_id'])) html += ' selected="selected" ';
							html += '>'+data['data_array'][key]['name']+'</option>';
							
						}
						$('[name=page_id_complete]').html(html);
						
					},
					async:true
				});
				
			}
			
		}
		
		
		function NewDomain_open () {
	
			var html = '';
			var html_footer = '';
			
			html += '<form id="form_modal" class="form-horizontal row-border">';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Name <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="name" class="form-control required" value="" /></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Slug <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="slug" id="slug" class="form-control required clean_slug" autocomplete="off" value="" /><span class="help-block" id="slug_error" style="color:#F00; display:none;"></span></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">URL <span class="required_asterix">*</span></label><div class="col-md-9"><input type="text" name="url" class="form-control required" value="" /></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Default URL</label><div class="col-md-9"><input type="text" name="default_url" class="form-control" value="" /></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Retargeting Pixel</label><div class="col-md-9"><textarea rows="5" name="pixel_code" class="form-control"></textarea></div></div>';
				html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">CName URL</label><div class="col-md-9"><input type="text" name="invite_link" id="invite_link" onClick="this.setSelectionRange(0, this.value.length)" class="form-control" value="" readonly /><input type="hidden" name="cname" id="cname" value="" /></div></div>';
				//html += '<div class="form-group row"><label class="col-form-label col-sm-3 text-sm-right">Is Forward Domain</label><div class="col-md-9"><label class="checkbox-inline"><input name="is_forward" type="checkbox" class="uniform" value="1" /></label></div></div>';
			html += '</form>';
			
			html_footer += '<a href="javascript: void(0);" data-dismiss="modal" class="btn btn-default">Close</a><a href="javascript: void(0);" onclick="NewDomain_send();" class="btn btn-success">Save</a>';
			
			sys_message_onload (html, 'popup', false, false, 'Add New Domain', false, html_footer);	
			
			//$('.uniform').uniform();
			SlugUpdateType();
			SlugUpdateText();
			
		}
		function NewDomain_send () {
		
			if ($("#form_modal").valid() == true) {
				
				var name = $("#form_modal [name=name]").val();
				var slug = $("#form_modal [name=slug]").val();
				var url = $("#form_modal [name=url]").val();
				var cname = $("#form_modal [name=cname]").val();
				var default_url = $("#form_modal [name=default_url]").val();
				var pixel_code = $("#form_modal [name=pixel_code]").val();
				var is_forward = 0;
				if ($('#form_modal [name=is_forward]').prop('checked')) is_forward = 1;

				mouseLoader_2 ();
				
				$.ajax({
					url: "{{ route('ajax') }}",
					dataType: 'jsonp',
					data: {page: 'NewDomain', name: name, slug: slug, url: url, cname: cname, default_url: default_url, pixel_code: pixel_code, is_forward: is_forward},
					success: function(data) {
						
						mouseLoaderHide_2 ();
						modalClose ('#dModal', '#sys_messages_popup');
						
						domain_array = new Array();
						var html = '<option value="0">Select Domain</option>';
						for (var key in data['data_array']) {
							
							domain_array[data['data_array'][key]['id']] = data['data_array'][key]['url'];
							
							html += '<option value="'+data['data_array'][key]['id']+'"';
							if (parseInt(data['data_array'][key]['id']) == parseInt(data['last_id'])) html += ' selected="selected" ';
							html += '>'+data['data_array'][key]['name']+'</option>';
							
						}
						$('[name=domain_id]').html(html);
						VisibleLinkUpdateText();
						
					},
					async:true
				});
				
			}
			
		}
		
		
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
				
				SlugUpdateText();
				SlugUpdateAjax();
			  
			});
			
		}
		
		function SlugUpdateText () {
			
			var slug = $("#slug").val();
			$('#invite_link').val("{{ Auth::user()->member_id }}-"+slug+".{{ config('defines.CNAMEURL') }}");
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
			
			@if (!empty ($data[0]->timestamp_start))
				var date_datepicker_from = new Date();
				date_datepicker_from.setTime({{ $data[0]->timestamp_start * 1000 }});
				date_datepicker_from = changeTimezone(date_datepicker_from, "{{Auth::user()->timeZone}}");
			@else
				var date_datepicker_from = new Date();
				date_datepicker_from.setHours(0,0,0,0);
			@endif
    
			var date_datepicker_new = new Date(date_datepicker_from.getTime() + 0);
			$("#date_from_alt").val(moment(date_datepicker_from).format("YYYY-MM-DD@HH:mm:ss"));
			
			$('#date_start').daterangepicker(
				{
					"locale": {
						"format": "{{ config('defines.DATERANGEFORMAT_JS') }} {{ config('defines.TIMEFORMAT_JS') }}",
						"separator": " - ",
						"applyLabel": "Apply",
						"cancelLabel": "Cancel",
						"firstDay": 1
					},
					timePicker: true,
					singleDatePicker: true,
					showDropdowns: true,
					startDate: date_datepicker_new,
				},
				function(start, end) {
					$("#date_from_alt").val(start.format('YYYY-MM-DD@HH:mm:ss'));
				}
			);
			
			
			@if (!empty ($data[0]->timestamp_end))
				var date_datepicker_from = new Date();
				date_datepicker_from.setTime({{ $data[0]->timestamp_end * 1000 }});
				date_datepicker_from = changeTimezone(date_datepicker_from, "{{Auth::user()->timeZone}}");
				var date_datepicker_new = new Date(date_datepicker_from.getTime() + 0);
			@else
				var date_datepicker_from = new Date();
				date_datepicker_from.setHours(0,0,0,0);
				var date_datepicker_new = new Date(date_datepicker_from.getTime() + (60*60*1000*24*30));
			@endif
      		
			$("#date_end_alt").val(moment(date_datepicker_new).format("YYYY-MM-DD@HH:mm:ss"));
			
			$('#date_end').daterangepicker(
				{
					"locale": {
						"format": "{{ config('defines.DATERANGEFORMAT_JS') }} {{ config('defines.TIMEFORMAT_JS') }}",
						"separator": " - ",
						"applyLabel": "Apply",
						"cancelLabel": "Cancel",
						"firstDay": 1
					},
					timePicker: true,
					singleDatePicker: true,
					showDropdowns: true,
					startDate: date_datepicker_new,
				},
				function(start, end) {
					$("#date_end_alt").val(start.format('YYYY-MM-DD@HH:mm:ss'));
				}
			);
  
 
			
			VisibleLinkUpdateType();
			VisibleLinkUpdateCheck();
			VisibleLinkUpdateAjax();
			EndlessChkUpdate();
			ExtraOptionChk ('rpixel_chk');
			ExtraOptionChk ('dates_chk');
			ExtraOptionChk ('pages_chk');
                           
		});
	
	</script>
            
@endsection

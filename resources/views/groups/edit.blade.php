@extends('layouts.app')

@section('content')

	@include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            @if(!empty($data[0]->name)){{ $data[0]->name }}@else{{ 'Group' }}@endif
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('groups.list') }}">Groups</a></li>
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
                	
					<form action="{{ route('groups.update') }}" method="post" name="form" id="form" class="">
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
                        
                        <div class="form-actions">
                        	<input type="submit" value="Save" class="btn btn-primary float-right ml-1 dugme_submit">
							@if(!empty($data[0]))
                                <a href="{{ route('groups.add') }}" class="btn btn-success float-right ml-1">Add New</a>
                                <input type="button" name="del" value="Delete" class="btn btn-danger float-right ml-1" onClick="rusure(); return false;"/> 
                                <script>
                                    function rusure(){
                                        question = confirm("Are you sure you want to delete?")
                                        if (question !="0"){
                                            top.location = "{{ route('groups.delete', $data[0]->id) }}"
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
            
@endsection

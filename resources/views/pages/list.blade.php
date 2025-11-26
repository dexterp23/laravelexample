@extends('layouts.app')

@section('content')

	@include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            Holding Pages
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Holding Pages</li>
            </ol>
        </nav>
    </div>
    
    
    <div class="row">
        <div class="col-12">
            <div class="card">
            	
                <div class="card-header">
                	<h4>Select Holding Pages</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('pages.updatedef') }}" name="form_pages" method="post" class="">
                    	
                        <div class="form-group">
                        	
                            @method('POST')
                        	@csrf
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="panding_def" class="control-label">Default Pending Page</label>
                                    <select id="panding_def" class="form-control" name="panding_def">
                                        <option value="0"> - none - </option>
                                        @foreach ($pages_all as $data_v)
                                            <option value="{{ $data_v->id }}"
                                             @if(!empty($pending_page[0])) @if($data_v->id==$pending_page[0]->id){{ ' selected="selected" ' }}@endif @endif
                                            >{{ $data_v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="complete_def" class="control-label">Default Complete Page</label>
                                    <select id="complete_def" class="form-control" name="complete_def">
                                        <option value="0"> - none - </option>
                                        @foreach ($pages_all as $data_v)
                                            <option value="{{ $data_v->id }}"
                                           @if(!empty($complete_page[0])) @if($data_v->id==$complete_page[0]->id){{ ' selected="selected" ' }}@endif @endif
                                            >{{ $data_v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <?php /* ?>
                                <div class="col-md-4">
                                    <label for="404_def" class="control-label">Default 404 Page</label>
                                    <select id="404_def" class="form-control" name="404_def">
                                        <option value="0"> - none - </option>
                                        @foreach ($pages_all as $data_v)
                                            <option value="{{ $data_v->id }}"
                                            @if(!empty($false_page[0])) @if($data_v->id==$false_page[0]->id){{ ' selected="selected" ' }}@endif @endif
                                            >{{ $data_v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <?php */ ?>
                            </div>
                            
                            <br clear="all" />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" value="Save Pages" class="btn btn-primary float-right ml-1">
                                </div>
                            </div>
    
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
            
                <div class="card-header">
                    <form id="form" name="form" method="get">
            
                        <div class="form-group">
                        
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="filter" class="control-label">Name</label>
                                    <input type="text" class="form-control" name="filter" id="filter" value="{{ $filter ?? '' }}">
                                </div>
                            </div>
                            
                            <br clear="all" />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('pages.add') }}" class="btn btn-success float-left">Add New</a>
                                
                                    <input type="submit" value="Search" class="btn btn-primary float-right ml-1">
                                    <a href="{{ route('pages.list') }}" class="btn btn-warning float-right ml-1">Reset</a>
                                </div>
                            </div>
    
                        </div>
                        
                    </form>
                </div>
                
                
                <div class="card-body">
                    
                    @if(count($data) == 0)
                    	<p>No entries</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered table-highlight-head">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>URL</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>    
                                <tbody>  
                                @foreach ($data as $data_v)
                                    <tr>
                                        <td><a href="{{ route('pages.edit', $data_v->id) }}">{{ $data_v->name }}</a></td>
                                        <td><a href="{{ $data_v->url }}" target="_blank">{{ $data_v->url }} <i class="fas fa-fw fa-external-link-alt"></i></a></td>
                                        <td class="table_center"><a href="{{ route('pages.edit', $data_v->id) }}" class="btn btn-sm btn-primary">Edit</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {!! $data->appends(request()->input())->links() !!}
                        
                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
            
@endsection

@extends('layouts.app')

@section('content')
	
    @include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            Link Bank
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Link Bank</li>
            </ol>
        </nav>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
            
                <div class="card-header">
                    <form id="form" name="form" method="get">
            
                        <div class="form-group">
                        
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="filter" class="control-label">Name</label>
                                    <input type="text" class="form-control" name="filter" id="filter" value="{{ $filter ?? '' }}">
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="vendor_id" class="control-label">Vendor</label>
                                    <select class="form-control" name="vendor_id">
                                        <option value="0">Select Vendor</option>
                                        @foreach ($vendors as $data_v)
                                            <option value="{{ $data_v->id }}"
                                            @if($data_v->id==$vendor_id){{ ' selected="selected" ' }}@endif
                                            >{{ $data_v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="group_id" class="control-label">Group</label>
                                    <select class="form-control" name="group_id">
                                        <option value="0">Select Group</option>
                                        @foreach ($groups as $data_v)
                                            <option value="{{ $data_v->id }}"
                                            @if($data_v->id==$group_id){{ ' selected="selected" ' }}@endif
                                            >{{ $data_v->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="status" class="control-label">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="0">Select Status</option>
                                        @foreach (config('defines.LinkStatus') as $data_k => $data_v)
                                            <option value="{{ $data_k }}"
                                            @if($data_k==$status){{ ' selected="selected" ' }}@endif
                                            >{{ $data_v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <br clear="all" />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('links.add') }}" class="btn btn-success float-left">Add New</a>
                                
                                    <input type="submit" value="Search" class="btn btn-primary float-right ml-1">
                                    <a href="{{ route('links.list') }}" class="btn btn-warning float-right ml-1">Reset</a>
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
                                        <th class="table_center">Link</th>
                                        <th class="table_center">Vendor</th>
                                        <th class="table_center text-info">Total Clicks</th>
                                        <th class="table_center text-info">Unique Clicks</th>
                                        <th class="table_center">Group</th>
                                        <th class="table_center">Created</th>
                                        <th class="table_center">Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>      
                                <tbody>   
                                @foreach ($data as $data_v)
                                    <tr>
                                        <td><a href="{{ route('links.edit', $data_v->id) }}">{{ $data_v->name }}</a></td>
                                        <td class="table_center"><a href="javascript: void(0);" data-clipboard-text="{{ $data_v->tracking_link }}" class="btn-copy btn btn-outline-info btn-sm">Copy</a></td>
                                        <td class="table_center">{{ $data_v->vendors_name }}</td>
                                        <td class="table_center">{{ $data_v->click_total }}</td>
                                        <td class="table_center">{{ $data_v->click_unique }}</td>
                                        <td class="table_center">{{ $data_v->groups_name }}</td>
                                        <td class="table_center">{{ \Carbon\Carbon::parse($data_v->created_at)->setTimezone(Auth::user()->timeZone)->format(config('defines.DATEFORMAT')) }}</td>
                                        <td class="table_center">{{ config('defines.LinkStatus')[$data_v->status] }}</td>
                                        <td class="table_center">
                                            <a href="{{ route('stats.list', [$data_v->id, 'list']) }}" class="btn btn-secondary btn-sm mb-1">Statistics</a>
                                            <a href="{{ route('links.edit', $data_v->id) }}" class="btn btn-sm btn-primary mb-1">Edit</a>
                                        </td>
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
    
    <script type="text/javascript" src="/js/clipboard/clipboard.min.js"></script>
    
        <script type="text/javascript">
		
		$(document).ready(function() {
			
			var clipboard = new ClipboardJS('.btn-copy');
                           
		});
	
	</script>
            
@endsection

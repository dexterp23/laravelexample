@extends('layouts.app')

@section('content')
	@include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            Retargeting Pixels
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Retargeting Pixels</li>
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
                                <div class="col-md-4">
                                    <label for="filter" class="control-label">Name</label>
                                    <input type="text" class="form-control" name="filter" id="filter" value="{{ $filter ?? '' }}">
                                </div>
                            </div>
                            
                            <br clear="all" />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('rpixels.add') }}" class="btn btn-success float-left">Add New</a>
                                
                                    <input type="submit" value="Search" class="btn btn-primary float-right ml-1">
                                    <a href="{{ route('rpixels.list') }}" class="btn btn-warning float-right ml-1">Reset</a>
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
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>   
                                <tbody>   
                                @foreach ($data as $data_v)
                                    <tr>
                                        <td><a href="{{ route('rpixels.edit', $data_v->id) }}">{{ $data_v->name }}</a></td>
                                        <td class="table_center"><a href="{{ route('rpixels.edit', $data_v->id) }}" class="btn btn-sm btn-primary">Edit</a></td>
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

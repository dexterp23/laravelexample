@extends('layouts.app')

@section('content')
	
    @include('layouts.alert')

	<div class="header">
        <h1 class="header-title">
            Users
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                                    <label for="filter" class="control-label">User Name / Email</label>
                                    <input type="text" class="form-control" name="filter" id="filter" value="{{ $filter ?? '' }}">
                                </div>
                            </div>
                            
                            <br clear="all" />
                            
                            <div class="row">
                                <div class="col-md-12">
                                	<?php /* ?>
                                    <a href="{{ route('users.add') }}" class="btn btn-success float-left">Add New</a>
                                	<?php */ ?>
                                    <input type="submit" value="Search" class="btn btn-primary float-right">
                                    <a href="{{ route('users.list') }}" class="btn btn-warning float-right mr-1">Reset</a>
                                </div>
                            </div>
    
                        </div>
                        
                    </form>
                </div>
                
                <div class="card-body">
                    
                    @if(count($users) == 0)
                    	<p>No entries</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered table-highlight-head">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="">Member ID</th>
                                        <th class="">Digi ID</th>
                                        <th class="">Email</th>
                                        <th class="table_center">Verified</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>    
                                <tbody>   
                                @foreach ($users as $user)
                                    <tr>
                                        <td><a href="{{ route('users.edit', $user->id) }}">{{ $user->name }}</a></td>
                                        <td class="">{{ $user->member_id }}</td>
                                        <td class="">{{ $user->digi_id }}</td>
                                        <td class="">{{ $user->email }}</td>
                                        <td class="table_center">
                                            @if ($user->email_verified_at)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td class="table_center"><a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {!! $users->appends(request()->input())->links() !!}
                        
                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
            
@endsection

@if (Auth::user())
	<nav id="sidebar" class="sidebar">
        <a class="sidebar-brand" href="{{ route('home') }}">
            <img src="/images/logo_light.png" title="{{ config('app.name', 'Laravel') }}" />
            <?php /* ?>{{ config('app.name', 'Laravel') }}<?php */ ?>
        </a>
        <div class="sidebar-content">
            <div class="sidebar-user">
                <div class="font-weight-bold">{{ Auth::user()->name }}</div>
            </div>
    
            <ul class="sidebar-nav">
            	
                @if (Auth::user()->role == "admin")
                	<li class="sidebar-item @if(Route::current()->getName() == 'users.list' || Route::current()->getName() == 'users.edit' || Route::current()->getName() == 'users.add'){{ 'active' }}@endif">
                        <a class="sidebar-link" href="{{ route('users.list') }}">
                            <i class="align-middle mr-2 fas fa-fw fa-user-friends"></i> <span class="align-middle">Users</span>
                        </a>
                    </li>
                @else
                	<li class="sidebar-item @if(Route::current()->getName() == 'links.list' || Route::current()->getName() == 'links.edit' || Route::current()->getName() == 'links.add' || Route::current()->getName() == 'stats.list'){{ 'active' }}@endif">
                        <a class="sidebar-link" href="{{ route('links.list') }}">
                            <i class="align-middle mr-2 fas fa-fw fa-link"></i> <span class="align-middle">Link Bank</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item @if(Route::current()->getName() == 'vendors.list' || Route::current()->getName() == 'vendors.edit' || Route::current()->getName() == 'vendors.add' || Route::current()->getName() == 'groups.list' || Route::current()->getName() == 'groups.edit' || Route::current()->getName() == 'groups.add' || Route::current()->getName() == 'rpixels.list' || Route::current()->getName() == 'rpixels.edit' || Route::current()->getName() == 'rpixels.add' || Route::current()->getName() == 'domains.list' || Route::current()->getName() == 'domains.edit' || Route::current()->getName() == 'domains.add' || Route::current()->getName() == 'pages.list' || Route::current()->getName() == 'pages.edit' || Route::current()->getName() == 'pages.add'){{ 'active' }}@endif">
						<a href="#settings" data-toggle="collapse" class="sidebar-link collapsed">
							<i class="align-middle mr-2 fas fa-fw fa-cog"></i> <span class="align-middle">Settings</span>
						</a>
						<ul id="settings" class="sidebar-dropdown list-unstyled collapse @if(Route::current()->getName() == 'vendors.list' || Route::current()->getName() == 'vendors.edit' || Route::current()->getName() == 'vendors.add' || Route::current()->getName() == 'groups.list' || Route::current()->getName() == 'groups.edit' || Route::current()->getName() == 'groups.add' || Route::current()->getName() == 'rpixels.list' || Route::current()->getName() == 'rpixels.edit' || Route::current()->getName() == 'rpixels.add' || Route::current()->getName() == 'domains.list' || Route::current()->getName() == 'domains.edit' || Route::current()->getName() == 'domains.add' || Route::current()->getName() == 'pages.list' || Route::current()->getName() == 'pages.edit' || Route::current()->getName() == 'pages.add'){{ 'show' }}@endif" data-parent="#sidebar">
							<li class="sidebar-item @if(Route::current()->getName() == 'vendors.list' || Route::current()->getName() == 'vendors.edit' || Route::current()->getName() == 'vendors.add'){{ 'active' }}@endif"><a class="sidebar-link" href="{{ route('vendors.list') }}">Vendors</a></li>
                            <li class="sidebar-item @if(Route::current()->getName() == 'groups.list' || Route::current()->getName() == 'groups.edit' || Route::current()->getName() == 'groups.add'){{ 'active' }}@endif"><a class="sidebar-link" href="{{ route('groups.list') }}">Groups</a></li>
                            <li class="sidebar-item @if(Route::current()->getName() == 'rpixels.list' || Route::current()->getName() == 'rpixels.edit' || Route::current()->getName() == 'rpixels.add'){{ 'active' }}@endif"><a class="sidebar-link" href="{{ route('rpixels.list') }}">Retargeting Pixels</a></li>
                            <li class="sidebar-item @if(Route::current()->getName() == 'domains.list' || Route::current()->getName() == 'domains.edit' || Route::current()->getName() == 'domains.add'){{ 'active' }}@endif"><a class="sidebar-link" href="{{ route('domains.list') }}">Domains</a></li>
                            <li class="sidebar-item @if(Route::current()->getName() == 'pages.list' || Route::current()->getName() == 'pages.edit' || Route::current()->getName() == 'pages.add'){{ 'active' }}@endif"><a class="sidebar-link" href="{{ route('pages.list') }}">Holding Pages</a></li>
						</ul>
					</li>
                    <li class="sidebar-item @if(Route::current()->getName() == 'other.videolibrary'){{ 'active' }}@endif">
                        <a class="sidebar-link" href="{{ route('other.videolibrary') }}">
                            <i class="align-middle mr-2 fas fa-fw fa-video"></i> <span class="align-middle">Video Library</span>
                        </a>
                    </li>
                @endif
                
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="align-middle mr-2 fas fa-fw fa-arrow-alt-circle-right"></i> <span class="align-middle">Log Out</span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
@endif

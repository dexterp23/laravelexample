@if (Auth::user())
    <nav class="navbar navbar-expand navbar-theme">
        <a class="sidebar-toggle d-flex mr-2">
            <i class="hamburger align-self-center"></i>
        </a>
    
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown ml-lg-2">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" data-toggle="dropdown">
                        <i class="align-middle fas fa-cog"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('user.profile') }}"><i class="align-middle mr-1 fas fa-fw fa-user"></i> My Profile</a>
                        @if (Auth::user()->role == "admin")
                        
                        @else
                        	<a class="dropdown-item" href="{{ route('other.videolibrary') }}"><i class="align-middle mr-1 fas fa-fw fa-video"></i> Video Library</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="align-middle mr-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out</a>
                    </div>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </div>
    
    </nav>
@else
	
@endif
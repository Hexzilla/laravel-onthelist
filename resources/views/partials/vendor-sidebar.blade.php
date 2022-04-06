<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-home"></i><span class="nav-text">Dashboard</span></a></li>

            <li class="{{ request()->routeIs('event.*') ? 'active' : '' }}"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account"></i><span class="nav-text">Events</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('event.create') }}">Create event</a></li>
                    <li><a href="{{ route('event.index') }}">My events</a></li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('venue.*') ? 'active' : '' }}"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-home-map-marker"></i><span class="nav-text">Venues</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('venue.create') }}">Create venue</a></li>
                    <li><a href="{{ route('venue.index') }}">My Venues</a></li>
                </ul>
            </li>

            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-restore-clock"></i><span class="nav-text">Orders</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="nav-text">Payments</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-content-save-settings"></i><span class="nav-text">Reps</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-crosshairs-gps"></i><span class="nav-text">Settings</span></a></li>
        </ul>
    </div>
</div>

<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="{{ route('dj.dashboard') }}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="nav-text">Dashboard</span></a></li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account"></i><span class="nav-text">Profile</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('dj.profile.create') }}">Create Profile</a></li>
                    <li><a href="{{ route('dj.profile.index') }}">My Profile</a></li>
                </ul>
            </li>
            <li><a href="{{ route('dj.event') }}" aria-expanded="false"><i class="mdi mdi-restore-clock"></i><span class="nav-text">Upcoming Events</span></a></li>

            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-restore-clock"></i><span class="nav-text">Orders</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="nav-text">Payments</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="nav-text">Reps</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="nav-text">Settings</span></a></li>
        </ul>
    </div>
</div>
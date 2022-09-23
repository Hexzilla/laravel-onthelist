<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a href="{{ route('vendors.dashboard')    }}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="nav-text">Dashboard</span></a></li>

            <li class="{{ request()->routeIs('vendors.event.*') ? 'active' : '' }}"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-ticket"></i><span class="nav-text">Events</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('vendors.event.create') }}">Create event</a></li>
                    <li><a href="{{ route('vendors.event.index') }}">My events</a></li>
                </ul>
            </li>

            

            <li class="{{ request()->routeIs('vendors.venue.*') ? 'active' : '' }}"><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-map-marker"></i><span class="nav-text">Venues</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('vendors.venue.create') }}">Create venue</a></li>
                    <li><a href="{{ route('vendors.venue.index') }}">My Venues</a></li>
                </ul>
            </li>
                
            <li class="{{ request()->routeIs('vendors.dj.*') ? 'active' : '' }}">
                <a href="{{ route('vendors.dj.index') }}"><i class="mdi mdi-headphones"></i><span class="nav-text">Djs</span></a>
            </li>
            <li><a href="{{ route('vendors.booking.index') }}"><i class="mdi mdi-table-large"></i><span class="nav-text">Bookings</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-restore-clock"></i><span class="nav-text">Orders</span></a></li>
            <li><a href="{{ route('vendors.payment.index') }}" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="nav-text">Payments</span></a></li>
            <li><a href="{{ route('vendors.reps')}}" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="nav-text">Reps</span></a></li>
            <li><a href="{{ route('vendors.setting.index') }}" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="nav-text">Settings</span></a></li>
        </ul>
    </div>
</div>

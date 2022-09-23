<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li>
                <a href="{{ route('customers.dashboard') }}" aria-expanded="false"><i class="mdi mdi-home"></i><span class="nav-text">Dashboard</span></a>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-ticket"></i><span class="nav-text">Events</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('customers.events.index') }}">All</a></li>
                    <li><a href="{{ route('customers.events.favorite') }}">Favourite</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-map-marker"></i><span class="nav-text">Venues</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('customers.venues.index') }}">All</a></li>
                    <li><a href="{{ route('customers.venues.favorite') }}">Favourite</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-headphones"></i><span class="nav-text">Djs</span></a>
                <ul aria-expanded="false">
                    <li><a href="javascript:void()">All</a></li>
                    <li><a href="javascript:void()">Favourite</a></li>
                </ul>
            </li>
            
            <li><a href="javascript:void()"><i class="mdi mdi-table-large"></i><span class="nav-text">Bookings</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-restore-clock"></i><span class="nav-text">Orders</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="nav-text">Payments</span></a></li>
            <li><a href="{{ route('customers.events.createRep') }}" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="nav-text">Reps</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="nav-text">Settings</span></a></li>
        </ul>
    </div>
</div>

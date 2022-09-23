<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" aria-expanded="false">
                    <i class="mdi mdi-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account"></i><span class="nav-text">Users</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.vendors.index') }}">Vendors</a></li>
                    <li><a href="{{ route('admin.djs.index') }}">Djs</a></li>
                    <!-- <li><a href="{{ route('admin.users.index', ['role' => 'promoter']) }}">Promoters</a></li> -->
                    <li><a href="{{ route('admin.users.index', ['role' => 'customer']) }}">Customers</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-map-marker"></i><span class="nav-text">Venues</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.venues.index') }}">All</a></li>
                    <li><a href="{{ route('admin.venues.featured') }}">Featured</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-ticket"></i><span class="nav-text">Events</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.events.index') }}">All</a></li>
                    <li><a href="{{ route('admin.events.upcoming') }}">Upcoming</a></li>
                    <li><a href="{{ route('admin.events.featured') }}">Featured</a></li>
                    <li><a href="{{ route('admin.events.complete') }}">Complete</a></li>
                </ul>
            </li>

            <li><a href="{{ route('admin.booking.index') }}" aria-expanded="false"><i class="mdi mdi-table-large"></i><span class="nav-text">Bookings</span></a></li>
            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="nav-text">Payments</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.payments.vendor' )}}">Details</a></li>
                    <!-- <li><a href="#">Orders</a></li>
                    <li><a href="#">Invoices</a></li>
                    <li><a href="#">Transactions</a></li> -->
                </ul>
            </li>
            <li><a href="{{ route('admin.notifications.create') }}" aria-expanded="false"><i class="mdi mdi-bell-ring"></i><span class="nav-text">Notifications</span></a></li>
            <li><a href="javascript:void()" aria-expanded="false"><i class="mdi mdi-content-save-settings"></i><span class="nav-text">Logs</span></a></li>
            <li><a href="{{ route('admin.setting.index') }}" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="nav-text">Settings</span></a></li>

        </ul>
    </div>
</div>

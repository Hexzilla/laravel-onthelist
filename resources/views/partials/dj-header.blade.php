<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="header-left">
                <div class="header-caption">
                    Welcome To OnTheList Dashboard
                </div>
                <img src="{{asset('images/logo.png')}}" class="logo-abbr" height="30" />
            </div>
            <div class="collapse navbar-collapse justify-content-end">

                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-bell"></i>
                            <span class="badge badge-primary">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header">
                                <h5 class="notification_title">Notifications</h5>
                            </div>
                            <ul class="list-unstyled">
                                <li class="media dropdown-item">
                                    <span class="text-primary"><i class="mdi mdi-chart-areaspline mr-3"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <div class="d-flex justify-content-between">
                                                <h5>New order has been received</h5>
                                            </div>
                                            <p class="m-0">2 hours ago</p>
                                        </a>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="text-success"><i class="mdi mdi-chart-pie mr-3"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <div class="d-flex justify-content-between">
                                                <h5>New customer is registered</h5>
                                            </div>
                                            <p class="m-0">3 hours ago</p>
                                        </a>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="text-warning"><i class="mdi mdi-file-document mr-3"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <div class="d-flex justify-content-between">
                                                <h5>New file has been uploaded</h5>
                                            </div>
                                            <p class="m-0">3 hours ago</p>
                                        </a>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </li>
                            </ul>
                            <a class="all-notification" href="#">All Notifications</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("images/user/no-avatar.png") }}" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-profile-header">
                                <img src="{{ asset("images/user/no-avatar.png") }}" alt="">
                                <span class="avatar-name ml-2">John Doe</span>
                            </div>
                            <a href="{{ route('dj.profile.index')}}" class="dropdown-item">
                                <i class="mdi mdi-account"></i>
                                <span>Profile</span>
                            </a>
                            <a href="home-create-ticket.html" class="dropdown-item">
                                <i class="mdi mdi-ticket"></i>
                                <span>Create Ticket</span>
                            </a>
                            <a href="email-inbox.html" class="dropdown-item">
                                <i class="mdi mdi-email"></i>
                                <span>Inbox</span>
                            </a>
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-power"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

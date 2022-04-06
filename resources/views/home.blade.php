<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="author" content="" />
    <title>OnTheList</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}" type="text/css" />
    <!-- Bootstrap-4 Minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css" />
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" type="text/css" />
    <!-- Media CSS -->
    <link rel="stylesheet" href="{{ asset('css/media.css') }}" type="text/css" />
</head>

<body>
    <!-- Mobile Navbar Menu Section Starts -->
    <div class="container-fluid bg-navbar-menu-mobile">
        <div class="row">
            <div class="col-3">
                <div class="burger-menu">
                    <span></span>
                </div>
            </div>
            <div class="col-6 text-center">
                <div class="main-logo">
                    <a href="{{ url('/') }}">
                        <img src="images/logo.png" class="img-fluid" alt="" />
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Navbar Menu Section Ends -->
    <!-- Fixed Sidebar Menu Section Starts -->
    <div class="fixed-sidebar-menu-mobile">
        <div class="fixed-sidebar-menu-close text-right">
            <svg class="close-menu-white" viewBox="0 0 24 24" fill="currentColor" width="30px" height="30px"
                data-ux="CloseIcon" data-edit-interactive="true" data-close="true"
                class="x-el x-el-svg c1-1 c1-2 c1-5p c1-2d c1-37 c1-2f c1-2g c1-2h c1-2i c1-21 c1-6w c1-6x c1-59 c1-6y c1-6z c1-70 c1-b c1-2a c1-71 c1-72 c1-73 c1-74">
                <path fill-rule="evenodd"
                    d="M17.999 4l-6.293 6.293L5.413 4 4 5.414l6.292 6.293L4 18l1.413 1.414 6.293-6.292 6.293 6.292L19.414 18l-6.294-6.293 6.294-6.293z">
                </path>
            </svg>
        </div>
        <ul class="menu-listing-mobile">
            <li class="active"><a href="#DownloadNow">Download App</a></li>
            <li><a href="#Contact">Contact </a></li>
            <li><a href="{{ route('login') }}">Venue/Promoter Login</a></li>
        </ul>
    </div>
    <!-- Fixed Sidebar Menu Section Ends -->
    <!-- Desktop Navbar Menu Section Starts -->
    <div class="container-fluid bg-navbar-menu-desktop">
        <div class="row">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 col-lg-3 col-xl-3">
                        <div class="main-logo">
                            <a href="{{ url('/') }}">
                                <img src="images/logo.png" class="img-fluid" alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-9 col-xl-9">
                        <ul class="menu-listing-desktop d-flex align-items-center justify-content-end">
                            <li class="active"><a href="#DownloadNow">Download App</a></li>
                            <li><a href="#Contact">Contact </a></li>
                            <li><a href="{{ route('login') }}">Venue/Promoter Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Desktop Navbar Menu Section Ends -->

    <!-- Banner Section Starts -->
    <div class="container-fluid bg-banner">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-7 col-sm-8">
                        <div class="banner-info">
                            <h3>Are You...<span>on the list?</span></h3>
                            <h1>The Personel<br> Party app guide <br>in your pocket </h1>
                            <ul>
                                <li>Descover Bars & Clubs</li>
                                <li>Book Tables</li>
                                <li>Buy Tickets</li>
                                <li>Get on GuestList</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-5 col-sm-4 banner-img"> <img src="images/mobile-phone.png" alt=""
                            class="img-fluid"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section Ends -->

    <!-- Below Banner Section Starts -->
    <div class="container-fluid below-banner">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li>Available to download now on </li>
                            <li><a href=""><img src="images/app-store-avail.png" alt=""></a></li>
                            <li><a href=""><img src="images/google-play-avail.png" alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Below Banner Section Ends -->

    <!-- WhatDoesItDo Section Starts -->
    <div class="container-fluid bg-whtdo">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <section class="section-heading dark text-center">
                            <h2>What does it do?</h2>
                            <p>ever been out on the town or on a night out in different city but didn’t know where to
                                go, or what was on?? maybe you knew where
                                you wanted to go but didnt know how to book a table, buy a ticket or get on the
                                guestlist? Then On The List is the perfect Solution for you.
                                OnThe List.. Created for partygoers by partygoers.</p>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="whtdo-box text-center">
                            <div class="img-box"><img src="images/whtdo-1.png" class="img-fluid" alt="">
                            </div>
                            <h5>Discover Bars & Clubs</h5>
                            <p>Whether you’re venturing out
                                of town or staying local find what’s going
                                on closest to you. See what’s
                                happening tonight or plan ahead.</p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="whtdo-box text-center">
                            <div class="img-box"><img src="images/whtdo-2.png" class="img-fluid" alt="">
                            </div>
                            <h5>Book Tables</h5>
                            <p>Tired of waiting at the bar for
                                hours for a drink? Why not book a
                                table and avoid all hassle. Party
                                in style and book a table.</p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="whtdo-box text-center">
                            <div class="img-box"><img src="images/whtdo-3.png" class="img-fluid" alt="">
                            </div>
                            <h5>Buy Tickets</h5>
                            <p>Buy tickets for upcoming
                                events and keep them stored on your
                                phone to produce when you arrive
                                at the venue.</p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="whtdo-box text-center">
                            <div class="img-box"><img src="images/whtdo-4.png" class="img-fluid" alt="">
                            </div>
                            <h5>Get on the Guestlist</h5>
                            <p>Get on guestlist for parties
                                and events. Share with friends for them
                                to get themselves on the guestlist
                                too.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- WhatDoesItDo Section Section Ends -->

    <!-- Play Your NightOut Section Starts -->
    <div class="container-fluid bg-nightOut">
        <div class="row align-items-top">
            <div class="col-lg-5"><img src="images/mobile.png" alt="" class="img-fluid"></div>
            <div class="col-lg-7 nightOut-content">
                <section class="section-heading">
                    <h2>Plan Your Night Out</h2>
                </section>
                <div class="">
                    <h4>Start your night right!</h4>
                    <p>On The List is the perfect new app designed to fulfill all your needs for a brilliant night out.
                        Find everything you need in one place to make your experience come alive, as
                        simply as possible. Save time trying to find and book venues when everything
                        you need is in the app.
                    </p>
                    <ul>
                        <li>Search for Events and Venues.</li>
                        <li>Book Tables, Tickets and Guestlist.</li>
                        <li>Bookings and E-tickets saved to your calender.</li>
                        <li>Share events and venues with your friends.</li>
                        <li>Create your profile and connect with other users.</li>
                    </ul>
                    <button class="download-btn">Download</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Play Your NightOut Section Ends -->
    <!-- Our Growth Section Starts -->
    <div class="container-fluid bg-our-growth">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 offset-sm-0 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <section class="section-heading dark text-center">
                            <h2>Our Growth</h2>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                        <div class="row" id="counter">
                            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <div class="growth-box">
                                    <div class="counter-wrap"><span class="counter-value" data-count="4"></span>
                                    </div>
                                    <span>Cities</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <div class="growth-box">
                                    <div class="counter-wrap"><span class="counter-value"
                                            data-count="200"></span><span>+</span></div>
                                    <span>Venues</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <div class="growth-box">
                                    <div class="counter-wrap"><span class="counter-value"
                                            data-count="25000"></span><span>+</span></div>
                                    <span>Bookings</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                <div class="growth-box">
                                    <div class="counter-wrap"><span class="counter-value"
                                            data-count="10000"></span><span>+</span></div>
                                    <span>Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Growth Section Ends -->
    <!-- Download Now Section Starts -->
    <div class="container-fluid download-now" id="DownloadNow">
        <div class="download-now-overlay"></div>
        <div class="row section-padding">
            <div class="col-12">
                <section class="section-heading text-center">
                    <h2>DOWNLOAD NOW</h2>
                    <p>now Available to download from the app store and google Play.</p>
                </section>
                <div class="text-center">
                    <ul class="and-list">
                        <li><a href=""><img src="images/app-store-avail.png" alt=""></a></li>
                        <li><a href=""><img src="images/google-play-avail.png" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Download Now Section Ends -->
    <!-- Section break Starts -->
    <div class="container-fluid sectionBreak">
        <div class="row">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
    <!-- Section break ends -->
    <!-- Now Available Section Starts -->
    <div class="container-fluid now-avail-section">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <section class="section-heading text-center">
                            <h2>Now Available in</h2>
                            <p>We are now available in the following cities. So to find out whats on the in the citiees
                                below. Download the app to start your search and get booking. </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <a href="" class="avail-img-box">
                    <img src="images/avail-1.jpg" alt="" class="img-fluid">
                    <span class="avail-content">Birmingham</span>
                </a>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <a href="" class="avail-img-box">
                    <img src="images/avail-2.jpg" alt="" class="img-fluid">
                    <span class="avail-content">London</span>
                </a>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <a href="" class="avail-img-box">
                    <img src="images/avail-3.jpg" alt="" class="img-fluid">
                    <span class="avail-content">Manchester</span>
                </a>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">
                <a href="" class="avail-img-box">
                    <img src="images/avail-4.jpg" alt="" class="img-fluid">
                    <span class="avail-content">Liverpool</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <section class="section-heading text-center">
                            <h4>MORE CITIES AVAILABLE SOON.</h4>
                        </section>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Now Available Section Ends -->
    <!-- Section break Starts -->
    <div class="container-fluid sectionBreak">
        <div class="row">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
    <!-- Section break ends -->
    <!-- GetInTouch Section Starts -->
    <div class="container-fluid GetInTouch" id="Contact">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                        <section class="section-heading text-center">
                            <h2>Get In Touch</h2>
                            <p>Let us know how we can help. For assistance Get in touch.</p>
                        </section>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Name">
                                    <input type="Email" class="form-control" placeholder="Email">
                                    <input type="text" class="form-control" placeholder="Subject">
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="" rows="5" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn send-btn">Send</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- GetInTouch Section Ends -->
    <!-- Social Media Section Starts -->
    <div class="container-fluid bg-social">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="social_list">
                            <li><a href=""><i class="fab fa-instagram"></i></a></li>
                            <li><a href=""><i class="fab fa-facebook-square"></i></a></li>
                            <li><a href=""><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Social Media Section Ends -->
    <!-- Copyright Section Starts -->
    <div class="container-fluid bg-copyright">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright-info text-center">
                            <p>©<span>On the list </span>2022 All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright Section Ends -->
    <!-- BG Blur Section Starts -->
    <div class="bg-blur"></div>
    <!-- BG Blur Section Ends -->
    <!-- jQuery Library -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>

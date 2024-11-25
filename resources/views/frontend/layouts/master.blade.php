<!DOCTYPE html>
<html lang="en">
<head>
    <title>Textile Coated Fabric and PVC Membrane Film Manufacturer | Archanalok Trading Co.&nbsp;|&nbsp;Archanalok
        Trading Co..</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    @yield('og_metatag_section')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Start Include All CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/elegant-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fishto-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/lightcase.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/flaticon_mycollection.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/toastr.min.css') }}">
    <!-- End Include All CSS -->
    <link  rel="shortcut icon" type="image/png" href="{{ asset('frontend/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon-180x180.png" />
</head>
<body>
       <!-- Header Start -->
   <header class="header-01  head-sticky header-bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <!-- logo Start-->
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('frontend/images/archanalok-logo-1.png') }}" alt="">
                    </a>
                    <!-- logo End-->
                    <!-- Moblie Btn Start -->
                    <button class="navbar-toggler" type="button">
                        <i class="nss-bars1"></i>
                    </button>
                    <!-- Moblie Btn End -->
                    <!-- Nav Menu Start -->
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav">
                            <li class="menu-item-has-children">
                                {{-- <a href="index.html">Home</a> --}}
                                <a href="javascript:void(0);">Home</a>
                            </li>
                            <li>
                                {{-- <a href="about.html">About</a> --}}
                                <a href="javascript:void(0);">About</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="javascript:void(0);">Products
                                    <ul class="sub-menu">
                                        {{-- <li><a href="cat-product-page.html">Pvc Membrane</a></li> --}}
                                        <li><a href="javascript:void(0);">Pvc Membrane</a></li>
                                        <li><a href="#">Synthetic Leather(Rexine)</a></li>
                                        <li><a href="#">Vinyl Flooring</a></li>
                                        <li><a href="#">Laminate Sheet</a></li>
                                        <li><a href="#">All Other Flooring</a></li>
                                        <li><a href="#">PVC Sheeting</a></li>
                                    </ul>
                                </a>
                            </li>
                            <li>
                                {{-- <a href="contact.html">Contact</a> --}}
                                <a href="javascript:void(0);">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Nav Menu End -->
                    <!-- Btn -->
                    <div class="access-btn">
                        <a href="javascript:void(0);" class="btn-search"><i class="nss-search1"></i></a>
                        <a href="myaccount.html" class="btn-user"><i class="nss-user1"></i></a>
                        <a href="cart.html" class="btn-cart"><i class="nss-shopping-cart1"></i><span>1</span></a>
                    </div>
                    <!-- Btn -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->
<!-- Popup Search Start -->
<section class="popup_search_sec">
    <div class="popup_search_overlay"></div>
    <div class="pop_search_background">
        <div class="middle_search">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="popup_search_form">
                            <form method="get" action="#">
                                <input type="search" name="s" id="s"
                                    placeholder="Type Words and Hit Enter">
                                <button type="submit"><i class="nss-search1"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Popup Search End -->
    @yield('content')

      <!--=============================
        FOOTER START
    ==============================-->
    @include('frontend.layouts.footer')
    <!--=============================
        FOOTER END
    ==============================-->

       <!--=============================
        SCROLL BUTTON START
    ==============================-->
    <a href="#" id="back-to-top">
        <i class="arrow_carrot-2up"></i>
    </a>
    <!--=============================
        SCROLL BUTTON END
    ==============================-->

    <!-- Start Include All JS -->
    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.js') }}"></script>
    <script src="{{ asset('frontend/js/lightcase.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('frontend/js/theme.js') }}"></script>
    <!-- End Include All JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('frontend/js/toastr.min.js') }}"></script>
    <script>
        toastr.options.progressBar = true;
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        // set csrf token as a header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @include('frontend.layouts.global-scripts')
    
    @stack('scripts')
</body>
</html>

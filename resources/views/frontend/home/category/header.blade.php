    <!-- Header Start -->
    <header class="header-01  head-sticky header-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <!-- logo Start-->
                        <a class="navbar-brand" href="#">
                            <img src="{{ asset('frontend/images/pvc-archanalok-logo.png') }}" alt="">
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
                                    <a href="javascript:void(0);">{{ $mainCategory->name }}
                                        <ul class="sub-menu">
                                            @foreach ($categories as $category)
                                                <li><a href="javascript:void(0);">{{ $category->category_name }}</a></li>
                                            @endforeach
                                           
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
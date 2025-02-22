    <!-- Header Start -->
    <header class="header-01  head-sticky header-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <!-- logo Start-->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset($mainCategory->logo) }}" alt="">
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
                                    <a href="{{ url($mainCategory->slug) }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('about') }}">About</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="javascript:void(0);">{{ $mainCategory->name }}
                                        <ul class="sub-menu">
                                            @foreach ($categories as $category)
                                                <li><a
                                                        href="{{ url($mainCategory->slug."/".$category->slug) }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </a>
                                </li>


                                <li>
                                    <a href="{{ route('contact.index') }}">Contact</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Nav Menu End -->
                        <!-- Btn -->
                        @include('frontend.layouts.user_icons')
                        <!-- Btn -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

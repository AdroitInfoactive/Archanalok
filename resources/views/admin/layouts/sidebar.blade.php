<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->user()->avatar) }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi,{{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                {{-- <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a> --}}
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Archanlok</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">A</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ setSidebarActive(['admin.dashboard']) }}"><a class="nav-link"
                    href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="menu-header">Archanlok</li>

            <li class="{{ setSidebarActive(['admin.banner-slider.*']) }}"><a class="nav-link"
                    href="{{ route('admin.banner-slider.index') }}"><i class="fas fa-images"></i><span>Banner
                        Slider</span></a></li>
            <li
                class="dropdown {{ setSidebarActive(['admin.category.*', 'admin.product.*', 'admin.main-category.*', 'admin.sub-category.*', 'admin.variant-master.*', 'admin.variant-details.*', 'admin.main-category-banner.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-shopping-cart"></i>
                    <span>Manage Products </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.main-category.*', 'admin.main-category-banner.*']) }}"><a
                            class="nav-link" href="{{ route('admin.main-category.index') }}">Product Main
                            Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.category.*']) }}"><a class="nav-link"
                            href="{{ route('admin.category.index') }}">Product Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.sub-category.*']) }}"><a class="nav-link"
                            href="{{ route('admin.sub-category.index') }}">Product Sub Categories</a></li>

                    <li class="{{ setSidebarActive(['admin.variant-master.*']) }}"><a class="nav-link"
                            href="{{ route('admin.variant-master.index') }}">Variants</a></li>
                    <li class="{{ setSidebarActive(['admin.variant-details.*']) }}"><a class="nav-link"
                            href="{{ route('admin.variant-details.index') }}">Variants Details</a></li>


                </ul>
            </li>
            <li
                class="dropdown {{ setSidebarActive(['admin.about.*', 'admin.privacy-policy.*', 'admin.shipping-policy.*', 'admin.return-policy.*', 'admin.terms-and-conditions.*', 'admin.contact.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-stream"></i>
                    <span>Pages </span></a>
                <ul class="dropdown-menu">

                    <li class="{{ setSidebarActive(['admin.about.*']) }}"><a class="nav-link"
                            href="{{ route('admin.about.index') }}">About us</a></li>
                    <li class="{{ setSidebarActive(['admin.privacy-policy.*']) }}"><a class="nav-link"
                            href="{{ route('admin.privacy-policy.index') }}">Privacy Policy</a></li>
                    <li class="{{ setSidebarActive(['admin.shipping-policy.*']) }}"><a class="nav-link"
                            href="{{ route('admin.shipping-policy.index') }}">Shipping Policy</a></li>
                    <li class="{{ setSidebarActive(['admin.return-policy.*']) }}"><a class="nav-link"
                            href="{{ route('admin.return-policy.index') }}">Return Policy</a></li>

                    <li class="{{ setSidebarActive(['admin.terms-and-conditions.index*']) }}"><a class="nav-link"
                            href="{{ route('admin.terms-and-conditions.index') }}">Terms And Conditions</a></li>
                    <li class="{{ setSidebarActive(['admin.contact.index']) }}"><a class="nav-link"
                            href="{{ route('admin.contact.index') }}">Contact</a></li>

                </ul>
            </li>
            <li
            class="dropdown {{ setSidebarActive(['admin.counter.*','admin.home-info.*']) }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-stream"></i>
                <span>Sections </span></a>
            <ul class="dropdown-menu">
               
                <li class="{{ setSidebarActive(['admin.counter.index']) }}"><a class="nav-link"
                        href="{{ route('admin.counter.index') }}">Counter</a></li>
                <li class="{{ setSidebarActive(['admin.home-info.index']) }}"><a class="nav-link"
                        href="{{ route('admin.home-info.index') }}">About Home Page</a></li>

            </ul>
        </li>

            <li class="{{ setSidebarActive(['admin.social-link.*']) }}"><a class="nav-link"
                    href="{{ route('admin.social-link.index') }}"><i class="fas fa-link"></i>
                    <span>Social Links</span></a></li>
            <li class="{{ setSidebarActive(['admin.footer-info.index']) }}"><a class="nav-link"
                    href="{{ route('admin.footer-info.index') }}"> <i class="fas fa-info-circle"></i> <span>Footer
                        Info</span></a></li>
           

            <li class="{{ setSidebarActive(['admin.setting.index']) }}"><a class="nav-link"
                    href="{{ route('admin.setting.index') }}"><i class="fas fa-cogs"></i>
                    <span>Settings</span></a></li>
                   
        </ul>

    </aside>
</div>

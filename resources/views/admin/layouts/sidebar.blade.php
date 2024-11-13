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
            <a href="{{ route('admin.dashboard') }}">Home</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">Home</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ setSidebarActive(['admin.dashboard']) }}"><a class="nav-link"
                    href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="menu-header">Starter</li>
            <li><a class="nav-link"
                href="#"><i class="fas fa-images"></i> <span>Banners</span></a></li>
                <li
                class="dropdown {{ setSidebarActive(['admin.category.*', 'admin.product.*', 'admin.main-category.*', 'admin.sub-category.*', 'admin.variant-master.*', 'admin.variant-details.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-shopping-cart"></i>
                    <span>Manage Products </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.main-category.*']) }}"><a class="nav-link" href="{{ route('admin.main-category.index') }}">Product Main Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.category.*']) }}"><a class="nav-link" href="{{ route('admin.category.index') }}">Product Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.sub-category.*']) }}"><a class="nav-link" href="{{ route('admin.sub-category.index') }}">Product Sub Categories</a></li>
                    <li class="{{ setSidebarActive(['admin.product.*']) }}"><a class="nav-link" href="">Products</a></li>
                    <li class="{{ setSidebarActive(['admin.variant-master.*']) }}"><a class="nav-link" href="{{ route('admin.variant-master.index') }}">Variants</a></li>
                    <li class="{{ setSidebarActive(['admin.variant-details.*']) }}"><a class="nav-link" href="{{ route('admin.variant-details.index') }}">Variants Details</a></li>

                    
                </ul>
            </li>
          {{--  <li class="{{ setSidebarActive(['admin.slider.*']) }}"><a class="nav-link"
                    href="{{ route('admin.slider.index') }}"><i class="fas fa-images"></i>
                    <span>Slider</span></a></li> --}}
      
                    <li class="{{ setSidebarActive(['admin.setting.index']) }}"><a class="nav-link"
                        href="{{ route('admin.setting.index') }}"><i class="fas fa-cogs"></i>
                        <span>Settings</span></a></li>


        </ul>

    </aside>
</div>

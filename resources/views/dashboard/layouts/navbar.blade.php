@extends('dashboard.layouts.header')
@section('content')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                <div class="app-brand demo ">
                    <a href="" class="app-brand-link">
                        <span class="app-brand-logo demo"><img src="{{ route('view-image', ['m' => 'App\Models\User', 'id' => $loginUser->id , 'nameVar'=> 'avatar']) }}"  alt="{{ $loginUser->name }}"  class="w-px-40 h-auto rounded-circle"></span><span class="app-brand-text demo menu-text ms-2" style="font-size: 100%;font-weight: bold;font-family: sans-serif;color: #364f50;">{{ $loginUser->name }}</span></a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i></a>
                </div>

                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    {{-- @can('view-dashboard') --}}
                    <li class="menu-item" data-path="{{ route('dashboard.index') }}">
                        <a href="{{ route('dashboard.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>
                    {{-- @endcan --}}

                    <li class="menu-item" data-path="{{ route('contacts.index') }}">
                        <a href="{{ route('contacts.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-phone"></i>
                            <div class="text-truncate" data-i18n="Contacts">Contacts</div>
                        </a>
                    </li>

                    @can('layout-gallery')
                    <li class="menu-item" data-path="{{ route('gallery.index') }}">
                        <a href="{{ route('gallery.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-image"></i>
                            <div class="text-truncate" data-i18n="Gallery">Gallery</div>
                        </a>
                    </li>
                    @endcan

                    <li class="menu-item" data-path="{{ route('settings.index') }}">
                        <a href="{{ route('settings.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div class="text-truncate" data-i18n="Settings">Settings</div>
                        </a>
                    </li>

                    @can('layout-roles')
                    <li class="menu-item" data-path="javascript:void(0);">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-user-shield"></i>
                            <div class="text-truncate" data-i18n="Roles & Permissions">Roles & Permissions</div>
                        </a>
                        <ul class="menu-sub">
                            @can('layout-users')
                            <li class="menu-item" data-path="{{ route('users.index') }}">
                                <a href="{{ route('users.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Users">Users</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-users')
                            <li class="menu-item" data-path="{{ route('users.create') }}">
                                <a href="{{ route('users.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Create Users">Create Users</div>
                                </a>
                            </li>
                            @endcan
                            @can('layout-roles')
                            <li class="menu-item" data-path="{{ route('roles.index') }}">
                                <a href="{{ route('roles.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Permissions">Permissions</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- App Slider -->
                    @can('view-slider')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-slider"></i>
                            <div class="text-truncate" data-i18n="App Slider">App Slider</div>
                        </a>
                        <ul class="menu-sub">
                            @can('view-slider')
                            <li class="menu-item">
                                <a href="{{ route('appSlider.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-slider')
                            <li class="menu-item">
                                <a href="{{ route('appSlider.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- Category -->
                    @can('view-category')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-category"></i>
                            <div class="text-truncate" data-i18n="Category">Category</div>
                        </a>
                        <ul class="menu-sub">
                            @can('view-category')
                            <li class="menu-item">
                                <a href="{{ route('category.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-category')
                            <li class="menu-item">
                                <a href="{{ route('category.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- Services -->
                    @can('view-service')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-briefcase"></i>
                            <div class="text-truncate" data-i18n="Services">Services</div>
                        </a>
                        <ul class="menu-sub">
                            @can('view-service')
                            <li class="menu-item">
                                <a href="{{ route('service.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-service')
                            <li class="menu-item">
                                <a href="{{ route('service.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- FAQ -->
                    @can('view-faq')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-question-mark"></i>
                            <div class="text-truncate" data-i18n="FAQ">FAQ</div>
                        </a>
                        <ul class="menu-sub">
                            @can('view-faq')
                            <li class="menu-item">
                                <a href="{{ route('faq.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-faq')
                            <li class="menu-item">
                                <a href="{{ route('faq.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- Testimonials -->
                    @can('view-testimonials')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-comment"></i>
                            <div class="text-truncate" data-i18n="Testimonials">Testimonials</div>
                        </a>
                        <ul class="menu-sub">
                            @can('view-testimonials')
                            <li class="menu-item">
                                <a href="{{ route('testimonials.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-testimonials')
                            <li class="menu-item">
                                <a href="{{ route('testimonials.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- Licenses -->
                    @can('view-licenses')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-key"></i>
                            <div class="text-truncate" data-i18n="Licenses">Licenses</div>
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="{{ route('sales.reports') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="sales Reports">sales.reports</div>
                                </a>
                            </li>
                            @can('view-licenses')
                            <li class="menu-item">
                                <a href="{{ route('license.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-licenses')
                            <li class="menu-item">
                                <a href="{{ route('license.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- Programs -->
                    @can('view-programs')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-line-chart"></i>
                            <div class="text-truncate" data-i18n="Programs">Programs</div>
                        </a>
                        <ul class="menu-sub">
                            @can('view-programs')
                            <li class="menu-item">
                                <a href="{{ route('program.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-programs')
                            <li class="menu-item">
                                <a href="{{ route('program.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan

                    <!-- Clients -->
                    @can('view-clients')
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div class="text-truncate" data-i18n="Clients">Clients</div>
                        </a>
                        <ul class="menu-sub">
                            @can('view-clients')
                            <li class="menu-item">
                                <a href="{{ route('clients.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            @endcan
                            @can('create-clients')
                            <li class="menu-item">
                                <a href="{{ route('clients.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                </ul>



            </aside>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    <i class="bx bx-search bx-sm"></i>
                                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Search -->
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Quick links -->
                            <!-- Style Switcher -->
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class='bx bx-sm'></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i class='bx bx-sun me-2'></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="https://ui-avatars.com/api/?name={{ $loginUser->name }}" alt="{{ $loginUser->name }}"
                                            class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="https://ui-avatars.com/api/?name={{ $loginUser->name }}" alt="{{ $loginUser->name }}"
                                                            class="w-px-40 h-auto rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block">{{ $loginUser->name }}</span>
                                                    <small class="text-muted">{{ $loginUser->email }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login.logout') }}" >
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->
                @yield('body')

                @yield('footer')
            @endsection

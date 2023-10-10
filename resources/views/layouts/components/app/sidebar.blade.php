<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center d-flex justify-content-center">
        <img src="{{ asset('img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        {{-- <span class="brand-text font-weight-light">Admin</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{ optional(request()->user())->photo ?? asset('img/user2-160x160.jpg') }}"
                    fetchpriority="high"
                    class="img-circle elevation-2"
                    alt="User Image"
                >
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ optional(request()->user())->name ?? 'Alexander Pierce'}}</</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-mosque"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('article.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-mosque"></i>
                        <p>Artikel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('study.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-mosque"></i>
                        <p>Kajian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('mosquee.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-mosque"></i>
                        <p>Lokasi Masjid</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('murottal.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-mosque"></i>
                        <p>Murottal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hadist.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-mosque"></i>
                        <p>Hadist</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dzikir.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-mosque"></i>
                        <p>Dzikir</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.agenda.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>Agenda</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.diklat.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>Diklat</p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="{{ route('admin.unit.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>Unit</p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}" class="nav-link">
                        <i class="nav-icon far fa-image"></i>
                        <p>Sertifikat</p>
                    </a>
                </li> --}}

                @if (optional(request()->user())->status === '0')
                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}" class="nav-link">
                            <i class="nav-icon far fa-image"></i>
                            <p>Pengguna</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

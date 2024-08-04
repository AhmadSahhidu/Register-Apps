@php
    $roleuser = userRoleName();
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('./assets/logo2.png') }}" style="width: 50px" />
        </div>
        <div class="sidebar-brand-text mx-3">P4LSI Apps</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    <li class="nav-item @if (Route::is('dashboard')) active @endif">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    @if ($roleuser === 'Super Admin' || $roleuser === 'Admin')
        <li class="nav-item @if (Route::is([
                'korwil.index',
                'competision.index',
                'korwil.create',
                'korwil.show',
                'competision.create',
                'korwil.anggota',
                'competision.show',
            ])) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Master</span>
            </a>
            <div id="collapseTwo" class="collapse @if (Route::is([
                    'korwil.index',
                    'korwil.create',
                    'korwil.show',
                    'korwil.anggota',
                    'competision.index',
                    'competision.create',
                    'competision.show',
                ])) show @endif"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master List :</h6>
                    {{-- @if ($aksesviewMerek || $roleuser === 'Super Admin') --}}
                    <a class="collapse-item @if (Route::is(['korda.index', 'korwil.create', 'korwil.show'])) active @endif"
                        href="{{ route('korda.index') }}">Korda</a>
                    <a class="collapse-item @if (Route::is(['korwil.index', 'korwil.create', 'korwil.show', 'korwil.anggota'])) active @endif"
                        href="{{ route('korwil.index') }}">Korwil</a>

                    <a class="collapse-item @if (Route::is(['competision.index', 'competision.create', 'competision.show'])) active @endif"
                        href="{{ route('competision.index') }}">Kompetisi / Lomba</a>
                    {{-- @endif
                    @if ($aksesviewCategory || $roleuser === 'Super Admin') --}}

                </div>
            </div>
        </li>
        <li class="nav-item @if (Route::is('register.register_umum')) active @endif">
            <a class="nav-link" href="{{ route('register.register_umum') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Pendaftaran</span></a>
        </li>
        <li class="nav-item @if (Route::is('register.register_umum')) active @endif">
            <a class="nav-link" href="{{ route('register.register_umum') }}">
                <i class="fas fa-fw fa-money-bill"></i>
                <span>Pembayaran</span></a>
        </li>
    @endif
    @if ($roleuser === 'Korwil' || $roleuser === 'Korda' || $roleuser === 'DPP')
        <li class="nav-item @if (Route::is('register.index')) active @endif">
            <a class="nav-link" href="{{ route('register.index') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Pendaftaran</span></a>
        </li>
        <li class="nav-item @if (Route::is('anggota.index')) active @endif">
            <a class="nav-link" href="{{ route('anggota.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Anggota</span></a>
        </li>
    @endif
    @if ($roleuser === 'Super Admin' || $roleuser === 'Admin')
        <li class="nav-item @if (Route::is(['roles.index', 'roles.create', 'roles.edit', 'users.index', 'users.create'])) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#access"
                aria-expanded="true" aria-controls="access">
                <i class="fas fa-fw fa-key"></i>
                <span>Hak Akses</span>
            </a>
            <div id="access" class="collapse @if (Route::is(['roles.index', 'roles.create', 'roles.edit', 'users.index', 'users.create'])) show @endif"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">List Hak Akses :</h6>
                    {{-- @if ($aksesviewMerek || $roleuser === 'Super Admin') --}}
                    <a class="collapse-item @if (Route::is(['roles.index', 'roles.create', 'roles.edit'])) active @endif"
                        href="{{ route('roles.index') }}">Role User</a>

                    <a class="collapse-item @if (Route::is(['users.index', 'users.create'])) active @endif"
                        href="{{ route('users.index') }}">Pengguna</a>
                    {{-- @endif
                    @if ($aksesviewCategory || $roleuser === 'Super Admin') --}}

                </div>
            </div>
        </li>
    @endif


    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ $title == 'Dashboard' ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('admin.dashboard') }} "><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            {{-- --}}
            <li class="menu-header">Website Contents</li>
            <li
                class="{{ ($title == 'Berita') ? 'active' : (($title == 'Kategori') ? 'active' : (($title == 'Tags') ? 'active' : '' ))}}">
                <a class="nav-link has-dropdown" href=""><i class="fas fa-gear"></i><span>Berita dan
                        Artikel</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $title == 'Berita' ? 'active' : '' }}">
                        <a class="nav-link" href=" {{ route('admin.berita') }} "></i><span>Berita dan
                                Artikel</span></a>
                    </li>
                    <li class="{{ $title == 'Kategori' ? 'active' : '' }}">
                        <a class="nav-link" href=" {{ route('admin.categories') }} "></i><span>Kategori</span></a>
                    </li>
                    <li class="{{ $title == 'Tags' ? 'active' : '' }}">
                        <a class="nav-link" href=" {{ route('admin.tags') }} "></i><span>Tags</span></a>
                    </li>
                </ul>
            </li>

            <li class="{{ $title == 'Galeri' ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('admin.gallery') }} "><i
                        class="fas fa-photo-video"></i><span>Galeri</span></a>
            </li>
            <li class="{{ $title == 'Guru dan Staff' ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('admin.teachers') }} "><i class="fas fa-users"></i><span>Guru dan
                        Staff</span></a>
            </li>

            {{-- --}}
            <li class="menu-header">Master Admin</li>
            <li class="{{ $title == 'Manajemen User' ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('admin.users') }} "><i class="fas fa-user-tie"></i><span>Manajemen
                        User</span></a>
            </li>
            <li class="{{ ($title == 'Tema Website') ? 'active' : (($title == 'Informasi Website') ? 'active' : "")}}">
                <a class="nav-link has-dropdown" href=""><i class="fas fa-gear"></i><span>Website
                        Settings</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $title == 'Tema Website' ? 'active' : '' }}"><a
                            href="{{ route('admin.theme.settings') }} " class="nav-link"><span>Tema Website</span></a>
                    </li>
                    <li class="{{ $title == 'Informasi Website' ? 'active' : '' }}"><a
                            href="{{ route('admin.information.settings') }}" class="nav-link">Informasi
                            Website</a></li>
                </ul>
            </li>

            <li class="menu-header">PPDB Admin</li>
            <li class="{{ $title == 'Form PPDB' ? 'active' : '' }}">
                <a class="nav-link" href=" {{ route('admin.ppdb.form_ppdb') }} "><i
                        class="fas fa-file-invoice"></i><span>Form PPDB</span></a>
            </li>
            {{-- <li class="{{ $title == 'Data PPDB' ? 'active' : '' }}">
                <a class="nav-link" href=" {{route('admin.ppdb-data')}} "><i class="fas fa-database"></i><span>Data
                        PPDB</span></a>
            </li> --}}

        </ul>
    </aside>
</div>
<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class=" fas fa-fire"></i><span>Dashboard</span>
    </a>
</li>
@if (auth()->user()->role == 'admin')
    <li class="side-menus {{ Request::is('d/karyawan') ? 'active' : '' }}">
        <a class="nav-link" href="/d/karyawan">
            <i class=" fas fa-users"></i><span>Data karayawan</span>
        </a>
    </li>
    <li class="side-menus {{ Request::is('d/barang') ? 'active' : '' }}">
        <a class="nav-link" href="/d/barang">
            <i class=" fas fa-list"></i><span>Data Menu</span>
        </a>
    </li>
@else
{{-- menu karyawan --}}
<li class="side-menus {{ Request::is('d/barang') ? 'active' : '' }}">
    <a class="nav-link" href="/d/barang">
        <i class=" fas fa-list"></i><span>Data Menu</span>
    </a>
</li>
@endif
<li class="side-menus {{ Request::is('d/gaji/karyawan') ? 'active' : '' }}">
    <a class="nav-link" href="/d/gaji/karyawan">
        <i class=" fas fa-money-check"></i><span>Data Gaji Karyawan</span>
    </a>
</li>
<li class="side-menus {{ Request::is('d/transaksi') ? 'active' : '' }}">
    <a class="nav-link" href="/d/transaksi">
        <i class=" fas fa-cash-register"></i><span>Kasir</span>
    </a>
</li>

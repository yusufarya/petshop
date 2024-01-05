<?php
    $profileImg = $auth_user->image ? $auth_user->image : 'userDefault.png';
    $level_user =  $auth_user->admin_level->id;
?>

<!-- Main Sidebar Container -->
{{-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> --}}
<aside class="main-sidebar sidebar-light-lightblue elevation-2">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('img/logo-bussiness.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-1" style="opacity: 1">
        <span class="brand-text my-color-secondary font-weight-bold"> SI-PETSHOP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(!$auth_user->image)
                    <img src="{{ asset('img/userDefault.png') }}" class="img-circle elevation-0" alt="User Image">
                @else
                    <img src="{{ asset('/storage').'/'.$auth_user->image }}" class="img-circle elevation-0" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="/profile" class="d-block link_profile px-2 {{ Request::segment(1) === 'profile' ? 'profile-active' : '' }}">{{ $auth_user->fullname }} </a>
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
                    <a href="/dashboard" class="nav-link {{ Request::segment(1) === 'dashboard' ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard  </p>
                    </a> 
                </li> 
                
                <li class="nav-item {{ Request::segment(1) === 'data-admin' || Request::segment(1) === 'data-customer' || Request::segment(1) === 'detail-customer' || Request::segment(1) === 'form-edit-admin'  ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Data Pengguna
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/data-admin" class="nav-link {{ Request::segment(1) === 'data-admin' || Request::segment(1) === 'form-edit-admin' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Data Admin</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/data-customer" class="nav-link {{ Request::segment(1) === 'data-customer' || Request::segment(1) === 'detail-customer' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Data Pelanggan</p>
                            </a> 
                        </li>
                    </ul>
                </li>
                
                {{-- <li class="nav-header">Layanan</li> --}}
                <li class="nav-item {{ Request::segment(1) === 'units' || Request::segment(1) === 'sizes' || Request::segment(1) === 'categories' || Request::segment(1) === 'products' || Request::segment(1) === 'services' || Request::segment(1) === 'update-stock' || Request::segment(1) === 'inventories'  ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Master Persediaan
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/units" class="nav-link {{ Request::segment(1) === 'units' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Master Satuan</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/sizes" class="nav-link {{ Request::segment(1) === 'sizes' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Master Ukuran</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/categories" class="nav-link {{ Request::segment(1) === 'categories' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Master Kategori</p>
                            </a> 
                        </li> 
                        <li class="nav-item">
                            <a href="/products" class="nav-link {{ Request::segment(1) === 'products' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Daftar Produk</p>
                            </a> 
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/services" class="nav-link {{ Request::segment(1) === 'services' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Daftar Layanan</p>
                            </a> 
                        </li> --}}
                        <li class="nav-item">
                            <a href="/update-stock" class="nav-link {{ Request::segment(1) === 'update-stock' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Update Stok Produk</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/inventories" class="nav-link {{ Request::segment(1) === 'inventories' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Persediaan Produk</p>
                            </a> 
                        </li>
                    </ul>
                </li> 
                {{-- <li class="nav-header">Pembelian</li> --}}
                <li class="nav-item {{ Request::segment(1) === 'vendors' || Request::segment(1) === 'purchase-order' || Request::segment(1) === 'purchase-report' ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>
                            Pembelian
                            <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/vendors" class="nav-link {{ Request::segment(1) === 'vendors' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Vendor</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/purchase-order" class="nav-link {{ Request::segment(1) === 'purchase-order' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Transaksi Pembelian</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/purchase-report" class="nav-link {{ Request::segment(1) === 'purchase-report' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Laporan Pembelian</p>
                            </a> 
                        </li>
                    </ul>
                </li> 
                
                {{-- <li class="nav-header">Penjualan</li> --}}
                <li class="nav-item {{ Request::segment(1) === 'orders' || Request::segment(1) === 'sales-order' || Request::segment(1) === 'sales-report' || Request::segment(1) === 'service-report' || Request::segment(1) === 'service-order' ? 'menu-is-opening menu-open' : '' }}" {{ $level_user == 3 ? 'hidden' : '' }}>
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Penjualan
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        
                        <li class="nav-item">
                            <a href="/service-order" class="nav-link {{ Request::segment(1) === 'service-order' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p> Order Layanan </p>
                            </a> 
                        </li>

                        <li class="nav-item">
                            <a href="/orders" class="nav-link {{ Request::segment(1) === 'orders' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Pesanan </p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/sales-order" class="nav-link {{ Request::segment(1) === 'sales-order' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Order Penjualan</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/sales-report" class="nav-link {{ Request::segment(1) === 'sales-report' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Laporan Penjualan</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/service-report" class="nav-link {{ Request::segment(1) === 'service-report' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Laporan Pelayanan</p>
                            </a> 
                        </li>
                    </ul>
                </li>

                {{-- Delivery --}}
                <li class="nav-item {{ Request::segment(1) === 'delivery-types' || Request::segment(1) === 'delivery' ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Pengiriman
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/delivery-types" class="nav-link {{ Request::segment(1) === 'delivery-types' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Jenis Pengiriman</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/delivery" class="nav-link {{ Request::segment(1) === 'delivery' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Pengiriman Pesanan</p>
                            </a> 
                        </li>
                    </ul>
                </li> 

                {{-- Finance --}}
                <li class="nav-item {{ Request::segment(1) === 'payment-method' || Request::segment(1) === 'financial-report' ? 'menu-is-opening menu-open' : '' }}" {{ $level_user == 3 ? 'hidden' : '' }}>
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>
                            Keuangan
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/payment-method" class="nav-link {{ Request::segment(1) === 'payment-method' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Metode Pembayaran</p>
                            </a> 
                        </li>
                        <li class="nav-item" hidden>
                            <a href="/financial-report" class="nav-link {{ Request::segment(1) === 'financial-report' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Laporan Keuangan</p>
                            </a> 
                        </li>
                    </ul>
                </li> 
                
                {{-- <li class="nav-header">Lainnya</li>
                <li class="nav-item">
                    <a href="/set-period" class="nav-link {{ Request::segment(1) === 'set-period' ? 'submenu-active' : '' }}">
                        <i class="nav-icon fas fa-calendar-minus"></i>
                        <p>Periode</p>
                    </a>
                </li> 
                
                <li class="nav-item">
                    <a href="/settings" class="nav-link {{ Request::segment(1) === 'settings' ? 'submenu-active' : '' }}">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>  --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
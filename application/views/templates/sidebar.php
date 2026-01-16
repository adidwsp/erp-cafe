<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url('dashboard') ?>" class="brand-link">
        <img src="<?= base_url('assets'); ?>/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin ERP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets'); ?>/template/dist/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= site_url('users/profile') ?>" class="d-block">
                    <?= $this->session->userdata('name') ?: 'User' ?>
                    <br>
                    <small>(<?= get_user_role_name($this->session->userdata('role')) ?>)</small>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- DASHBOARD - Semua role bisa akses (karena default permission untuk semua role) -->
                <li class="nav-item">
                    <a href="<?= site_url('dashboard') ?>" class="nav-link <?= is_submenu_active('dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- MODUL HUMAN RESOURCES -->
                <?php if (bisa_akses('hr')): ?>
                    <li class="nav-header">HUMAN RESOURCES</li>
                    <li class="nav-item has-treeview <?= is_submenu_active(['employees', 'hr']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= is_submenu_active(['employees', 'hr']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Human Resources
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url('employees/employees') ?>" class="nav-link <?= is_submenu_active('employees/employees') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Karyawan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('employees/attendances') ?>" class="nav-link <?= is_submenu_active('employees/attendances') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Absensi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('employees/salary') ?>" class="nav-link <?= is_submenu_active('employees/salary') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penggajian</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- MODUL SALES -->
                <?php if (bisa_akses('sales')): ?>
                    <li class="nav-header">SALES</li>
                    <li class="nav-item has-treeview <?= is_submenu_active(['sales', 'customers', 'orders']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= is_submenu_active(['sales', 'customers', 'orders']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Sales
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url('sales/orders') ?>" class="nav-link <?= is_submenu_active('sales/orders') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('sales/customers') ?>" class="nav-link <?= is_submenu_active('sales/customers') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Customer</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('sales/receivables') ?>" class="nav-link <?= is_submenu_active('sales/receivables') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Piutang</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- MODUL PURCHASING -->
                <?php if (bisa_akses('purchasing')): ?>
                    <li class="nav-header">PURCHASING</li>
                    <li class="nav-item has-treeview <?= is_submenu_active(['purchasing', 'suppliers']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= is_submenu_active(['purchasing', 'suppliers']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>
                                Purchasing
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url('purchasing/orders') ?>" class="nav-link <?= is_submenu_active('purchasing/orders') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Pembelian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('purchasing/suppliers') ?>" class="nav-link <?= is_submenu_active('purchasing/suppliers') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Supplier</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- MODUL INVENTORY -->
                <?php if (bisa_akses('inventory')): ?>
                    <li class="nav-header">INVENTORY</li>
                    <li class="nav-item has-treeview <?= is_submenu_active(['inventory', 'products', 'stocks', 'mutations']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= is_submenu_active(['inventory', 'products', 'stocks', 'mutations']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>
                                Inventory
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url('inventory/products') ?>" class="nav-link <?= is_submenu_active('inventory/products') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Barang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('inventory/stocks') ?>" class="nav-link <?= is_submenu_active('inventory/stocks') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Stock</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('inventory/mutations') ?>" class="nav-link <?= is_submenu_active('inventory/mutations') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Mutasi Barang</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- USER MANAGEMENT - Hanya untuk admin dan owner -->
                <?php if (hanya_untuk_role(['administrator', 'owner'])): ?>
                    <li class="nav-header">ADMINISTRASI</li>
                    <li class="nav-item has-treeview <?= is_submenu_active(['users', 'roles']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= is_submenu_active(['users', 'roles']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                Manajemen User
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url('users/users') ?>" class="nav-link <?= is_submenu_active('users') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Pengguna</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('users/roles') ?>" class="nav-link <?= is_submenu_active('roles') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manajemen Role</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- PROFIL & LOGOUT -->
                <li class="nav-header">AKUN</li>
                <li class="nav-item">
                    <a href="<?= site_url('dashboard/profile') ?>" class="nav-link <?= is_submenu_active('dashboard/profile') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('auth/logout') ?>" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
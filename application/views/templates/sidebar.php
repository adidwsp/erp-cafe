  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="<?= base_url('assets'); ?>/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">Admin ERP</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="<?= base_url('assets'); ?>/template/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="flex">Adi Dwi</a>
                  <!-- tombol logout tampak seperti icon — menggunakan form POST (aman) -->
                  <?= form_open('auth/logout', ['id' => 'logoutForm', 'style' => 'display:inline-block;margin-left:8px;']) ?>
                  <button type="submit" class="btn btn-sm btn-link p-0" onclick="return confirm('Logout sekarang?')"
                      title="Logout" style="color:inherit;">
                      <i class="fa fa-times"></i>
                  </button>
                  <?= form_close(); ?>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-header">ADMIN</li>
                  <li class="nav-item has-treeview menu-open">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Penjualan</p>
                              </a>
                              <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Dashboard</p>
                              </a>
                          </li>
                      </ul>
                  <li class="nav-item">
                      <a href="users" class="nav-link <?= is_submenu_active('users') ? 'active' : '' ?>">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Manajemen Pengguna
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>

          <!-- MODUL HUMAN RESOURCES -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-header">HUMAN RESOURCES</li>
                  <li class="nav-item has-treeview menu-open">

                      <a href="#" class="nav-link collapsed">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Human Resources
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link <?= is_submenu_active('dashboard') ? 'active' : '' ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Karyawan</p>
                              </a>
                              <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Absensi</p>
                              </a>
                              <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Penggajian</p>
                              </a>
                          </li>

                      </ul>
                  </li>
              </ul>
          </nav>

          <!-- MODUL SALES -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-header">SALES</li>
                  <li class="nav-item has-treeview menu-open">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Sales
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Penjualan</p>
                              </a>
                              <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Customer</p>
                              </a>
                              <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Piutang</p>
                              </a>
                          </li>

                      </ul>
                  </li>
              </ul>
          </nav>
          <!-- MODUL PURCHASING -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-header">PURCHASING</li>
                  <li class="nav-item has-treeview menu-open">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Purchasing
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Pembelian</p>
                              </a>
                              <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Supplier</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </nav>

          <!-- MODUL INVENTORY -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-header">INVENTORY</li>
                  <li class="nav-item has-treeview menu-open">

                      <a href="#" class="nav-link <?= is_submenu_active('inventory') ? 'active' : '' ?>">
                          <i class=" nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Inventory
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="inventory" class="nav-link <?= is_submenu_active('inventory') ? 'active' : '' ?>">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Data Barang</p>
                              </a>
                              <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Mutasi Barang</p>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </nav>
          <div>
              <br>
              <br>
              <br>
              <br>
          </div>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Bagas Cell<sup>®</sup></div>
    </a>
    <!-- Divider -->

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if ($halaman == "index") { echo "active"; } ?>">
    <a href="index.php" class="nav-link">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <?php if (($_SESSION['level']=="admin")) { ?>
    <!-- Nav Item - Charts -->
    <li class="nav-item <?php if ($halaman == "barang") { echo "active"; } ?>">
    <a href="produk.php" class="nav-link">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Barang & Stok</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item <?php if ($halaman == "transaksi") { echo "active"; } ?>">
    <a href="transaksi.php" class="nav-link">
        <i class="fas fa-fw fa-calculator"></i>
        <span>Transaksi</span>
    </a>
    </li>
    <li class="nav-item <?php if ($halaman == "lap_stok") { echo "active"; } ?>">
    <a href="lap_stok.php" class="nav-link">
        <i class="fas fa-fw fa-clipboard"></i>
        <span>Lap Stok Barang</span>
    </a>
    </li>
    <li class="nav-item <?php if ($halaman == "lap_penjualan") { echo "active"; } ?>">
    <a href="lap_penjualan.php" class="nav-link">
        <i class="fas fa-fw fa-clipboard"></i>
        <span>Laporan Penjualan</span>
    </a>
    </li>
    <!-- Divider -->
    <?php } else { ?>
    <li class="nav-item <?php if ($halaman == "lap_stok") { echo "active"; } ?>">
    <a href="lap_stok.php" class="nav-link">
        <i class="fas fa-fw fa-clipboard"></i>
        <span>Lap Stok Barang</span>
    </a>
    </li>
    <li class="nav-item <?php if ($halaman == "lap_penjualan") { echo "active"; } ?>">
    <a href="lap_penjualan.php" class="nav-link">
        <i class="fas fa-fw fa-clipboard"></i>
        <span>Laporan Penjualan</span>
    </a>
    </li>
    <?php } ?>
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
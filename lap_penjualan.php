<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
$halaman = "lap_penjualan";
$getdata = mysqli_query($conn, 
    "SELECT * FROM produk p, transaksi t, detail_transaksi dt WHERE p.id_produk=dt.id_produk AND dt.id_transaksi=t.id_transaksi ORDER BY tanggal DESC"
    );
// total pendapatan hari ini dan bulan ini
$total_hari_ini = 0;
$total_bulan_ini = 0;

while ($item = mysqli_fetch_array($getdata)) {
    $tanggal = $item['tanggal'];
    $jumlah = $item['jumlah'];
    $harga = $item['harga'];
    $subtotal = $jumlah * $harga;

    // Menghitung total pendapatan per hari
    $hari = date('Y-m-d', strtotime($tanggal));
    if ($hari == date('Y-m-d')) { // Jika tanggal sama dengan hari ini
        $total_hari_ini += $subtotal;
    }

    // Menghitung total pendapatan per bulan
    $bulan = date('Y-m', strtotime($tanggal));
    if ($bulan == date('Y-m')) { // Jika bulan sama dengan bulan ini
        $total_bulan_ini += $subtotal;
    }
}
//menampilkan tanggal laporan yg diplih
$selected_date = "";
if (isset($_POST['search'])) {
    $selected_date = $_POST['start_date'];
}
//menampilkan bulan thn laporan yg diplih
$selected_month = "";
$selected_year = "";
if (isset($_POST['search_month'])) {
    $selected_month = $_POST['bln'];
    $selected_year = $_POST['thn'];
}

//export excel


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Laporan Penjualan</title>
    <?php require_once('layout/_css.php'); ?>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once('layout/sidebar.php'); ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php require_once('layout/topbar.php'); ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
                    </div>
                    <div class="card shadow mb-4">
                        <!-- Menampilkan total pendapatan hari ini dan bulan ini -->
                        <div class="row card-body">
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-l font-weight-bold text-primary text-uppercase mb-1">
                                                Pendapatan Hari Ini:</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-700">Rp. <?= number_format($total_hari_ini); ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-l font-weight-bold text-primary text-uppercase mb-1">
                                                Pendapatan Bulan Ini:</div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-700">Rp. <?= number_format($total_bulan_ini); ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div class="row mr-1 ml-1">
                            <div class="card-body">
                                <div class="row border-bottom-secondary">
                                    <div class="col-4">
                                        <div class="text-l font-bold text-primary text-uppercase mb-1">
                                            Cari Laporan  <span class="text-danger">*</span>/Hari:
                                        </div>
                                        <form action="" method="post">
                                            <div class="form-row align-items-center">
                                                <div class="input-group">
                                                    <input type="date" value="<?= $selected_date; ?>" class="form-control border-left-primary mt-2 mb-2" id="start_date" name="start_date">
                                                    <div class="input-group-append">
                                                        <button type="submit" name="search" class="btn btn-primary mb-2 mt-2"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-5">
                                        <div class="text-l font-bold text-primary text-uppercase mb-1">
                                            Cari Laporan  <span class="text-danger">*</span>/Bulan:
                                        </div>
                                        <form action="" method="post">
                                            <div class="form-row align-items-center">
                                                <div class="col-auto">
                                                    <select name="bln" value="" class="form-control border-left-warning">
                                                        <option selected="selected" disabled>Pilih bulan</option>
                                                        <option value="01">Januari</option>
                                                        <option value="02">Februari</option>
                                                        <option value="03">Maret</option>
                                                        <option value="04">April</option>
                                                        <option value="05">Mei</option>
                                                        <option value="06">Juni</option>
                                                        <option value="07">Juli</option>
                                                        <option value="08">Agustus</option>
                                                        <option value="09">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                                <div class="col-auto">
                                                    <input type="number" value="<?= $selected_year; ?>" class="form-control border-left-warning mb-2 mt-2" placeholder="Pilih tahun" name="thn" required>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" name="search_month" class="btn btn-warning mb-2 mt-2"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-3">
                                        <div class="text-l font-bold text-primary text-uppercase mb-1">
                                            Aksi
                                        </div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <a href="lap_penjualan.php" class="btn btn-info mt-2 mb-2">Semua Data</a>
                                            </div>
                                            <div class="col-auto">
                                            <form action="" method="post">
                                                <button type="submit" id="printButton" class="btn btn-success mt-2 mb-2"><i class="fa fa-download"></i>Print</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>

                                <?php
                                    // Menampilkan tabel laporan
                                    // Form pencarian tanggal
                                    if (isset($_POST['search'])) {
                                        $selected_date = $_POST['start_date'];
                                        $selected_date_formatted = date('Y-m-d', strtotime($selected_date));
                                        $query_condition = "DATE(tanggal) = '$selected_date_formatted'";
                                    } elseif(isset($_POST['search_month'])){
                                        $selected_month = $_POST['bln'];
                                        $selected_year = $_POST['thn'];
                                        $query_condition = "MONTH(tanggal) = '$selected_month' AND YEAR(tanggal) = '$selected_year'";
                                    } else {
                                        // Jika bulan dan tahun tidak dipilih, tanpa kondisi bulan
                                        $query_condition = "1"; // Selalu benar, sehingga akan mengambil semua data
                                    }
                                    

                                    // Query untuk mengambil data
                                    $query = "SELECT * FROM produk p, transaksi t, detail_transaksi dt
                                    WHERE p.id_produk = dt.id_produk
                                    AND dt.id_transaksi = t.id_transaksi
                                    AND $query_condition
                                    ORDER BY tanggal DESC";
                                    $getitem = mysqli_query($conn, $query);                                    
                                ?>
                                <div class="table-responsive" id="printSection">
                                    <center>
                                        <h5>Laporan Penjualan Bagas Cell</h5> Jl. Merdeka No 45, Surakarta, Jawa Tengah
                                    </center><br>
                                    <table class="table table-bordered"  width="100%" cellspacing="0">
                                        <thead>
        
                                            <tr>
                                                <th>#</th>
                                                <th>Id Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Customer</th>
                                                <th>Nama Produk</th>
                                                <th>Qty</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php if (mysqli_num_rows($getitem) > 0) { ?>
                                            <?php } else {
                                                echo "
                                                <tr>
                                                    <td class='table-secondary text-center' colspan='7'>Tidak ada data !</td>
                                                </tr>";
                                            } ?>

                                            <?php $no = 0 ?>
                                            <?php while ($item = mysqli_fetch_array($getitem)) { ?>
                                            <?php
                                                $id_produk = $item['id_produk'];
                                                $id_transaksi = $item['id_transaksi'];
                                                $tanggal = $item['tanggal'];
                                                $nama_produk = $item['nama_produk'];
                                                $jumlah = $item['jumlah'];
                                                $harga = $item['harga'];
                                                $subtotal = $jumlah * $harga;
                                                $customer = $item['customer'];
                                                $deskripsi = $item['deskripsi'];
                                            ?>
                                            <?php $no++ ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $id_transaksi ?></td>
                                                    <td><?= $tanggal ?></td>
                                                    <td><?= $customer ?></td>
                                                    <td><?= $nama_produk ?>-<?= $deskripsi ?></td>
                                                    <td><?= $jumlah ?></td>
                                                    <td>Rp. <?= number_format($subtotal) ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                </div>
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class copyright text-center my-auto>
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script>
        document.getElementById("printButton").addEventListener("click", function() {
        var printContents = document.getElementById("printSection").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
        });
    </script>
    <?php require_once('layout/_js.php'); ?>
</body>
</html>

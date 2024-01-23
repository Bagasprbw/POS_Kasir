<?php
    session_start();
    require_once('koneksi.php');
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $halaman = "index";
    $record_jual=mysqli_query($conn, "SELECT id_produk FROM detail_transaksi");
    $output_record_jual=mysqli_num_rows($record_jual);

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home</title>
    <?php require_once('layout/_css.php'); ?>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php require_once('layout/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require_once('layout/topbar.php'); ?>
                <div class="container-fluid">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Welcome to website Bagas Cell</strong>  Mr. <?= $_SESSION['username']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-l font-weight-bold text-primary text-uppercase mb-1">
                                            Produk Terjual :</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-700"><?=  $output_record_jual ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-l font-weight-bold text-primary text-uppercase mb-1">
                                                Pendapatan Hari Ini:
                                            </div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-700">
                                                <span id="totalHariIni">Rp. <?= number_format($total_hari_ini); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-l font-weight-bold text-primary text-uppercase mb-1">
                                            Pendapatan Bulan Ini:</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-700">
                                                <span id="totalHariIni">Rp. <?= number_format($total_bulan_ini); ?></span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; bagasprbw 2021</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
<?php require_once('layout/_js.php'); ?>
</body>

</html>
<?php
    session_start();
    require_once('koneksi.php');
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $halaman = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Data barang</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Log Harga Produk</h1>
                    </div>
                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Perubahan Harga Produk</h6><hr>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Id Produk</th>
                                            <th>Produk</th>
                                            <th>Harga Lama</th>
                                            <th>Harga Baru</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <?php $no = 0 ?>
                                    <?php
                                        $getdata = mysqli_query($conn, "SELECT * FROM log_harga_produk, produk WHERE log_harga_produk.id_produk = produk.id_produk ORDER BY waktu DESC");
                                        while ($item = mysqli_fetch_array($getdata)) {
                                            $id_log = $item['id_log'];
                                            $id_produk = $item['id_produk'];
                                            $nama_produk= $item['nama_produk'];
                                            $harga_lama = $item['harga_lama'];
                                            $harga_baru = $item['harga_baru'];
                                            $waktu = $item['waktu'];
                                        ?>
                                    <?php $no++ ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $id_produk ?></td>
                                            <td><?= $nama_produk ?></td>
                                            <td>Rp. <?= number_format($harga_lama); ?></td>
                                            <td>Rp. <?= number_format($harga_baru); ?></td>
                                            <td><?= $waktu ?></td>
                                        </tr>
                                    </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
<?php require_once('layout/_js.php'); ?>
</body>
</html>
<?php
    session_start();
    require_once('koneksi.php');
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
    }
    $halaman = "lap_stok";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Laporan Stok</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Laporan Stok Barang</h1>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Persediaan</li>
                            <li class="breadcrumb-item" aria-current="page"><a href="#pengeluaran">Pengeluaran</a></li>
                        </ol>
                    </nav>
                    <div class="card shadow mb-4">
                        <div class="row mr-1 ml-1">
                            <div class="card-body" id="persediaan">
                                <button type="submit" id="printButton1" class="btn btn-success mt-2 mb-2"><i class="fa fa-download"></i>Print</button>
                                <div class="table-responsive" id="printSection1">
                                    <center>
                                        <h5>Laporan Persediaan Barang Bagas Cell</h5> Jl. Merdeka No 45, Surakarta, Jawa Tengah
                                    </center><br>
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama_produk</th>
                                                <th>Deskripsi</th>
                                                <th>Harga</th>
                                                <th>Stock Tersedia</th>
                                            </tr>
                                        </thead>
                                        <?php $no = 0 ?>
                                        <?php
                                            $getdata = mysqli_query($conn, "SELECT * FROM produk");
                                            while ($item = mysqli_fetch_array($getdata)) {
                                                $id_produk = $item['id_produk'];
                                                $nama_produk= $item['nama_produk'];
                                                $stock = $item['stock'];
                                                $harga = $item['harga'];
                                                $deskripsi = $item['deskripsi'];
                                            ?>
                                        <?php $no++ ?>
                                        <tbody>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $nama_produk ?></td>
                                                <td><?= $deskripsi ?></td>
                                                <td>Rp. <?= number_format($harga)?></td>
                                                <td><?= ($stock == 0) ? 'Stok Habis' : $stock; ?></td>
                                            </tr>
                                        </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ------------------------------------------------------------ -->
                    <div class="card shadow mb-4">
                        <div class="row mr-1 ml-1">
                            <div class="card-body" id="pengeluaran">
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
                                                <a href="lap_stok.php" class="btn btn-info mt-2 mb-2">Semua Data</a>
                                            </div>
                                            <div class="col-auto">
                                            <form action="" method="post">
                                                <button type="submit" id="printButton2" class="btn btn-success mt-2 mb-2"><i class="fa fa-download"></i>Print</button>
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
                                    $query = "SELECT p.id_produk, p.nama_produk, p.deskripsi, SUM(dt.jumlah) AS jumlah_terjual, SUM(dt.jumlah * p.harga) AS total_pembelian 
                                    FROM produk p
                                    LEFT JOIN detail_transaksi dt ON p.id_produk = dt.id_produk
                                    LEFT JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                                    WHERE $query_condition
                                    GROUP BY p.id_produk
                                    ORDER BY p.nama_produk";
                                    $getitem = mysqli_query($conn, $query);                                    
                        
                                ?>
                                <div class="table-responsive" id="printSection2">
                                    <center>
                                        <h5>Laporan Pengeluaran Stok Bagas Cell</h5> Jl. Merdeka No 45, Surakarta, Jawa Tengah
                                    </center><br>
                                    <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <?php
                                    if (isset($_POST['search'])) {
                                        echo $selected_date;
                                    } elseif (isset($_POST['search_month'])) {
                                        echo $selected_month . "-" . $selected_year;
                                    }
                                    ?>
                                        <thead>       
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Produk</th>
                                                <th>Deskripsi</th>
                                                <th>Terjual</th>
                                                <th>Total Pembelian</th>
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
                                                    $nama_produk = $item['nama_produk'];
                                                    $deskripsi = $item['deskripsi'];
                                                    $jumlah_terjual = $item['jumlah_terjual'];
                                                    $total_pembelian = $item['total_pembelian'];
                                                ?>
                                            <?php $no++ ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $nama_produk ?></td>
                                                <td><?= $deskripsi ?></td>
                                                <td><?= $jumlah_terjual ?></td>
                                                <td>Rp. <?= number_format($total_pembelian) ?></td>
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
                <!-- /.container-fluid -->
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
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script>
        document.getElementById("printButton1").addEventListener("click", function() {
        var printContents = document.getElementById("printSection1").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
        });
    </script>
    <script>
        document.getElementById("printButton2").addEventListener("click", function() {
        var printContents = document.getElementById("printSection2").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
        });
    </script>
    <?php require_once('layout/_js.php'); ?>
</body>
</html>

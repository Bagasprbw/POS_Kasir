<?php
    session_start();
    require_once('koneksi.php');
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $halaman = "transaksi";

    if(isset($_POST['mulai_transaksi'])){
        $customer = $_POST['customer'];
        $tanggal = date('Y/m/d');
        $query = "INSERT INTO transaksi VALUES ('','$tanggal','$customer')";
        
        if(mysqli_query($conn, $query)){
            $id_transaksi = mysqli_insert_id($conn);
            echo "<script> window.location.href= 'detail_transaksi.php?id_transaksi=" . $id_transaksi . "' </script>";
        } else{
            echo "Gagal";
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
    <title>Transaksi</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4" data-toggle="modal" data-target="#transaksi" style="cursor: pointer;">
                        <div class="card border-left-primary shadow h-100 py-2 mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-gray text-uppercase mb-1">
                                        Klik untuk memulai transaksi !</div>
                                        <div class="h6 mb-0 font-weight-bold text-primary">Mulai Transaksi >>></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
                            <div class="modal fade" id="transaksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Customer</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="post">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">atas nama :</label>
                                                    <input type="text" name="customer" class="form-control" id="recipient-name">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="mulai_transaksi" class="btn btn-primary">submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Id_transaksi</th>
                                            <th>tanggal</th>
                                            <th>Customer</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        $gettransaksi = mysqli_query($conn,
                                        "SELECT * FROM transaksi order by tanggal DESC"
                                    );
                                    $i=1;
                                    while ($p = mysqli_fetch_array($gettransaksi)) {
                                        $id_transaksi = $p['id_transaksi'];
                                        $tanggal = $p['tanggal'];
                                        $customer = $p['customer'];

                                        //hitung jumlah brg pesanan
                                        $hitungjumlah = mysqli_query($conn, "SELECT * FROM detail_transaksi WHERE id_transaksi='$id_transaksi'");
                                        if ($hitungjumlah) {
                                            $jumlah = mysqli_num_rows($hitungjumlah);
                                        } else {
                                            echo "Halahh Mbohh Mumett" . mysqli_error($conn);
                                        }
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $id_transaksi ?></td>
                                            <td><?= $tanggal ?></td>
                                            <td><?= $customer ?></td>
                                            <td><?= $jumlah ?></td>
                                            <td>
                                                <a onclick="return confirm('Apakah anda yakin??')" class="btn btn-danger" href="function.php?hapus_transaksi=<?= $p['id_transaksi'] ?>"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
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
<?php
    session_start();
    require_once('koneksi.php');
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
    }

    if(isset($_GET['id_transaksi'])) {
        $id_transaksi = $_GET['id_transaksi'];
        // Lakukan query atau manipulasi data sesuai kebutuhan Anda
        $query = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
            $customer = $data['customer'];
            $tanggal = $data['tanggal'];
        } else {
            echo "Transaksi tidak ditemukan.";
            // Ganti dengan tindakan yang sesuai jika transaksi tidak ditemukan
        }
    } else {
        echo "ID Transaksi tidak diberikan.";
        // Ganti dengan tindakan yang sesuai jika ID Transaksi tidak diberikan
    }
    // Inisialisasi variabel bayar dan kembalian dengan nilai awal 0
    $bayar = 0;
    $kembalian = 0;

    if (isset($_POST['bayar'])) {
        $bayar = $_POST['bayar'];
        $kembalian = $_POST['kembalian'];
    }
    
    // Menyimpan nilai bayar dan kembalian ke dalam sesi
    $_SESSION['bayar'] = $bayar;
    $_SESSION['kembalian'] = $kembalian;

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
    <div id="wrapper">
        <?php require_once('layout/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require_once('layout/topbar.php'); ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Kasir Transaksi</h1>
                    </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h6 mb-0 font-weight text-gray-650" id="cs">Customer : <?= $customer; ?></div>
                                            <div class="h6 mb-0 font-weight text-gray-650" id="cs">Tanggal : <?= $tanggal; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a type="button" href="transaksi.php" class="btn btn-danger"  data-whatever="@mdo"></i>Keluar</a><hr>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Masukan Produk</button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Masukan Produk</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="function.php" method="post">
                                                <div class="modal-body">
                                                    <!-- inpputttttt -->
                                                    <label class="col-form-label" for="val-email">Pilih Produk :</label>
                                                    <select name="id_produk" class="form-control">
                                                        <?php
                                                            $getproduk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk");
                                                            while ($plh_produk = mysqli_fetch_array($getproduk)) {
                                                                $id_produk = $plh_produk['id_produk'];
                                                                $nama_produk= $plh_produk['nama_produk'];
                                                                $stock = $plh_produk['stock'];
                                                                $deskripsi = $plh_produk['deskripsi'];
                                                        ?>
                                                        <option value="<?= $id_produk; ?>">
                                                            <?= $nama_produk; ?> - <?= $deskripsi; ?> ( stok: <?= $stock; ?> ) 
                                                        </option>   
                                                        <?php } ?>
                                                    <input type="number" class="form-control mt-3" name="jumlah" placeholder="Quantity" min="1">
                                                    <input type="hidden" class="form-control mt-3" name="id_transaksi" value="<?=$id_transaksi;?>">
                                                    <!-- inpputttttt end -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="add_produk_pesanan">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama_produk</th>
                                            <th>id_produk</th>
                                            <th>harga satuan</th>
                                            <th>jumlah</th>
                                            <th>subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 0 ?>
                                    <?php
                                        $totalharga = 0;
                                        $gettransaksi = mysqli_query($conn,
                                            "SELECT * FROM detail_transaksi item_dt, produk item_p WHERE item_dt.id_produk=item_p.id_produk AND id_transaksi='$id_transaksi'"
                                        );
                                        while ($itemprdk = mysqli_fetch_array($gettransaksi)) {
                                            $id_detail_transaksi = $itemprdk['id_detail_transaksi'];
                                            $id_produk = $itemprdk['id_produk'];
                                            $id_transaksi = $itemprdk['id_transaksi'];
                                            $deskripsi = $itemprdk['deskripsi'];
                                            $jumlah = $itemprdk['jumlah'];
                                            $harga = $itemprdk['harga'];
                                            $nama_produk = $itemprdk['nama_produk'];
                                            $subtotal = $jumlah * $harga;
                                            $totalharga += $subtotal;
                                        ?>
                                    <?php $no++ ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $nama_produk ?> - <?= $deskripsi ?></td>
                                            <td><?= $id_produk ?></td>
                                            <td><?= number_format($harga) ?></td>
                                            <td><?= $jumlah ?></td>
                                            <td>Rp.<?= number_format($subtotal) ?></td>
                                            <td>
                                                <!-- hapus -->
                                                <a onclick="return confirm('Apakah anda yakin??')" class="btn btn-danger" href="function.php?produk_batal=<?= $itemprdk['id_detail_transaksi'] ?>"><i class="fa fa-trash"></i></a>
                                                <!-- edit -->
                                                <a class="btn btn-warning"  href="#" data-toggle="modal" data-target="#modaleditqty<?= $id_detail_transaksi ?>">Edit Qty</a>
                                                <!-- Modal Edit Quantity -->
                                                <div class="modal fade" id="modaleditqty<?= $id_detail_transaksi ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Quantity</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="function.php" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id_detail_transaksi" value="<?= $id_detail_transaksi ?>">
                                                                    <div class="form-group">
                                                                        <label for="jmlh_baru" style="color: black;">Quantity Baru</label>
                                                                        <input type="number" class="form-control" id="jumlah_baru" name="jumlah_baru" value="<?= $jumlah ?>" min="1">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary" name="edit_jumlah">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <!----Pembayaran--->
                                <form class="row g-3" action="" method="post">
                                    <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Total Harga</label>
                                        <input type="text" name="totalharga" class="form-control" id="inputEmail4" value="<?= number_format($totalharga, 0, ',', '.') ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Bayar</label>
                                        <input type="number" class="form-control" name="bayar" id="inputPassword4">
                                    </div>
                                    <?php
                                         //hitung kembalian
                                        if (isset($_POST['hitung_bayar'])) {
                                            $bayar = $_POST['bayar'];
                                            $kembalian = $bayar - $totalharga;
                                            $_SESSION['kembalian'] = $kembalian;
                                            if ($bayar < $totalharga) {
                                                echo "<script> alert('Uang Kurang! Tolong masukkan uang yang cukup'); </script>";
                                                echo "<script> window.location.href = document.referrer; </script>";
                                                exit;
                                            } else {
                                                echo "<script> alert('Pembayaran berhasil!'); </script>";
                                            }
                                        }
                                    ?>
                                    <div class="col-md-8 mb-3 mt-4">
                                        <label for="inputCity" class="form-label">Kembalian</label>
                                        <input type="text" class="form-control" name="kembalian" id="inputCity" value="<?= number_format($kembalian, 0, ',', '.') ?>" readonly>
                                    </div>
                                    <div class="col-md-1 mt-5">
                                        <button type="submit" name="hitung_bayar" class="btn btn-primary">Submit</button>
                                    </div>
                                    <div class="col-md-3 mt-5">
                                        <a href="nota.php?id_transaksi=<?= $id_transaksi ?>" class="btn btn-success">Cetak Nota</a>
                                    </div>                                    
                                </form>
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
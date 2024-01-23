<?php
    session_start();
    require_once('koneksi.php');
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    $halaman = "barang";
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
                        <h1 class="h3 mb-0 text-gray-800">Produk</h1>
                    </div>
                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6><hr>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Tambah Produk</button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStockModal">Tambah Stok</button>
                            <a class="btn btn-warning" href="logHrg_produk.php">Riwayat</a>

                            <div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addStockModalLabel">Tambah Stok Barang</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="function_produk.php" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="productSelect">Pilih Produk:</label>
                                                    <select class="form-control" id="productSelect" name="id_produk">
                                                        <?php
                                                        $getProducts = mysqli_query($conn, "SELECT id_produk, nama_produk FROM produk");
                                                        while ($product = mysqli_fetch_array($getProducts)) {
                                                            echo "<option value='" . $product['id_produk'] . "'>" . $product['nama_produk'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="stockInput">Jumlah Stok:</label>
                                                    <input type="number" class="form-control" id="stockInput" name="stokmasuk">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" name="tambah_stock" class="btn btn-success">Tambah Stok</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Input Produk</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="function_produk.php" method="post">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nama Produk:</label>
                                                    <input type="text" class="form-control" name="nama_produk" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Deskripsi:</label>
                                                    <input type="text" class="form-control" name="deskripsi" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Stock:</label>
                                                    <input type="number" class="form-control" name="stock" id="recipient-name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Harga:</label>
                                                    <input type="number" class="form-control" name="harga" id="recipient-name">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="add_produk" class="btn btn-primary">submit</button>
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
                                            <th>Nama_produk</th>
                                            <th>Deskripsi</th>
                                            <th>Stock</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
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
                                            <td><?= ($stock == 0) ? 'Stok Habis' : $stock; ?></td>
                                            <td>Rp. <?= number_format($harga)?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" onclick="return confirm('Apakah anda yakin??')" href="function_produk.php?hapus=<?= $id_produk ?>">Hapus</a>
                                                <a class="btn btn-primary btn-sm"  href="#" data-toggle="modal" data-target="#modaleditprdk<?= $id_produk ?>">Edit</a>
                                                <!---modal----------->
                                                <div class="modal fade" id="modaleditprdk<?= $id_produk ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="function_produk.php" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
                                                                    <div class="form-group">
                                                                        <label for="a" style="color: black;">Nama Produk</label>
                                                                        <input type="text" class="form-control" id="a" name="nama_produk" value="<?= $nama_produk ?>" min="1">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="b" style="color: black;">Deskripsi</label>
                                                                        <input type="text" class="form-control" id="b" name="deskripsi" value="<?= $deskripsi ?>" min="1">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="c" style="color: black;">Stock</label>
                                                                        <input type="number" class="form-control" id="c" name="stock" value="<?= $stock ?>" min="1">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="d" style="color: black;">Harga</label>
                                                                        <input type="number" class="form-control" id="d" name="harga" value="<?= $harga ?>" min="1">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary" name="edit_produk">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
<?php require_once('layout/_js.php'); ?>
</body>
</html>
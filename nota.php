<?php
    session_start();
    require_once('koneksi.php');
    if(!isset($_SESSION['username'])){
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Nota Transaksi</title>
    <style>
        
        td {
            color: black;
        }
        p {
            color: black;
        }
        .store-header {
            color: #fff;
            padding: 20px;
            display: flex;
            align-items: center;
        }
        .store-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
            }

            .floating-button button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        @media print {
            .floating-button {
                display: none;
            }
        }

    </style>
    <?php require_once('layout/_css.php'); ?>
</head>
<body>
    <div class="floating-button">
        <button id="printNota" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Cetak</button>
        <a href="detail_transaksi.php?id_transaksi=<?= $id_transaksi ?>" class="btn btn-primary">Kembali</a>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="store-header bg-light">
                    <img src="layout/toko.png" alt="Foto Profil Toko" class="store-logo">
                    <div class="text-dark">
                        <h2>Bagas Cell</h2>
                        <p class="text-secondary">Jl. Merdeka No 45, Surakarta, Jawa Tengah</p>
                    </div>
                </div>
                <h4 class="mt-4 text-dark">Detail Pembelian</h4>
                <p>Tanggal: <?= $tanggal; ?></p>
                <!-- Tambahkan detail pembelian di sini -->
                <table class="table">
                    <thead>
                        <tr id="tblhead">
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>@</th>
                            <th>Qty</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <?php
                        $totalharga = 0;
                        $gettransaksi = mysqli_query($conn,
                        "SELECT * FROM detail_transaksi item_dt, produk item_p WHERE item_dt.id_produk=item_p.id_produk AND id_transaksi='$id_transaksi'"
                    );
                    $i=1;
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
                    <tbody>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $nama_produk ?> - <?= $deskripsi ?></td>
                            <td>Rp.<?= number_format($harga) ?></td>
                            <td><?= $jumlah ?></td>
                            <td>Rp.<?= number_format($subtotal) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right">Total :</td>
                            <td>Rp.<?=number_format($totalharga)?></td>
                        </tr>
                    </tbody>
                </table>
                <p>Bayar: Rp. <?= number_format($_SESSION['bayar'], 0, ',', '.')?></p>
                <p>Kembalian : Rp. <?= number_format($_SESSION['kembalian'], 0, ',', '.') ?></p>
                <p>Customer : <?= $customer; ?></p>
            </div>
        </div>
        <center>
            <h4 class="text-center text-dark mt-4">Terima Kasih atas pembelian anda</h4>
        </center>
    </div>
    <?php require_once('layout/_js.php'); ?>
    <script>
        document.getElementById('printNota').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>

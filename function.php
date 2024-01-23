<?php
session_start();
  // hapus transaksi
include "koneksi.php";
if (isset($_GET['hapus_transaksi'])) {
    $id_transaksi = $_GET['hapus_transaksi'];

    // Hapus data transaksi dari tabel 
    $query_transaksi = "DELETE FROM transaksi WHERE id_transaksi='$id_transaksi'";
    mysqli_query($conn, $query_transaksi);

    // Hapus data barang transaksi dari tabel detail_transaksi
    $query_dtl_transaksi = "DELETE FROM detail_transaksi WHERE id_transaksi='$id_transaksi'";
    mysqli_query($conn, $query_dtl_transaksi);

    echo "<script> alert('Sukses berhasil dihapus'); </script>";
    echo "<script> window.location.href= 'transaksi.php' </script>";
} else {
    echo "Gagal menghapus";
}
//detailtransakksi

//insert barang pesanan
include "koneksi.php";
if(isset($_POST['add_produk_pesanan'])){
    $id_transaksi= $_POST['id_transaksi'];
    $id_produk= $_POST['id_produk'];
    $jumlah= $_POST['jumlah'];
    //hitung stok sekarang
    $hitung1=mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $hitung2=mysqli_fetch_array($hitung1);
    $stoksekarang=$hitung2['stock'];

    if($stoksekarang >= $jumlah) {
        // pengurangan stok
        $selisih = $stoksekarang - $jumlah;
        // stok cukup
        $query_insert = "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah) VALUES ( '$id_transaksi','$id_produk', '$jumlah')";
        // update pengurangan stok
        $query_update = "UPDATE produk SET stock='$selisih' WHERE id_produk='$id_produk'";
    
        // Eksekusi query insert dan update
        $insert_result = mysqli_query($conn, $query_insert);
        $update_result = mysqli_query($conn, $query_update);
    
        if($insert_result && $update_result){
            echo "<script> window.location.href = document.referrer; </script>";
        } else {
            echo "<script> alert('Proses Tambah Barang gagal'); </script>";
            // Tidak perlu mengarahkan ulang jika proses gagal
        }
        
    } else {
        // stok tidak cukup
        echo "<script> alert('Stock tidak mencukupi'); window.location.href='detail_transaksi.php?id_transaksi=$id_transaksi';</script>";

    }
}

//hapus barang pesanan
include "koneksi.php";
if (isset($_GET['produk_batal'])) {
    $id_detail_transaksi = $_GET['produk_batal'];

    $query_barang = "SELECT id_produk, jumlah FROM detail_transaksi WHERE id_detail_transaksi='$id_detail_transaksi'";
    $result_barang = mysqli_query($conn, $query_barang);
    $barang = mysqli_fetch_assoc($result_barang);

    $id_produk = $barang['id_produk'];
    $jumlah = $barang['jumlah'];

    $query_hapus = "DELETE FROM detail_transaksi WHERE id_detail_transaksi='$id_detail_transaksi' ";
    if (mysqli_query($conn, $query_hapus)) {
        // Mengembalikan stok barang yang dihapus
        $query_update = "UPDATE produk SET stock = stock + '$jumlah' WHERE id_produk='$id_produk'";
        if (mysqli_query($conn, $query_update)) {
            echo "<script> alert('Berhasil Dihapus'); </script>";
            echo "<script> window.location.href = document.referrer; </script>";
            exit;
        } else {
            echo "Gagal mengembalikan stok";
        }
    } else {
        echo "Gagal menghapus";
    }
}
//edit qty
if (isset($_POST['edit_jumlah'])) {
    $id_detail_transaksi = $_POST['id_detail_transaksi'];
    $jumlah_baru = $_POST['jumlah_baru'];

    $query_pesanan = "SELECT * FROM detail_transaksi WHERE id_detail_transaksi='$id_detail_transaksi'";
    $result_pesanan = mysqli_query($conn, $query_pesanan);
    $row_pesanan = mysqli_fetch_assoc($result_pesanan);
    $jumlah_lama = $row_pesanan['jumlah'];
    $id_produk = $row_pesanan['id_produk'];

    // Mengembalikan stok barang sebelunya
    $query_update_stok = "UPDATE produk SET stock = stock + '$jumlah_lama' WHERE id_produk = '$id_produk'";
    mysqli_query($conn, $query_update_stok);

    // Mengurangi stok barang baru
    $query_update_qty = "UPDATE detail_transaksi SET jumlah='$jumlah_baru' WHERE id_detail_transaksi='$id_detail_transaksi'";
    if (mysqli_query($conn, $query_update_qty)) {
        // Mengupdate stok barang baru
        $query_update_stok = "UPDATE produk SET stock = stock - '$jumlah_baru' WHERE id_produk = '$id_produk'";
        mysqli_query($conn, $query_update_stok);
        echo "<script> window.location.href = document.referrer; </script>";
        exit;
    } else {
        echo "Gagal mengubah quantity";
    }
}
?>
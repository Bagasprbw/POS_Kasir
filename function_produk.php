<?php
session_start();
// tambah produk
include "koneksi.php";
if(isset($_POST['add_produk'])){
    $deskripsi= $_POST['deskripsi'];
    $nama_produk = $_POST['nama_produk'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];
    $query = "INSERT INTO produk (deskripsi, nama_produk, stock, harga) VALUES ('$deskripsi', '$nama_produk', '$stock', '$harga')";
    if(mysqli_query($conn, $query)){
        echo "<script> alert('Barang Berhasil Ditambahkan'); </script>";
        echo "<script> window.location.href= 'produk.php' </script>";
    } else{
        echo "Gagal menambah barang";
    }
}
// hapus produk
include "koneksi.php";
if (isset($_GET['hapus'])) {
    $id_produk = $_GET['hapus'];
    $query = "DELETE FROM produk where id_produk='$id_produk' ";
    if(mysqli_query($conn, $query)){
        echo "<script> alert('Barang Berhasil Dihapus'); </script>";
        echo "<script> window.location.href= 'produk.php' </script>";
    } else{
        echo "Gagal menghapus barang";
    }
}
//edit produk
include "koneksi.php";
if(isset($_POST['edit_produk'])){
    $id_produk = $_POST['id_produk'];
    $deskripsi = $_POST['deskripsi'];
    $nama_produk = $_POST['nama_produk'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];
    $query = "UPDATE produk SET deskripsi ='$deskripsi',nama_produk = '$nama_produk',stock = '$stock',harga = '$harga'
    WHERE id_produk = '$id_produk'";
    if(mysqli_query($conn, $query)){
        echo "<script> alert('Produk Berhasil Diedit'); </script>";
        echo "<script> window.location.href= 'produk.php' </script>";
    } else{
        echo "Gagal mengedit produk";
    }
}
//penambahan stok
if (isset($_POST['tambah_stock'])) {
    $id_produk = $_POST['id_produk'];
    $stokmasuk = $_POST['stokmasuk'];
    $query = "SELECT stock FROM produk WHERE id_produk = $id_produk";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $stockLama = $row['stock'];
        $stockbaru = $stockLama + $stokmasuk;
        $updateQuery = "UPDATE produk SET stock = $stockbaru WHERE id_produk = $id_produk";
        if (mysqli_query($conn, $updateQuery)) {
            echo "<script> alert('stock Berhasil ditambah'); </script>";
            echo "<script> window.location.href= 'produk.php' </script>";
        } else {
            echo "<script> alert('Barang Berhasil Diedit'); </script>";
        }
    } else {
        echo "Product not found.";
    }
}
?>
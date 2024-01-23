<?php
session_start(); // Memulai atau melanjutkan sesi yang ada
include "koneksi.php"; // Memasukkan file koneksi.php untuk menghubungkan ke database
if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    $query = "SELECT * FROM user WHERE username='$username'";
    $hasil = mysqli_query($conn, $query);
    if (mysqli_num_rows($hasil) === 1) {
        $result = mysqli_fetch_assoc($hasil);
        if ($password == $result['password']) {
            $_SESSION['username'] = $result['username'];
            $_SESSION['level'] = $result['level']; // Simpan level pengguna dalam sesi

            if ($result['level'] == 'admin') {
                header('Location: index.php');
            } elseif ($result['level'] == 'pemilik') {
                header('Location: index.php');
            } else {
                echo "<script> alert('Role tidak valid'); </script>";
                echo "<script> window.location.href= 'login.php'; </script>";
            }
        } else {
            echo "<script> alert('Password Salah'); </script>";
            echo "<script> window.location.href= 'login.php'; </script>";
        }
    } else {
        echo "<script> alert('Username tidak ditemukan'); </script>";
        echo "<script> window.location.href= 'login.php'; </script>";
    }
}
?>

<?php
    $namahost="127.0.0.1";
    $user="root";
    $password="";
    $database="kasir_toko";
    $conn=mysqli_connect('localhost','root','','kasir_toko');
    if(!$conn) {
        echo "Database Error";
    }
?>
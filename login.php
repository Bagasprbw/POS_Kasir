<?php
    include "koneksi.php";
   session_start();
   if(isset($_SESSION['username'])){
      header("Location: index.php");
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
    <title>Login</title>
    <?php require_once('layout/_css.php'); ?>
    <style>
        .card {
            border-radius: 50px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 border-bottom-primary shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <div class="col-lg-9">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h3 class="text-l font-weight-bold text-primary text-uppercase">Aplikasi Kasir</h3>
                                        <h3 class="text-l font-weight-bold text-primary text-uppercase mb-1">Bagas Cell</h3><br><br>
                                    </div>
                                    <form class="user" action="function_login.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                            id="exampleInputEmail" name="username" aria-describedby="emailHelp" placeholder="Enter username Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="login" class="btn btn-primary mt-3">Log in</button>
                                        </div>
                                    </form><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once('layout/_js.php'); ?>
</body>
</html>
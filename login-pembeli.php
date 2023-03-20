<?php 
require 'functions.php';

session_start();
if(!empty($_SESSION['msg1'])) {
   echo "<script>
            alert('Akun pembeli baru berhasil ditambahkan');
        </script>";
} else {
  $_SESSION['email'] = '';
  $_SESSION['pass'] = '';
}

if(isset($_POST["login"])) {
  login($_POST, "pembeli");
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaggotHub</title>
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">

    <!--Stylesheet-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="./assets/images/logo.png" type="image/x-icon">
    <!-- MDB -->
    <link rel="stylesheet" href="./assets/css/mdb/mdb.min.css?v=<?= time(); ?>" />

    <link rel="stylesheet" href="./assets/css/style.css?v=<?= time(); ?>">
</head>
<body>

  <div class="register-content" style="padding-right: 10em;">
    <div class="register-form col-md-6 mt-5">
    <p class="back2home">&#8249; <a href="index.php">Beranda</a>

      <div class="register">
        <div class="title mt-5" style="text-align: justify;">
          <h2>SELAMAT DATANG DI MAGGOTHUB</h2>
          <h3>Temukan aneka produk olahan Maggot BSF dengan mudah</h3>
      </div>
      <div class="register mt-4">
      
      <form action="" method="post">
        <div class="form-group form-outline flex-fill mb-3">
          <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['email'] ?>" required>
          <label class="form-label required" for="email">Email</label>
        </div>

        <div class="form-group form-outline flex-fill mb-3">
          <input type="password" class="form-control" id="password" name="password" value="<?= $_SESSION['pass']; ?>"/>
          <label class="form-label required" for="password">Password</label>
        </div>
        
        <div class="btn-register">
          <button type="submit" name="login" class="btn btn-login mt-3">Masuk</button>
        </div>
      </form>
          <div class="akun ml-0 mt-3">
            <p>Belum memiliki akun? <a href="register-pembeli.php">Daftar</a> di sini</p>
          </div>
      </div>
      </div>
    </div>

    <div class="register-ilus" style="height: 60%;">
      <img src="assets/images/login.svg" alt="" class="login animated">
    </div>
  </div>

  <?php  
  $_SESSION = [];
  session_unset();
  session_destroy();
  ?>

  <script src="assets/script/main.js?v=<?= time(); ?>"></script>
  <!--===== SCROLL REVEAL =====-->
  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <!-- MDB -->
  <script type="text/javascript" src="assets/script/mdb.min.js?v=<?= time(); ?>"></script>
</body>
</html>
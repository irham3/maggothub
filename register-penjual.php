<?php 
require 'functions.php';

if(isset($_POST["register"])){
  if(register($_POST, "penjual") > 0){
    session_start();
    $_SESSION['msg2'] = "Successful";
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['pass'] = $_POST['password1'];
    header("Location: login-penjual.php");
    exit;
  } else {
    mysqli_error($koneksi);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaggotHub</title>
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/logo.png" type="image/x-icon">
    
    <link rel="stylesheet" href="./assets/css/external/boxicon.min.css">
    <link rel="stylesheet" href="./assets/css/external/font-awesome.css"/>
    <link rel="stylesheet" href="./assets/css/external/bootsrap.min.css"/>
    <!-- MDB -->
    <link rel="stylesheet" href="./assets/css/mdb/mdb.min.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="./assets/css/style.css?v=<?= time(); ?>">
</head>
<body>

  <div class="register-content">
    <div class="register-form col-md-6">
    <p class="back2home">&#8249; <a href="index.php">Beranda</a>

      <div class="register">
        <div class="title">
          <h2>Daftar</h2>
          <h3>Sebagai Penjual</h3>
      </div>
      <div class="register mt-3">
          <form action="" method="post">
              <div class="form-group form-outline flex-fill mb-3">
                <input type="text" class="form-control" id="nama" name="nama" required>
                <label class="form-label required" for="nama">Nama Lengkap</label>
              </div>

              <div class="form-group form-outline flex-fill mb-3">
                <input type="email" class="form-control" id="email" name="email" required>
                <label class="form-label required" for="email">Email</label>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-outline">
                    <input type="password" class="form-control" id="password1" name="password1"/>
                    <label class="form-label required" for="password1">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-outline">
                    <input type="password" class="form-control" id="password2" name="password2" />
                    <label class="form-label required" for="password2">Ulangi Password</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-outline">
                    <input type="tel" class="form-control" id="no-wa" name="no-wa" 
                    onkeypress="return onlyNumberKey(event)" required>
                    <label class="form-label required" for="no-wa">Nomor Whatsapp</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-outline">
                    <input type="text" class="form-control" id="nama-toko" name="nama-toko" />
                    <label class="form-label required" for="nama-toko">Nama Toko</label>
                  </div>
                </div>
              </div>

              <div class="form-group form-outline flex-fill mb-3">
                <input type="text" class="form-control" id="alamat" name="alamat" required>
                <label class="form-label required" for="alamat">Alamat Toko</label>
              </div>
              
              <div class="form-group form-outline flex-fill mb-3">
                <input type="text" class="form-control" id="kota" name="kota" required>
                <label class="form-label required" for="kota">Kota/Kabupaten</label>
              </div>
              
              <div class="btn-register">
                <button type="submit" name="register" class="btn btn-login mt-2">Daftar</button>
              </div>
            </form>

          <div class="akun ml-0 mt-2">
            <p>Sudah memiliki akun? <a href="login-penjual.php">Masuk</a> disini</p>
          </div>
      </div>
      </div>
    </div>

    <div class="register-ilus">
      <img src="assets/images/register-penjual.svg" alt="" class="ml-5 animated">
    </div>
  </div>
  
  <!-- MDB -->
  <script type="text/javascript" src="assets/script/mdb.min.js?v=<?= time(); ?>"></script>

  <script src="assets/script/main.js?v=<?= time(); ?>"></script>
</body>
</html>


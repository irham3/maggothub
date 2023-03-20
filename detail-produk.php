<?php 
    require 'functions.php';
    session_start();

    // Tidak boleh masuk halaman ini sebagai penjual ataupun bypass via url
    $is_penjual = false;
    if(isset($_SESSION['id-penjual'])) {
        $is_penjual = true;
    }
    if(!isset($_GET["id-produk"]) || $is_penjual) {
        header("Location: produk.php");
        exit;
    }
    
    // Masuk halaman sebagai pembeli
    $is_pembeli = false;
    $_POST["id-produk"] = $_GET["id-produk"];
    $nama = "";
    $no_wa = "";
    $alamat = "";
    $status_pembeli = "nonuser";
    if(isset($_SESSION["id-pembeli"])) {
        $_POST["id-user-pembeli"] = $_SESSION["id"];
        $is_pembeli = true;
        $nama = $_SESSION["nama"];
        $no_wa = $_SESSION["no_wa"];
        $alamat = $_SESSION["alamat"];
        $status_pembeli = "user";
    }

    $product_id = $_GET["id-produk"];
    $product = get_rows_from("products WHERE id = $product_id")[0];

    // Harga produk
    $harga = $product["harga"];

    // Data penjual produk
    $id_penjual = $product["id_penjual"];
    $id_user_penjual = mysqli_fetch_row(mysqli_query($koneksi, 
    "SELECT id_users FROM penjual WHERE id = $id_penjual"))[0];

    // Data Toko penjual
    $nama_toko = mysqli_fetch_row(mysqli_query($koneksi, "SELECT nama_toko 
                FROM penjual WHERE id = $id_penjual"))[0];
    $kota_toko = mysqli_fetch_row(mysqli_query($koneksi, "SELECT kota 
                FROM alamat WHERE id_users = $id_user_penjual"))[0];

    // No Wa penjual
    $no_wa_penjual = mysqli_fetch_row(mysqli_query($koneksi, "SELECT no_wa 
                    FROM users WHERE id = $id_user_penjual"))[0];

    // Ketika User klik tombol "Pesan Sekarang" di form
    if(isset($_POST["pesan"])){
        if(pesan_produk($_POST,$status_pembeli) > 0){
            echo "<script>
              alert('Produk berhasil dipesan');
          </script>";
        } else {
            echo "<script>
              alert('Produk gagal dipesan');
          </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deskripsi Produk</title>
    <link rel="shortcut icon" href="./assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!--MDB-->
    <link rel="stylesheet" href="assets/css/mdb/mdb.min.css?v=<?= time(); ?>">

    <link rel="stylesheet" href="./assets/css/style.css?v=<?= time(); ?>">
</head>
<body>
    <!--Navbar-->
    <header>
        <nav class="nav bd-grid">  
            <img src="./assets/images/maggothub.svg" class="logo-maggothub" alt="">
            <div class="nav__logo">
                <h1><a href="index.php"><span>Maggot</span>Hub</a></h1>
            </div>
			<div class="nav__menu" id="nav-menu">
				<ul class="nav__list">
					<a href="index.php#home" class="nav__link"><li class="nav__item"><strong>Beranda</strong></li></a>
					<a href="produk.php" class="nav__link active"><li class="nav__item"><strong>Produk</strong></li></a>
					<a href="index.php#tentang-bsf" class="nav__link"><li class="nav__item"><strong>Tentang BSF</strong></li></a>
				</ul>
			</div>
            <?php if(isset($_SESSION["login"])): ?>
                <div class="nav__menu" id="nav-menu">
				<ul class="nav__list" style="display: flex;">
                    <div class="notif-dropdown">
                        <a class="nav_link dropbtn" href="#" onclick="showProfileMenu(); return false;">
                        <img class="nav__img" src="assets/images/ic-profil.png" alt="">
                        </a>
                        <div class="profile-menu dropdown-content">
                            <div class="profile-img">
                                <img src="assets/images/ic-profil.png">
                                <span><?= strtok($_SESSION["nama"], " "); ?></span>
                            </div>
                            <hr>
                            <a class="dropdown-item" href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');">Keluar</a> 
                        </div>
                    </div>
				</ul>
			</div>
            <?php endif; ?>
            <?php if(!isset($_SESSION["login"])): ?>
                <div class="nav__menu" id="nav-menu">
                </div>
            <?php endif; ?>
            <button class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
	</header>

    <!--Mobile Nav-->
    <div class="mobile-nav">
        <a href="index.php#home" class="nav__link"><strong>Beranda</strong></a>
		<a href="produk.php" class="nav__link"><strong>Produk</strong></a>
        <a href="index.php#tentang-bsf" class="nav__link"><strong>Tentang BSF</strong></a>
        <?php if(!isset($_SESSION["login"])): ?>
            <div class="nav__dropdown">
                <a href="#">
                    <strong>Masuk</strong>
                    <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                </a>
    
                <div class="nav__dropdown-collapse">
                    <div class="nav__dropdown-content">
                        <a href="login-penjual.php" class="nav__dropdown-item nav__link">Sebagai Penjual</a>
                        <a href="login-pembeli.php" class="nav__dropdown-item nav__link">Sebagai Pembeli</a>
                    </div>
                </div>
            </div>
            <div class="nav__dropdown">
                <a href="#">
                    <strong>Daftar</strong>
                    <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                </a>
    
                <div class="nav__dropdown-collapse">
                    <div class="nav__dropdown-content">
                        <a href="register-penjual.php" class="nav__dropdown-item nav__link">Sebagai Penjual</a>
                        <a href="register-pembeli.php" class="nav__dropdown-item nav__link">Sebagai Pembeli</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION["login"])): ?>
            <a href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');"><strong>Keluar</strong></a>
        <?php endif; ?>
    </div>

    <!--Produk-->
    <section class="container-detail informasi-produk d-inline-flex">
        <div class="d-inline-flex">
            <div class="anim-left">
                <img class="gambar" src="assets/images/produk/<?= $product["gambar"]; ?>" alt="Gambar Produk">
                <div style="margin-top: 10px;">
                    <h2 class="nama-toko"><?= $nama_toko ?></h2>
                    <div class="d-inline-flex lokasi-toko no-wrap">
                        <img src="assets/images/ic-location.svg" alt="">
                        <p><?= $kota_toko ?></p>
                    </div>
                </div>
            </div>
            <div class="deskripsi-image anim-left">
                <div>
                    <h2><?= $product["nama"]; ?></h2>
                </div>
                <div class="d-inline-flex row-desc">
                    <div class="d-inline-flex">
                        <img src="assets/images/ic-rating.svg">
                        <p>&nbsp;4.5</p>
                    </div>
                    <div class="d-inline-flex">
                        <b>Terjual</b>
                        <p>&nbsp;35</p>
                    </div>
                    <div class="d-inline-flex">
                        <b>Penilaian</b>
                        <p>&nbsp;20</p>
                    </div>
                </div>
                <div>
                    <h1 class="harga"><b><?= rupiah($harga);?></b></h1>
                </div>
            </div>
        </div>
        <div class="jumlah-produk anim-right">
            <div>
                <h2>Jumlah Produk</h2>
                <div class="form-group">
                    <label>Jumlah Barang</label> <br>
                    <input type="number" id="quantity" name="quantity" min="1" value="1"
                    oninput="multipleBy(this.value)" onkeypress="return onlyNumberKey(event)">
                </div>
                <div class="subtotal">
                    <label>Subtotal</label> <br>
                    <button><?= rupiah($harga);?></button>
                </div>
                <div class="button">
                    <a href="#form-pembelian"><button class="beli" data-mdb-toggle="modal" data-mdb-target="#formModal">Beli Sekarang</button> </a>
                    <a href="https://wa.me/<?= $no_wa_penjual ?>?text=Halo,%20apakah%20produk%20ini%20masih%20ada?" target="_blank"><button class="chat">Chat Penjual</button></a> <br>
                </div>
            </div>
        </div>
    </section>

    <!--Deskipsi-->
    <div class="container-detail deskripsi-produk anim-left">
        <hr>
        <h1>Deskripsi</h1>
        <pre><?= $product["deskripsi"] ?></pre>
    </div>

    <!-- Form Pembelian Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="d-flex justify-content-end me-3">
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <h5 class="modal-title" id="formModalLabel">Form Pembelian Produk</h5>
                <div class="modal-body">
                    <form action="" method="post" class="mb-2">
                        <div class="form-group form-outline flex-fill mb-2">
                            <input type="text" class="form-control" id="nama-pembeli"
                            name="nama-pembeli" required value="<?= $nama; ?>">
                            <label class="form-label required" for="nama-pembeli">Nama Lengkap</label>
                        </div>
                        <div class="form-group form-outline flex-fill mb-2">
                            <input type="tel" class="form-control" id="no-wa-pembeli"
                            name="no-wa-pembeli" required
                             value="<?= $no_wa; ?>">
                            <label class="form-label required" for="no-wa-pembeli">No Whatsapp</label>
                        </div>
                        <div class="form-group form-outline flex-fill mb-2">
                            <input type="text" class="form-control no-wrap" id="alamat-pembeli"
                            name="alamat-pembeli" required value="<?= $alamat; ?>">
                            <label class="form-label required" for="alamat-pembeli">Alamat</label>
                        </div>
                        <div class="form-group form-outline flex-fill mb-2">
                            <input type="text" class="form-control no-wrap" id="nama-produk" name="nama-produk" value="<?= $product["nama"]; ?>" disabled>
                            <label class="form-label required" for="nama-produk">Nama Produk</label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-outline">
                                    <input type="number" class="form-control" id="num1 jumlah-produk"
                                    name="jumlah-produk" min="1" value="1" required
                                    oninput="multipleBy(this.value)" onkeypress="return onlyNumberKey(event)">
                                    <label class="form-label required" for="jumlah-produk">Jumlah Barang</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-outline">
                                    <input type="tel" class="form-control" id="no-wa"
                                    name="no-wa" value="<?= rupiah($harga);?>" 
                                    disabled>
                                    <label class="form-label" for="no-wa">Harga Barang</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mb-2">
                            <p>Total Harga: <b id="price-total"><?= rupiah($harga);?></b></p>
                            <input type="hidden" name="total-harga" id="total-harga" value="<?= $harga ?>">
                        </div> 
                        <div class="form-outline">
                            <textarea class="form-control" id="catatan" name="catatan" rows="4"></textarea>
                            <label class="form-label" for="catatan">Catatan</label>
                        </div>
                            <button type="submit" name="pesan" class="btn btn-login">Pesan Sekarang</button>
                    </form>  
                </div>
            </div>
        </div>
    </div>
	
	<!--Footer-->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-desc">
                    <div class="logo-area">
                        <img src="assets/images/logo.png" alt="">
                        <span class="logo-name"> MaggotHub</span>
                    </div>
                    <div class="desc-area">
                        <p>Berkeinginan untuk menyebarluaskan produk - produk maggot BSF sekaligus memperluas pasar penjualan maggot BSF.</p>
                    </div>
                </div>
                <div class="footer-list">
                    <ul class="contacts-area">
                        <li class="list-name">Kontak Kami</li>    
                        <li><img src="assets/images/ic-telepon.svg" alt=""><a href="#">+621234567891</a></li>
                        <li><img src="assets/images/ic-email.svg" alt=""><a href="#">maggotHub@gmail.com</a></li>
                    </ul>
                    
                    <ul class="contacts-area">
                        <li class="list-name">Social Media</li>    
                        <li><img src="assets/images/ic-instagram.svg" alt=""><a href="#">maggot_Hub</a></li>
                        <li><img src="assets/images/ic-facebook.svg" alt=""><a href="#">maggot_Hub</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="footer-bottom">
                <div class="copyright">
                    <i class='bx bxs-copyright'></i>
                    <span>2022 Altruis Team</span>
                </div>
            </div>
        </div>
    </footer>
    <script>
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
        }

        function multipleBy(val) {
            let totalHarga = (<?= $harga ?> * val);
            document.getElementById("price-total").innerHTML = formatRupiah(totalHarga.toString(),"Rp ");
            document.getElementById("total-harga").value = totalHarga;
        }
    </script>
    <!--===== SCROLL REVEAL =====-->
    <script src="https://unpkg.com/scrollreveal"></script>
    
    <!--===== MDB JS =====-->
    <script type="text/javascript" src="assets/script/mdb.min.js?v=<?= time(); ?>"></script>

    <!--===== MAIN JS =====-->
    <script src="assets/script/main.js?v=<?= time(); ?>"></script>
</body>
</html>
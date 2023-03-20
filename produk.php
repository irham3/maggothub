<?php 
    session_start();
    require 'functions.php';
    $is_penjual = false;
    if(isset($_SESSION['id-penjual'])) {
        $is_penjual = true;
        $id_penjual = $_SESSION['id-penjual'];
        
        $products = get_rows_from("products WHERE id_penjual = $id_penjual");
        $notifs = get_notif($id_penjual);
    } else
        $products = get_rows_from("products");

    // Ketika tombol cari ditekan
    if(isset($_POST["cari"])) {
        $keyword = $_POST["keyword"];
        if(!$is_penjual)
            $products = get_rows_from("products WHERE nama LIKE '%$keyword%'");
        else
            $products = get_rows_from("products WHERE nama LIKE '%$keyword%' AND id_penjual = $id_penjual");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="shortcut icon" href="./assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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
					<a href="index.php" class="nav__link"><li class="nav__item"><strong>Beranda</strong></li></a>
					<a href="produk.php" class="nav__link active"><li class="nav__item"><strong>Produk</strong></li></a>
					<?php if(!$is_penjual): ?>
					    <a href="index.php#tentang-bsf" class="nav__link"><li class="nav__item"><strong>Tentang BSF</strong></li></a>
                    <?php endif; ?>
				</ul>
			</div>
            <?php if(isset($_SESSION["login"])): ?>
                <div class="nav__menu" id="nav-menu">
				<ul class="nav__list" style="display: flex;">
                    <?php if($is_penjual): ?>
                        <div class="notif-dropdown">
                            <a class="nav_link dropbtn" href="#" onclick="showDropDown(); return false;">
                                <img class="nav__img ic-notif" src="assets/images/ic-notif.png" alt="">
                            </a>
                            <div class="dropdown-content">
                                <?php if(empty($notifs)): ?>
                                    <h4>Tidak ada notifikasi masuk</h4>
                                    <img src="assets/images/not-found.svg" alt="Not Found" class="no-notif">
                                <?php endif; ?>

                                <?php if(!empty($notifs)): ?>
                                <h1>Order Masuk</h1>
                                <?php endif; ?>

                                <div class="dropdown-list">
                                <?php foreach ($notifs as $notif): ?>
                                    <div class="d-inline-flex detail">
                                        <img src="assets/images/produk/<?= $notif["gambar"]; ?>" alt="">
                                        <div class="notif">
                                            <h2 class="no-wrap"><?= $notif["nama"]; ?></h2>
                                            <div class=" d-inline-flex">
                                                <p>Jumlah: <span><?= $notif["jumlah_produk"]; ?></span> pcs Total Harga:<span><?= rupiah($notif["total_harga"]); ?></span></p>
                                                <p></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <a class="nav_link" href="upload.php">
                            <img class="nav__img" src="assets/images/ic-upload.png" alt="">
                        </a>
                    <?php endif; ?>
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
                            <a class="dropdown-item" href="logout.php">Keluar</a> 
                        </div>
                    </div>
				</ul>
			</div>
            <?php endif; ?>
            <?php if(!isset($_SESSION["login"])): ?>
            <div class="nav__menu" id="nav-menu">
				<ul class="nav__list">
					<a class="nav__link active" style="cursor: pointer;" data-mdb-toggle="modal" data-mdb-target="#masukModal">
                        <li class="nav__item">Masuk</li>
                    </a>
					<a class="nav__link" data-mdb-toggle="modal" data-mdb-target="#daftarModal"> 
                        <li class="nav__item"><button class="daftar">Daftar</button></li>
                    </a>
				</ul>
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

    <!-- Detail Notif Modal -->
    <!-- <div class="modal fade" id="notifDetail" tabindex="-1" aria-labelledby="notifDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="d-flex justify-content-end me-3">
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <h5 class="modal-title" id="notifDetailLabel">Detail Pesanan</h5>
                <div class="modal-body detail-notif-content">
                    <img src="assets/images/produk/" alt="">
                    <div class="notif-info">
                        <h6></h6>
                        <p>Jumlah: <span></span> pcs Total Harga:<span></span></p>
                    </div>
                </div>
            </div>
        </div> 
    </div> -->
    <!-- Masuk Modal -->
    <div class="modal fade" id="masukModal" tabindex="-1" aria-labelledby="masukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-container">
            <div class="modal-content text-center">
                <div class="d-inline-flex justify-content-end me-3">
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <h1 class="mb-0">Masuk</h1>
                <h2>Pilih Masuk sebagai Penjual atau Pembeli</h2>
                <div class="d-flex flex-row card">
                    <a href="login-penjual.php" class="kiri">
                        <div>
                            <img src="assets/images/ic-penjual.svg" alt="">
                            <h1>Penjual</h1>
                        </div>
                    </a>

                    <a href="login-pembeli.php">                        
                        <div style="cursor: pointer;">
                            <img src="assets/images/ic-pembeli.svg" alt="">
                            <h1>Pembeli</h1>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Daftar Modal -->
    <div class="modal fade" id="daftarModal" tabindex="-1" aria-labelledby="daftarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-container">
            <div class="modal-content text-center">
                <div class="d-inline-flex justify-content-end me-3">
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <h1 class="mb-0">Daftar</h1>
                <h2>Pilih Daftar sebagai Penjual atau Pembeli</h2>
                <div class="d-flex flex-row card">
                    <a href="register-penjual.php" class="kiri">
                        <div>
                            <img src="assets/images/ic-penjual.svg" alt="">
                            <h1>Penjual</h1>
                        </div>
                    </a>

                    <a href="register-pembeli.php">                        
                        <div style="cursor: pointer;">
                            <img src="assets/images/ic-pembeli.svg" alt="">
                            <h1>Pembeli</h1>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="page-produk">
        <!--Searchbar-->
        <div class="wrapper">
            <br>
            <div class="search-input">
                <form action="" method="post" autocomplete="off">
                    <input type="text" id="input" name="keyword" placeholder="Cari sesuatu?" />
                    <ul class="list"></ul>
                    <button type="submit" name="cari" class="icon-search"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <!--List Products-->
        <?php if(empty($products)): ?>
            <div class="not-found">
                <img src="assets/images/not-found.svg" alt="Not Found">
                <h2>Oops, produk tidak ditemukan</h2>
                <p>Coba kata kunci lain atau cek produk lain</p> 
            </div>
        <?php endif; ?>
        <div class="products-container">
            <div class="grid-container">
                <?php foreach($products as $product): ?>
                <div class="product">
                    <img src="assets/images/produk/<?= $product["gambar"]; ?>" alt="" class="gambar">
                    <?php 
                    $status = "tersedia";
                    if($product["stok"] == 0) $status="habis";
                    ?>
                    <img src="assets/images/<?= $status; ?>.svg" alt="Is Available" class="is-available">
                    <h3 class="nama-produk"><?= $product["nama"]; ?></h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <i class="far fa-star"></i>
                        <span>( 3.5 )</span>
                    </div>
                    <p><strong>Harga</strong></p>
                    <div class="price"><?= rupiah($product["harga"]); ?></div>
                    <div class="btn-lihat-produk">
                        <?php if ($is_penjual): ?>
                        <a href="edit-produk.php?id-produk=<?= $product["id"]; ?>">Edit Produk</a>
                        <?php else: ?>
                        <a href="detail-produk.php?id-produk=<?= $product["id"]; ?>">Lihat Produk</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

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
    <!--===== SCROLL REVEAL =====-->
    <script src="https://unpkg.com/scrollreveal"></script>
     <!--===== MDB JS =====-->
    <script type="text/javascript" src="assets/script/mdb.min.js?v=<?= time(); ?>"></script>
    <!--===== MAIN JS =====-->
    <script src="assets/script/main.js?v=<?= time(); ?>"></script>
    <!--===== SEARCHING & SUGGESTIONS JS =====-->
    <script>
        var names = [];
        <?php
            foreach($products    as $product):
        ?>
            names.push("<?= $product["nama"]; ?>");
        <?php endforeach; ?>
    </script>
    <script src="assets/script/searching.js?v=<?= time(); ?>"></script>
</body>
</html>
<?php 
    require 'functions.php';
    session_start();
    $is_penjual = false;
    if(isset($_SESSION['id-penjual'])) {
        $is_penjual = true;
        $id_penjual = $_SESSION['id-penjual'];
        $notifs = get_notif($id_penjual);
    }
    $bests = get_rows_from("products WHERE is_best_seller = 1");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaggotHub</title>
    <link rel="shortcut icon" href="./assets/images/logo.png" type="image/x-icon">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <!--MDB CSS-->
    <link rel="stylesheet" href="./assets/css/mdb/mdb.min.css?v=<?= time(); ?>">
    <!--Main CSS-->
    <link rel="stylesheet" href="./assets/css/style.css?v=<?= time(); ?>">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    
    
</head>
<body>
    <header>
        <nav class="nav bd-grid">  
            <img src="./assets/images/maggothub.svg" class="logo-maggothub" alt="">
            <div class="nav__logo">
                <h1><a href="index.php"><span>Maggot</span>Hub</a></h1>
            </div>
			<div class="nav__menu" id="nav-menu">
				<ul class="nav__list">
					<a href="index.php#home" class="nav__link active"><li class="nav__item"><strong>Beranda</strong></li></a>
					<a href="produk.php" class="nav__link"><li class="nav__item"><strong>Produk</strong></li></a>
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
                                <?php else: ?>
                                <h1>Order Masuk</h1>
                                <?php endif; ?>
                                
                                <div class="dropdown-list">
                                <?php foreach ($notifs as $notif): ?>
                                    <div class="d-inline-flex detail">
                                        <img src="assets/images/produk/<?= $notif["gambar"]; ?>" alt="">
                                        <div class="notif">
                                            <h2 class="no-wrap"><?= $notif["nama"]; ?></h2>
                                            <div class="d-flex justify-content-start">
                                                <p>Jumlah: <span><?= $notif["jumlah_produk"]; ?></span> pcs</p>
                                                <p>Total Harga:<span><?= rupiah($notif["total_harga"]); ?></span></p>
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
                            <a class="dropdown-item" href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');">Keluar</a> 
                        </div>
                    </div>
				</ul>
			</div>
            <?php endif; ?>
            <?php if(!isset($_SESSION["login"])): ?>
            <div class="nav__menu" id="nav-menu">
				<ul class="nav__list">
					<a class="nav__link active" style="cursor: pointer;"
                    data-mdb-toggle="modal" data-mdb-target="#masukModal">
                        <li class="nav__item">Masuk</li>
                    </a>
					<a class="nav__link" id="open-daftar" data-mdb-toggle="modal" data-mdb-target="#daftarModal"> 
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
    <div class="modal fade mt-5" id="masukModal" tabindex="-1" aria-labelledby="masukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-container" >
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
    <div class="modal fade mt-5" id="daftarModal" tabindex="-1" aria-labelledby="daftarModalLabel" aria-hidden="true">
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
    
    <!--Home-->
	<section class="home <?php if($is_penjual) echo " vh-100"; ?>" id="home">
		<div class="home__container isi">
            <div class="home__desc judul">
                <h2 class="home__subtitle">Mengenal Apa Itu <br> MaggotHub</h2>
                <p class="home__text">MaggotHub adalah website yang khusus menjual berbagai macam produk olahan maggot BSF. Visi website ini adalah memperkenalkan produk olahan maggot BSF di Indonesia, membantu memasarkan produk-produk olahan maggot yang terintegrasi dalam satu platform, dan memudahkan pembeli untuk mencari produk olahan maggot BSF sesuai keinginan.</p>
                <?php if($is_penjual): ?>
                    <a href="produk.php" class="home__btn"><button>Kelola Produk Anda</button></a>
                <?php endif; ?>

                <?php if(!$is_penjual): ?>
                    <a href="#best-seller" class="home__btn"><button>Mulai Belanja</button></a>
                <?php endif; ?>
            </div>
            <div class="home__img fotosamping">
                <img src="assets/images/maggothub.svg" alt="Logo MaggotHub" class="img-fluid animated">
            </div>
		</div>
	</section>

    <?php if(!$is_penjual): ?>
    <!--Tentang BSF-->
    <section class="tentang-bsf" id="tentang-bsf">
        <h2 class="section-title">Tentang BSF<h2>
        <div class="tentang__container isi">
            <div class="tentang__img fotosamping">
                <img src="assets/images/siklus-bsf.jpg" alt="Siklus BSF">
            </div>
            <div class="tentang__desc judul">
                <h2 class="tentang__subtitle">Black Soldier Fly (BSF)</h2>
                <p class="tentang__text">Black Soldier Fly (BSF) merupakan jenis lalat yang berukuran 3 kali lalat biasa. Selain berguna untuk mengurangi dampak negatif dari penumpukan material organik di alam, larva/maggot BSF juga sangat baik dan ekonomis untuk dimanfaatkan sebagai pakan hewan dan kotorannya yang biasa disebut kasgot dapat dimanfaatkan sebagai pupuk tanaman.</p>
            </div>
        </div>
    </section>

    <!--Produk Best Seller-->
    <div class="swiper mySwiper best-container">
        <h1 id="best-seller">Best Seller</h1>
        <div class="swiper-wrapper best-wrapper">
            <?php foreach($bests as $best): ?>
            <div class="swiper-slide best-product">
                <img src="assets/images/produk/<?= $best["gambar"]; ?>" alt="" class="gambar">
                <?php 
                    $status = "tersedia";
                    if($best["stok"] == 0) $status="habis";
                ?>
                <img src="assets/images/<?= $status; ?>.svg" alt="Is Available" class="is-available">
                <h3 class="nama-produk"><?= $best["nama"]; ?></h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <i class="far fa-star"></i>
                    <span>( 3.5 )</span>
                </div>
                <p>Harga</p>
                <div class="price"><?= rupiah($best["harga"]); ?></div>
                <div class="btn-lihat-produk">
                    <a href="detail-produk.php?id-produk=<?= $best["id"]; ?>">Lihat Produk</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- <div class="swiper-pagination"></div> -->
    </div>
    <div class="btn-selengkapnya">
        <a href="produk.php" class="btn-selengkapnya"><button>Lihat Selengkapnya</button></a>
    </div>
    <?php endif; ?>

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
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
     <!--===== MDB JS =====-->
     <script type="text/javascript" src="./assets/script/mdb.min.js?v=<?= time(); ?>"></script>
    <!--===== MAIN JS =====-->
    <script src="./assets/script/main.js?v=<?= time(); ?>"></script>

</body>
</html>
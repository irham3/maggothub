<?php 
    require 'functions.php';
    session_start();

    // Tidak boleh masuk halaman ini sebagai pembeli ataupun bypass via url
    $is_penjual = false;
    if(isset($_SESSION['id-penjual'])) {
        $is_penjual = true;

        $id_penjual = $_SESSION['id-penjual'];
        $notifs = get_notif($id_penjual);

        $product_id = $_GET["id-produk"];
        $product = get_rows_from("products WHERE id = $product_id")[0];
    }

    if(!isset($_GET["id-produk"]) || !$is_penjual) {
        header("Location: produk.php");
        exit;
    }

    if(isset($_POST["edit"])) {
        // Cek apakah data berhasil ditambahkan
        if(update($_POST) > 0) {
            echo "<script>
                alert('Produk berhasil diedit');
            </script>";
        } else {
            echo "<script>
                alert('Produk gagal diedit');
            </script>";
        }
        header("Refresh:1");
    }
    
    // Harga produk
    $harga = $product["harga"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="shortcut icon" href="./assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <!--MDB CSS-->
    <!-- <link rel="stylesheet" href="assets/css/mdb/mdb.min.css?v=<?= time(); ?>"> -->
    <!-- Main -->
    <link rel="stylesheet" href="./assets/css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>

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
					<a href="index.php" class="nav_link"><li class="nav__item"><strong>Beranda</strong></li></a>
					<a href="produk.php" class="nav_link"><li class="nav__item"><strong>Produk</strong></li></a>
                    <?php if(!$is_penjual): ?>
					    <a href="index.php#tentang-bsf" class="nav_link"><li class="nav_item"><strong>Tentang BSF</strong></li></a>
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
                            <a class="dropdown-item" href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');">Keluar</a> 
                        </div>
                    </div>
				</ul>
			</div>
            <?php endif; ?>
            <?php if(!isset($_SESSION["login"])): ?>
            <div class="nav__menu" id="nav-menu">
				<ul class="nav__list">
					<a class="nav__link active" id="open-masuk" style="cursor: pointer;">
                        <li class="nav__item">Masuk</li>
                    </a>
					<a class="nav__link" id="open-daftar"> 
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

    <!--Edit Produk-->
    <div class="container" id="form-upload">
        <div class="form-produk">
            <form style="display: flex;" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id-product" name="id-product" value="<?= $product_id; ?>">
                <div>
                    <div class="form-group">
                        <label for="nama-produk">Nama Produk</label>
                        <input type="text" class="form-control" placeholder="Nama Produk"
                        id="nama-produk" name="nama-produk" value="<?= $product["nama"]; ?>" required>
                    </div>
                    <div class="d-inline-flex half">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga"
                                placeholder="Harga Produk" value="<?= $product["harga"]; ?>" required
                                onkeypress="return onlyNumberKey(event)" maxlength="11">
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="name" class="form-control" name="stok" id="stok"   
                            placeholder="Jumlah Stok" onkeypress="return onlyNumberKey(event)"
                            maxlength="11" value="<?= $product["stok"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" required>
                            <?= $product["deskripsi"]; ?>
                        </textarea>
                    </div>
                    <button type="submit" name="edit">Edit Produk</button>
                </div>
                <div class="upload-container">
                    <div class="upload-wrapper">
                        <div class="upload-image">
                            <img src="./assets/images/produk/<?= $product["gambar"]; ?>" alt=""
                            style="display: block;">
                        </div>
                        <div class="upload-content">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">
                                Belum Ada Gambar Yang Dipilih!
                            </div>
                        </div>
                        <div id="upload-cancel-btn">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="upload-file-name">
                            File name here
                        </div>
                    </div>
                    <button type="button" onclick="uploadBtnActive()" id="upload-custom-btn" name="chooseBtn">Pilih Gambar Produk</button>
                    <input type="file" id="upload-default-btn" name="image-file" hidden>
                </div>
            </form>
        </div>
    </div>
     <!--===== SCROLL REVEAL =====-->
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!--===== MAIN JS =====-->
    <script src="assets/script/main.js?v=<?= time(); ?>"></script>
    <script>
        /*=====NUMBER ONLY FORM INPUT=====*/
         function onlyNumberKey(evt) {
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
         }
         
         const wrapper = document.querySelector(".upload-wrapper");
         const defaultContent = document.querySelector(".upload-content");
         const fileName = document.querySelector(".upload-file-name");
         const defaultBtn = document.querySelector("#upload-default-btn");
         const customBtn = document.querySelector("#upload-custom-btn");
         const cancelBtn = document.querySelector("#upload-cancel-btn i");
         const img = document.querySelector(".upload-image img");
         let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

         function uploadBtnActive(){
           defaultBtn.click();
         }

         defaultBtn.addEventListener("change", function(){
           const file = this.files[0];
           if(file){
             const reader = new FileReader();
             reader.onload = function(){
               const result = reader.result;
               defaultContent.style.display = 'none';
               img.style.display = 'block';
               img.src = result;
               wrapper.classList.add("active");
            }
             cancelBtn.addEventListener("click", function(){
               defaultContent.style.display = 'block';
               img.style.display = 'none';
               img.src = "";
               defaultBtn.value = '';
               wrapper.classList.remove("active");
             })
             reader.readAsDataURL(file);
           }
           if(this.value){
             let valueStore = this.value.match(regExp);
             fileName.textContent = valueStore;
           }
         });
      </script>
</body>
</html>
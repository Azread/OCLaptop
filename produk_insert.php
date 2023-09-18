<?php 
  // Sertakan file-file yang diperlukan
  include("keselamatan.php"); 
  include("sambungan.php"); 
  include("penjual_menu.php"); 

  // Periksa jika borang telah dihantar
  if(isset($_POST["submit"])){
    // Dapatkan data daripada borang
    $idProduk = $_POST["idProduk"];
    $namaProduk = $_POST["namaProduk"];
    $harga = $_POST["harga"];
    $keterangan = $_POST["keterangan"];
    $jenama = $_POST["jenama"];
    $idPenjual = $_POST["idPenjual"];
    $namafail = $idProduk.".png";
    $sementara = $_FILES["namafail"]["tmp_name"];
    
    // Muat naik fail gambar
    $uploadOk = move_uploaded_file($sementara,"imej/".basename($namafail));

    // Semak jika muat naik fail gambar berjaya
    if ($uploadOk) {
      // Masukkan data produk ke dalam pangkalan data
      $sql = "INSERT INTO produk (idProduk, namaProduk, keterangan, gambar, harga, idPenjual, jenama) VALUES ('$idProduk', '$namaProduk', '$keterangan', '$namafail', '$harga', '$idPenjual', '$jenama')";
      $result = mysqli_query($sambungan, $sql);
      
      // Semak jika penyisipan berjaya
      if($result == true) {
        echo "<br><center>Berjaya tambah</center>";
        header("Location: produk_senarai.php");
        exit;
      } else {
        echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
      }
    } else {
      echo "<br><center>Ralat: Gagal muat naik fail gambar.</center>";
    }      
  }
?>

<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="css/borang.css">
<form class="borang" action="produk_insert.php" method="post" enctype="multipart/form-data">
    <p class="title">Tambah Produk</p>
    <div class="borang-grid">
      <label for="id-produk">ID Produk</label>
      <input type="text" name="idProduk" placeholder="ID Produk" required/>
    </div>
    <div class="borang-grid">
      <label for="nama-produk">Nama Produk</label>
      <input type="text" name="namaProduk" placeholder="Nama Produk" required/>
    </div>
    <div class="borang-grid">
      <label for="gambar">Gambar 500x500</label>
      <input type="file" name="namafail" accept=".png" required/>
    </div>
    <div class="borang-grid">
      <label for="harga">Harga(RM)</label>
      <input type="text" name="harga" placeholder="1000.00" step="0.01" required/>
    </div>
    <div class="borang-grid">
      <label for="jenama-produk">Jenama</label>
      <input type="text" name="jenama" placeholder="Jenama" required/>
    </div>
    <div class="borang-grid">
      <label for="keterangan">Keterangan</label>
      <textarea name="keterangan" cols="25" rows="5" placeholder="Keterangan" required></textarea>
    </div>
    <div class="borang-grid">
    <label for="penjual">Penjual</label>
      <select name="idPenjual">
        <?php
          $sql = "select * from penjual";
          $data = mysqli_query($sambungan, $sql);
          while($penjual = mysqli_fetch_array($data)){
            echo "<option value='$penjual[idPenjual]'>$penjual[namaPenjual]
            </option>";
          }
        ?>
      </select>
    </div>
    <div class="borang-flexbox">
      <button class="borang-button" type="submit" name="submit">Tambah</button>
    </div>
</form>


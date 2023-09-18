<?php 
  // Sertakan file-file yang diperlukan
  include("keselamatan.php"); 
  include("sambungan.php"); 
  include("penjual_menu.php"); 

  // Semak jika borang telah dihantar
  if(isset($_POST["submit"])){
    // Dapatkan data daripada borang
    $idProduk = $_POST["idProduk"];
    $namaProduk = $_POST["namaProduk"];
    $harga = $_POST["harga"];
    $jenama = $_POST["jenama"];
    $keterangan = $_POST["keterangan"];
    $namafail = $_FILES["namafail"]["name"];
    $sementara = $_FILES["namafail"]["tmp_name"];
    
    if($namafail) {
      // Semak jika fail gambar berjaya dimuat naik
      if(move_uploaded_file($sementara, "imej/".basename($namafail))){
        // Kemaskini rekod produk dengan gambar yang baru
        $sql = "UPDATE produk SET namaProduk = '$namaProduk', gambar = '$namafail', harga = '$harga', jenama = '$jenama', keterangan = '$keterangan' WHERE idProduk = '$idProduk'";
        
        $result = mysqli_query($sambungan, $sql);
        
        // Semak jika kemaskini berjaya
        if($result == true) {
          echo "<br><center>Berjaya kemaskini</center>";
          header("Location: produk_senarai.php");
          exit;
        } else {
          echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
        }
      } else {
        echo "<br><center>Ralat: Gagal muat naik gambar</center>";
      }
    } else {
      // Kemaskini rekod produk tanpa menukar gambar
      $sql = "UPDATE produk SET namaProduk = '$namaProduk', harga = '$harga', jenama = '$jenama', keterangan = '$keterangan' WHERE idProduk = '$idProduk'";
      
      $result = mysqli_query($sambungan, $sql);
      
      // Semak jika kemaskini berjaya
      if($result == true) {
        echo "<br><center>Berjaya kemaskini</center>";
        header("Location: produk_senarai.php");
        exit;
      } else {
        echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
      }
    }
  }

  // Semak jika ID Produk diterima melalui parameter GET
  if(isset($_GET["idProduk"])) {
    $idProduk = $_GET["idProduk"];
  } else {
    $idProduk = "";
  }

  // Dapatkan maklumat produk berdasarkan ID Produk
  $sql = "SELECT * FROM produk WHERE idProduk = '$idProduk'";
  $result = mysqli_query($sambungan, $sql);

  while($produk = mysqli_fetch_array($result)){
    $namaProduk = $produk['namaProduk'];
    $namafail = $produk['gambar'];
    $harga = $produk['harga'];
    $jenama = $produk['jenama'];
    $keterangan = $produk['keterangan'];
  }
?>

<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="css/borang.css">
<form class="borang" action="produk_update.php" method="post" enctype="multipart/form-data">
  <p class="title">Kemaskini Produk</p>
  <div class="borang-grid">
    <label for="id-produk">ID Produk</label>
    <input type="text" name="idProduk" value="<?php echo $idProduk; ?>" placeholder="ID Produk" onclick="showWarning()" readonly />
  </div>
  <script>
    function showWarning() {
      alert("ID Produk tidak boleh diubah.");
    }
  </script>
  <div class="borang-grid">
    <label for="nama-produk">Nama Produk</label>
    <input type="text" name="namaProduk" value="<?php echo $namaProduk; ?>" placeholder="Nama Produk" required/>
  </div>
  <div class="borang-grid">
    <label for="gambar">Gambar</label>
    <?php
      $path = "imej/".$namafail;
      if (file_exists($path)) {
        echo "<img src='$path' width='100'><br>";
      }
    ?>
    <input type="file" name="namafail"/>
  </div>
  <div class="borang-grid">
    <label for="harga">Harga (RM)</label>
    <input type="number" name="harga" value="<?php echo $harga; ?>" placeholder="1000.00" step="0.01" required/>
  </div>
  <div class="borang-grid">
    <label for="jenama-produk">Jenama</label>
    <input type="text" name="jenama" value="<?php echo $jenama; ?>" placeholder="Jenama" required/>
  </div>
  <div class="borang-grid">
    <label for="keterangan">Keterangan</label>
    <textarea name="keterangan" cols="25" rows="5" placeholder="Keterangan" required><?php echo $keterangan; ?></textarea>
  </div>
  <div class="borang-flexbox">
    <button class="borang-button" type="submit" name="submit">Kemaskini</button>
  </div>
</form>


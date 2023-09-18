<?php
  // Sertakan file-file yang diperlukan
  include("keselamatan.php");
  include("sambungan.php");
  include("penjual_menu.php");

  // Semak jika borang telah dihantar
  if(isset($_POST["submit"])){
    // Dapatkan data daripada borang
    $idPembeli = $_POST["idPembeli"];
    $namaPembeli = $_POST["namaPembeli"];
    $password = $_POST["password"];
    $telPembeli = $_POST["telPembeli"];

    // Kemaskini rekod pembeli dalam pangkalan data
    $sql = "UPDATE pembeli
            SET namaPembeli = '$namaPembeli', password = '$password', telPembeli = '$telPembeli'
            WHERE idPembeli = '$idPembeli'";
    $result = mysqli_query($sambungan, $sql);

    // Semak jika kemaskini berjaya
    if($result == true) {
      echo "<br><center>Berjaya kemaskini</center>";
      header("Location: pembeli_senarai.php");
      exit;
    } else {
      echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
    }
  }

  // Dapatkan ID Pembeli dari parameter GET
  if(isset($_GET["idPembeli"]))
    $idPembeli = $_GET["idPembeli"];

  // Dapatkan maklumat pembeli dari pangkalan data
  $sql = "SELECT * FROM pembeli WHERE idPembeli = '$idPembeli'";
  $result = mysqli_query($sambungan, $sql);
  while($pembeli = mysqli_fetch_array($result)){
    $password = $pembeli['password'];
    $namaPembeli = $pembeli['namaPembeli'];
    $telPembeli = $pembeli['telPembeli'];
  }
?>

<link rel="stylesheet" href="css/borang.css">
<link rel="stylesheet" href="css/button.css">
<form class="borang" action="pembeli_update.php" method="post">
  <p class="title">Kemaskini Pembeli</p>
  <div class="borang-grid">
    <label for="id-pengguna">ID Pembeli</label>
    <input type="text" name="idPembeli" value="<?php echo $idPembeli; ?>" placeholder="ID Pembeli" onclick="showWarning()" readonly/>
  </div>
  <script>
    function showWarning() {
      alert("ID Produk tidak boleh diubahkan.");
    }
  </script>
  <div class="borang-grid">
    <label for="nama-pembeli">Nama Pembeli</label>
    <input type="text" name="namaPembeli" value="<?php echo $namaPembeli; ?>"  placeholder="Nama Pembeli" />
  </div>
  <div class="borang-grid">
    <label for="kata-laluan">Kata Laluan</label>
    <input type="password" name="password" value="<?php echo $password; ?>"  placeholder="Kata Laluan" />
  </div>
  <div class="borang-grid">
    <label for="no-tel">Nombor Telefon</label>
    <input type="tel" name="telPembeli" value="<?php echo $telPembeli; ?>" placeholder="Nombor Telefon" />
  </div>
  <div class="borang-flexbox">
      <button class="borang-button" type="submit" name="submit">Kemaskini</button>
  </div>
</form>



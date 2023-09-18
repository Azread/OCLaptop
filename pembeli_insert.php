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

    // Semak jika terdapat medan yang kosong
    if(empty($idPembeli) || empty($namaPembeli) || empty($password) || empty($telPembeli)){
      echo "<br><center>Ralat: Sila isi semua medan</center>";
    } else {
      // Masukkan data pembeli ke dalam pangkalan data
      $sql = "INSERT INTO pembeli VALUES('$idPembeli', '$password', '$namaPembeli', '$telPembeli')";
      $result = mysqli_query($sambungan, $sql);

      // Semak jika penyisipan berjaya
      if($result == true) {
        echo "<br><center>Berjaya tambah</center>";
        header("Location: pembeli_senarai.php");
        exit;
      } else {
        echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
      }      
    }
  }
?>

<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="css/borang.css">

<form class="borang" action="pembeli_insert.php" method="post">
  <p class="title">Tambah Pembeli</p>
  <div class="borang-grid">
    <label for="id-pengguna">ID Pembeli</label>
    <input required type="text"
           name="idPembeli" placeholder="P001" 
           pattern="[A-Z0-9]{4}"
           oninvalid="this.setCustomValidity('Sila masukkan 4 aksara')"
           oninput="this.setCustomValidity('')"/>
  </div>
  <div class="borang-grid">
    <label for="nama-pembeli">Nama Pembeli</label>
    <input type="text" name="namaPembeli" placeholder="John Doe" required/>
  </div>
  <div class="borang-grid">
    <label for="kata-laluan">Kata Laluan</label>
    <input type="password" name="password" placeholder="1234" required/>
  </div>
  <div class="borang-grid">
    <label for="no-tel">Nombor Telefon</label>
    <input type="tel" placeholder="Nombor Telefon" name="telPembeli" required/>
  </div>
  <div class="borang-flexbox">
    <button class="borang-button" type="submit" name="submit">Tambah</button>
  </div>
</form>



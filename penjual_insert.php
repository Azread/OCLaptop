<?php
  // Sertakan file-file yang diperlukan
  include("keselamatan.php");
  include("sambungan.php");
  include("penjual_menu.php");

  // Semak jika borang telah dihantar
  if(isset($_POST["submit"])){
    // Dapatkan data daripada borang
    $idPenjual = $_POST["idPenjual"];
    $namaPenjual = $_POST["namaPenjual"];
    $password = $_POST["password"];

    // Semak jika terdapat medan yang kosong
    if(empty($idPenjual) || empty($namaPenjual) || empty($password)){
      echo "<br><center>Ralat: Sila isi semua medan</center>";
    } else {
      // Tambah rekod penjual dalam pangkalan data
      $sql = "INSERT INTO penjual VALUES('$idPenjual', '$password', '$namaPenjual')";
      $result = mysqli_query($sambungan, $sql);

      // Semak jika tambah berjaya
      if($result == true) {
        echo "<br><center>Berjaya tambah</center>";
        header("Location: penjual_senarai.php");
        exit;
      } else {
        echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
      }      
    }
  }
?>

<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="css/borang.css">
<form class="borang" action="penjual_insert.php" method="post">
    <p class="title">Tambah Penjual</p>
    <div class="borang-grid">
      <label for="id-pengguna">ID Penjual</label>
      <input required type="text"
             name="idPenjual" placeholder="J01" 
             pattern="[A-Z0-9]{3}"
             oninvalid="this.setCustomValidity('Sila masukkan 3 aksara')"
             oninput="this.setCustomValidity('')"/>
    </div>
    <div class="borang-grid">
      <label for="nama-penjual">Nama Penjual</label>
      <input type="text" name="namaPenjual" placeholder="John Doe" required/>
    </div>
    <div class="borang-grid">
      <label for="kata-laluan">Kata Laluan</label>
      <input type="password" name="password" placeholder="1234" required/>
    </div>
    <div class="borang-flexbox">
      <button class="borang-button" type="submit" name="submit">Tambah</button>
    </div>
</form>



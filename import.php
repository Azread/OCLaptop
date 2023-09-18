<?php 
include("keselamatan.php"); 
include("sambungan.php"); 
include("penjual_menu.php"); 

if (isset($_POST["submit"])) {
  // Dapatkan nilai dari borang import
  $namajadual = $_POST["namajadual"];
  $namafail = $_FILES["namafail"]["name"];
  $sementara = $_FILES["namafail"]["tmp_name"];
  move_uploaded_file($sementara, $namafail);

  // Buka fail untuk dibaca
  $fail = fopen($namafail, "r");
  while (!feof($fail)) {
    $medan = explode(",", fgets($fail));
    $berjaya = false;

    if (strtolower($namajadual) === "pembeli") {
      // Dapatkan nilai medan untuk jadual pembeli
      $idPembeli = $medan[0];
      $password = $medan[1];
      $namaPembeli = $medan[2];
      $telPembeli = $medan[3];

      // Lakukan penyisipan rekod ke jadual pembeli
      $sql = "INSERT INTO pembeli VALUES ('$idPembeli', '$password', '$namaPembeli', '$telPembeli')";
      if (mysqli_query($sambungan, $sql))
        $berjaya = true;
      else
        echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
    }

    if (strtolower($namajadual) === "penjual") {
      // Dapatkan nilai medan untuk jadual penjual
      $idPenjual = $medan[0];
      $password = $medan[1];
      $namaPenjual = $medan[2];

      // Lakukan penyisipan rekod ke jadual penjual
      $sql = "INSERT INTO penjual VALUES ('$idPenjual', '$password', '$namaPenjual')";
      if (mysqli_query($sambungan, $sql))
        $berjaya = true;
      else
        echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
    }
  }

  // Tampilkan mesej berjaya atau gagal
  if ($berjaya == true)
    echo "<script>alert('Rekod berjaya import');</script>";
  else
    echo "<script>alert('Rekod tidak berjaya import');</script>";

  mysqli_close($sambungan);
}
?>

<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="css/borang.css">
<form class="borang" action="import.php" method="post" enctype="multipart/form-data">
  <p class="title">Import Data</p>
  <div class="borang-grid">
    <label for="Jadual">Jadual</label>
    <select name="namajadual" class="jadual">
      <option label="Pembeli">Pembeli</option>
      <option label="Penjual">Penjual</option>
    </select>
  </div>
  <div class="borang-grid">
    <label for="namafail">Nama fail</label>
    <input type="file" name="namafail" accept=".txt" required>
  </div>
  <div class="borang-flexbox">
    <button class="borang-button" type="submit" name="submit">Import</button>
  </div>
</form>


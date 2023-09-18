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

    // Kemaskini rekod penjual dalam pangkalan data
    $sql = "UPDATE penjual
    SET namaPenjual = '$namaPenjual', password = '$password'
    WHERE idPenjual = '$idPenjual'";
    $result = mysqli_query($sambungan, $sql);

    // Semak jika kemaskini berjaya
    if($result == true) {
      echo "<br><center>Berjaya kemaskini</center>";
      header("Location: penjual_senarai.php");
      exit;
    } else {
      echo "<br><center>Ralat: $sql<br>".mysqli_error($sambungan)."</center>";
    }
  }

  // Semak jika terdapat parameter idPenjual dalam URL
  if(isset($_GET["idPenjual"]))
    $idPenjual = $_GET["idPenjual"];

  // Dapatkan maklumat penjual dari pangkalan data
  $sql = "SELECT * FROM penjual WHERE idPenjual = '$idPenjual'";
  $result = mysqli_query($sambungan, $sql);
  while($penjual = mysqli_fetch_array($result)){
    $password = $penjual['password'];
    $namaPenjual = $penjual['namaPenjual'];
  }
?>

<link rel="stylesheet" href="css/borang.css">
<link rel="stylesheet" href="css/button.css">
<form class="borang" action="penjual_update.php" method="post">
  <p class="title">Kemaskini Penjual</p>
  <div class="borang-grid">
    <label for="id-pengguna">ID Penjual</label>
    <input type="text" name="idPenjual" value="<?php echo $idPenjual; ?>" placeholder="ID Penjual" onclick="showWarning()" readonly />
  </div>
  <script>
    function showWarning() {
      alert("ID Produk tidak boleh diubah.");
    }
  </script>
  <div class="borang-grid">
    <label for="nama-penjual">Nama Penjual</label>
    <input type="text" name="namaPenjual" value="<?php echo $namaPenjual; ?>"  placeholder="Nama Penjual" />
  </div>
  <div class="borang-grid">
    <label for="kata-laluan">Kata Laluan</label>
    <input type="password" name="password" value="<?php echo $password; ?>"  placeholder="Kata Laluan" />
  </div>
  <div class="borang-flexbox">
      <button class="borang-button" type="submit" name="submit">Kemaskini</button>
  </div>
</form>


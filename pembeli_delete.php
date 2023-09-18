<?php
  include("sambungan.php");
  include("pembeli_menu.php");

  $idPembeli = $_GET["idPembeli"];

  $sql = "delete from pembeli where idPembeli = '$idPembeli'";
  $result = mysqli_query($sambungan, $sql);

  echo "<script>window.location='pembeli_senarai.php'</script>";
?>

<?php
  include("sambungan.php");
  include("penjual_menu.php");

  $idPenjual = $_GET["idPenjual"];

  $sql = "delete from penjual where idPenjual = '$idPenjual'";
  $result = mysqli_query($sambungan, $sql);

  echo "<script>window.location='penjual_senarai.php'</script>";
?>
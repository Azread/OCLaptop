<?php
  include("keselamatan.php");
  include("sambungan.php");

  $idBandingan = $_GET["idBandingan"];

  $sql = "delete from bandingan where idBandingan = '$idBandingan'";
  $result = mysqli_query($sambungan, $sql);

  echo "<script>window.location='bandingan_senarai.php'</script>";
?>

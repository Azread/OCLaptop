<?php
  include("keselamatan.php");
  include("sambungan.php");

  $idProduk = $_GET["idProduk"];

  $sql = "delete from produk where idProduk = '$idProduk'";
  $result = mysqli_query($sambungan, $sql);

  echo "<script>window.location='produk_senarai.php'</script>";
?>
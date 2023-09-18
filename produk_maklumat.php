<?php
  include ("keselamatan.php");
  include ("sambungan.php");

  $status = isset($_SESSION["status"]) ? $_SESSION["status"] : "";
  if ($status == "pembeli")
    include ("pembeli_menu.php");
  else
    include ("penjual_menu.php");

  $idProduk = isset($_GET["idProduk"]) ? $_GET["idProduk"] : 0;

  $sql = "select * from produk where idProduk = '$idProduk'";

  $result = mysqli_query($sambungan, $sql);
  while($produk = mysqli_fetch_array($result)) {
        $gambar = $idProduk.".png";
        $namaProduk = $produk["namaProduk"];
        $harga = $produk["harga"];
        $jenama = $produk["jenama"];
        $keterangan = $produk["keterangan"];
  }
?>

<link rel="stylesheet" href="css/senarai.css">
<link rel="stylesheet" href="css/button.css">

<table class="penjual">
  <caption>Maklumat Produk</caption>
  <tr>
    <th>Perkara</th>
    <th>Maklumat</th>
  </tr>
  <tr>
    <td>ID Produk</td>
    <td><?php echo $idProduk; ?></td>
  </tr>
  <tr>
    <td>Gambar</td>
    <td><?php echo "<img width = 300 src='imej/".$gambar."'>"; ?></td>
  </tr>
  <tr>
    <td>Nama Produk</td>
    <td><?php echo $namaProduk; ?></td>
  </tr>
  <tr>
    <td>Harga</td>
    <td>RM <?php echo $harga; ?></td>
  </tr>
  <tr>
    <td>Jenama</td>
    <td><?php echo $jenama; ?></td>
  </tr>
  <tr>
    <td>Keterangan</td>
    <td style="white-space: pre-wrap;"><?php echo $keterangan; ?></td>
  </tr>
</table>
<button class="print-button" onclick="window.print()">Cetak</button>

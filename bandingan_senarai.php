<?php
session_start();
include("keselamatan.php");
include("sambungan.php");
include("pembeli_menu.php");

// Memeriksa jika data produk telah dihantar melalui POST
if (isset($_POST['idProduk'])) {
  $idPembeli = $_SESSION['idPengguna'];
  $idProduk = $_POST['idProduk'];

  // Memeriksa rekod bandingan yang sedia ada untuk pembeli
  $checkQuery = "SELECT * FROM bandingan WHERE idPembeli = '$idPembeli'";
  $checkResult = mysqli_query($sambungan, $checkQuery);
  if (!$checkResult) {
    die('Ralat Kueri: ' . mysqli_error($sambungan));
  }

  $numRecords = mysqli_num_rows($checkResult);

  // Memeriksa jumlah rekod bandingan yang telah mencapai had maksimum (3)
  if ($numRecords < 3) {
    // Memeriksa jika produk telah dipilih dalam senarai bandingan
    $checkProductQuery = "SELECT * FROM bandingan WHERE idPembeli = '$idPembeli' AND idProduk = '$idProduk'";
    $checkProductResult = mysqli_query($sambungan, $checkProductQuery);
    if (!$checkProductResult) {
      die('Ralat Kueri: ' . mysqli_error($sambungan));
    }

    // Jika produk belum dipilih dalam senarai bandingan, masukkan rekod baru
    if (mysqli_num_rows($checkProductResult) === 0) {
      $insertQuery = "INSERT INTO bandingan (idPembeli, idProduk) VALUES ('$idPembeli', '$idProduk')";
      $insertResult = mysqli_query($sambungan, $insertQuery);
      if ($insertResult) {
        echo "<script>alert('Item berjaya ditambah dalam senarai bandingan');</script>";
      } else {
        echo "<script>alert('Ralat: $insertQuery\n" . mysqli_error($sambungan) . "');</script>";
      }
    } else {
      echo "<script>alert('Produk telah dipilih dalam senarai bandingan.');</script>";
    }
  } else {
    echo "<script>alert('Maksima 3 item sahaja dibenarkan...sila delete.');</script>";
  }
}

// Kueri untuk mendapatkan senarai produk dalam senarai perbandingan bagi pembeli yang sedang aktif
$sql = "SELECT * FROM bandingan
        JOIN produk ON bandingan.idProduk = produk.idProduk
        WHERE bandingan.idPembeli = '{$_SESSION['idPengguna']}'";
$result = mysqli_query($sambungan, $sql);
if (!$result) {
  die('Ralat Kueri: ' . mysqli_error($sambungan));
}
?>

<link rel="stylesheet" href="css/senarai.css">
<link rel="stylesheet" href="css/button.css">

<table>
  <caption>Perbandingan Produk</caption>
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Gambar</th>
    <th>Keterangan</th>
    <th>Harga</th>
    <th>Jenama</th>
    <th colspan="2">Tindakan</th>
  </tr>

  <?php
  if (mysqli_num_rows($result) > 0) {
    while ($produk = mysqli_fetch_array($result)) {
      echo "<tr>
              <td>{$produk['idProduk']}</td>
              <td>{$produk['namaProduk']}</td>
              <td><img width='100' src='imej/{$produk['gambar']}'></td>
              <td style='white-space: pre-wrap;'>{$produk['keterangan']}</td>
              <td>RM{$produk['harga']}</td>
              <td>{$produk['jenama']}</td>
              <td>
                <a href='bandingan_delete.php?idBandingan={$produk['idBandingan']}'>
                  <img src='imej/delete.png' class='icon' title='Padam'>
                </a>
              </td>
              <td>
                <a href='produk_maklumat.php?idProduk={$produk['idProduk']}'>
                  <img src='imej/info.png' class='icon' title='Maklumat'>
                </a>
              </td>
            </tr>";
    }
  } else {
    echo "<tr><td colspan='8'>Tiada produk dalam senarai perbandingan.</td></tr>";
  }
  ?>
</table>

<button class="print-button" onclick="window.print()">Cetak</button>
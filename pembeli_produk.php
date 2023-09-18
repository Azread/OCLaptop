<?php
include("keselamatan.php");
include("sambungan.php");
include("pembeli_menu.php");

// Dapatkan penapis jenama yang dipilih dan penapis harga dari array $_GET
$jenamaFilter = isset($_GET['jenama']) ? $_GET['jenama'] : array();
$hargaFilter = isset($_GET['harga']) ? $_GET['harga'] : '';

// Membina SQL query asas untuk memilih semua lajur dari jadual produk
$sql = "SELECT * FROM produk";

// Periksa jika terdapat istilah carian yang diberikan dalam array $_GET
if (isset($_GET['search'])) {
  $searchTerm = $_GET['search'];
  // Sambungkan klausa WHERE untuk menyaring hasil berdasarkan namaProduk dengan padanan sebahagian
  $sql .= " WHERE namaProduk LIKE '%$searchTerm%'";
}

// Queri untuk mendapatkan nilai jenama yang berbeza daripada jadual produk
$jenamaQuery = "SELECT DISTINCT jenama FROM produk";
$jenamaResult = $sambungan->query($jenamaQuery);
$jenamaOptions = array();
while ($jenama = $jenamaResult->fetch_assoc()) {
  $jenamaOptions[] = $jenama['jenama'];
}

// Periksa jika jenamaFilter tidak kosong
if (!empty($jenamaFilter)) {
  // Tukar nilai tunggal kepada array jika perlu
  if (!is_array($jenamaFilter)) {
    $jenamaFilter = array($jenamaFilter);
  }
  // Cipta tali dipisahkan dengan koma untuk nilai penapis
  $jenamaFilterString = implode("', '", $jenamaFilter);
  // Sambungkan syarat AND untuk menyaring hasil berdasarkan jenama yang dipilih
  $sql .= " AND jenama IN ('$jenamaFilterString')";
}

// Periksa jika hargaFilter tidak kosong
if (!empty($hargaFilter)) {
  // Sambungkan syarat AND yang bersesuaian berdasarkan julat harga yang dipilih
  if ($hargaFilter == 'harga1') {
    $sql .= " AND harga >= 0 AND harga <= 1000";
  } elseif ($hargaFilter == 'harga2') {
    $sql .= " AND harga >= 1000 AND harga <= 2000";
  } elseif ($hargaFilter == 'harga3') {
    $sql .= " AND harga >= 2000 AND harga <= 3000";
  } elseif ($hargaFilter == 'harga4') {
    $sql .= " AND harga >= 3000 AND harga <= 4000";
  } elseif ($hargaFilter == 'harga5') {
    $sql .= " AND harga >= 4000 AND harga <= 5000";
  } elseif ($hargaFilter == 'harga6') {
    $sql .= " AND harga > 5000";
  }
}

// Jalankan SQL query
$result = $sambungan->query($sql);
if (!$result) {
  die('Ralat Kueri: ' . $sambungan->error);
}
?>

<link rel="stylesheet" href="css/produk.css">
<link rel="stylesheet" href="css/button.css">

<div class="grid-container">
  <div class="grid-item" style="background-color: #D6D6D6">
    <form method="GET" action="">
      <div class="search-bar">
        <img src="imej/search-icon.png" class="search" />
        <input type="text" placeholder="Carian nama produk" id="search-input" name="search" />
        <button type="submit" class="search-button">Cari</button>
      </div>
      <hr>
      <div class="search-bar">
        <img src="imej/filter-icon.png" class="filter" />
        <p class="filter-text"><strong>Penapis</strong></p>
      </div>
      <div class="filter-item">
        <p><strong>Jenama</strong></p>
        <?php foreach ($jenamaOptions as $jenamaOption) {
          $checked = in_array($jenamaOption, $jenamaFilter) ? 'checked' : '';
          echo '<input type="checkbox" name="jenama[]" value="' . $jenamaOption . '" ' . $checked . '>' . $jenamaOption . '<br>';
        } ?>
      </div>
      <div class="filter-item">
        <p><strong>Harga</strong></p>
        <input type="radio" name="harga" value="harga1" <?php if ($hargaFilter == 'harga1') echo 'checked'; ?>>
        <label for="harga1">RM 0 - 1000</label><br>
        <input type="radio" name="harga" value="harga2" <?php if ($hargaFilter == 'harga2') echo 'checked'; ?>>
        <label for="harga2">RM 1000 - 2000</label><br>
        <input type="radio" name="harga" value="harga3" <?php if ($hargaFilter == 'harga3') echo 'checked'; ?>>
        <label for="harga3">RM 2000 - 3000</label><br>
        <input type="radio" name="harga" value="harga4" <?php if ($hargaFilter == 'harga4') echo 'checked'; ?>>
        <label for="harga4">RM 3000 - 4000</label><br>
        <input type="radio" name="harga" value="harga5" <?php if ($hargaFilter == 'harga5') echo 'checked'; ?>>
        <label for="harga5">RM 4000 - 5000</label><br>
        <input type="radio" name="harga" value="harga6" <?php if ($hargaFilter == 'harga6') echo 'checked'; ?>>
        <label for="harga6">RM 5000+</label><br>
     </div>
      <button type="submit" class="filter-button">Tapis</button>
    </form>
  </div>
  <div class="grid-item">
    <h1 style="text-align: center">Senarai Produk Komputer Riba</h1>
    <div class="inner-grid">

      <?php 
      if ($result->num_rows === 0) {
        echo '<script>alert("Tiada produk yang sepadan dengan kriteria carian."); window.location.href = "pembeli_produk.php";</script>';
      } else {
        while ($produk = $result->fetch_assoc()) { ?>
          <form method="POST" action="bandingan_senarai.php">
            <input type="hidden" name="idProduk" value="<?= $produk['idProduk'] ?>">
            <div class="grid-item">
              <div class="card">
                <a href="produk_maklumat.php?idProduk=<?= $produk['idProduk'] ?>" title="tekan untuk melihat maklumat produk"><img src="imej/<?= $produk['gambar'] ?>" class="product-picture" /></a>
                <h2><?= $produk['namaProduk'] ?></h2>
                <div class="details">
                  <p><strong>Harga: RM <?= $produk['harga'] ?></strong></p>
                  <p><strong>Jenama: <?= $produk['jenama'] ?></strong></p>
                </div>
                <button type="submit" class="banding-button">Banding</button>
              </div>
            </div>
          </form>
      <?php 
        }
      }
      ?>
    </div>
  </div>
</div>

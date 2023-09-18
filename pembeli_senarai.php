<?php
  include("keselamatan.php");
  include("sambungan.php");
  include("penjual_menu.php");
?>

<link rel="stylesheet" href="css/senarai.css">
<link rel="stylesheet" href="css/button.css">
<table>
  <caption>Senarai Nama Pembeli</caption>
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Password</th>
    <th>Nombor Telefon</th>
    <th colspan="2">Tindakan</th>
  </tr>

<?php
  $sql = "select * from pembeli";
  $result = mysqli_query($sambungan, $sql);
  while($pembeli = mysqli_fetch_array($result)){
    $idPembeli = $pembeli["idPembeli"];
    echo "<tr> <td>$pembeli[idPembeli]</td>
        <td class='nama'>$pembeli[namaPembeli]</td>
        <td>$pembeli[password]</td>
        <td>$pembeli[telPembeli]</td>
        <td>
        <a href='pembeli_update.php?idPembeli=$idPembeli'>
            <img src='imej/edit.png' class='icon' title='Kemaskini'>
          </a>
        </td>
        <td>
          <a href='javascript:padam(\"$idPembeli\")';>
            <img src='imej/delete.png' class='icon' title='Padam'>
          </a>
        </td>
      </tr>";
  }
?>
</table>

<div class="button-container">
<button class="add-button" onclick="window.location.href='pembeli_insert.php';"><span>+</span> Tambah Pembeli</button>
<button class="print-button" onclick="window.print()">Cetak</button>
</div>

<script>
  function padam(id){
    if(confirm("Adakah anda ingin padam")==true){
      window.location="pembeli_delete.php?idPembeli="+id;
    }
  }
</script>
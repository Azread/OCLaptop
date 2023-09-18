<?php
  include("keselamatan.php");
  include("sambungan.php");
  include("penjual_menu.php");
?>

<link rel="stylesheet" href="css/senarai.css">
<link rel="stylesheet" href="css/button.css">
<table>
  <caption>Senarai Nama Penjual</caption>
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Password</th>
    <th colspan="2">Tindakan</th>
  </tr>

<?php
  $sql = "select * from penjual";
  $result = mysqli_query($sambungan, $sql);
  while($penjual = mysqli_fetch_array($result)){
    $idPenjual = $penjual["idPenjual"];
    echo "<tr> <td>$penjual[idPenjual]</td>
        <td class='nama'>$penjual[namaPenjual]</td>
        <td>$penjual[password]</td>
        <td>
        <a href='penjual_update.php?idPenjual=$idPenjual'>
            <img src='imej/edit.png' class='icon' title='Kemaskini'>
          </a>
        </td>
        <td>
          <a href='javascript:padam(\"$idPenjual\")';>
            <img src='imej/delete.png' class='icon' title='Padam'>
          </a>
        </td>
      </tr>";
  }
?>
</table>

<div class="button-container">
<button class="add-button" onclick="window.location.href='penjual_insert.php';"><span>+</span> Tambah Penjual</button>
<button class="print-button" onclick="window.print()">Cetak</button>
</div>

<script>
  function padam(id){
    if(confirm("Adakah anda ingin padam")==true){
      window.location="penjual_delete.php?idPenjual="+id;
    }
  }
</script>
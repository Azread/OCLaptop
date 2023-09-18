<?php
  if(session_status() == PHP_SESSION_NONE){
    session_start();
  }

  // if(!isset($_SESSION["idPengguna"])){
  //     echo "<script>window.location='logout.php'</script>";
  // }
?>
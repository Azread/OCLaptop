<?php
  include("sambungan.php");
  if(isset($_POST["submit"])){
      // Dapatkan nilai dari borang pendaftaran
      $idPembeli = $_POST["idPembeli"];
      $password = $_POST["password"];
      $namaPembeli = $_POST["namaPembeli"];
      $telPembeli = $_POST["telPembeli"];

      // SQL query untuk memasukkan data ke dalam jadual pembeli
      $sql = "INSERT INTO pembeli VALUES('$idPembeli', '$password', '$namaPembeli', '$telPembeli')";
      $result = mysqli_query($sambungan,$sql);
      if($result)
        echo "<script>alert('Anda berjaya daftar')</script>";
      else
        echo "<script>alert('Anda tiada berjaya daftar')</script>";
      echo "<script>window.location='index.php'</script>";
  }
?>


<link rel="stylesheet" href="css/borang.css">
<link rel="stylesheet" href="css/button.css">

<body>
  <img src="imej/logo.png" class="title-logo">
  <form class="borang" action="signup.php" method="post">
    <p class="title">Daftar</p>
    <div class="borang-grid">
      <label for="id-pembeli">ID Pembeli</label>
      <input required type="text"
             name="idPembeli" placeholder="P001" 
             pattern="[A-Z0-9]{4}"
             oninvalid="this.setCustomValidity('Sila masukkan 4 aksara')"
             oninput="this.setCustomValidity('')"/>
    </div>
    <div class="borang-grid">
      <label for="nama-pembeli">Nama Pembeli</label>
      <input type="text" placeholder="John Doe" name="namaPembeli" required/>
    </div>
    <div class="borang-grid">
      <label for="kata-laluan">Kata Laluan</label>
      <input type="text" placeholder="1234" name="password" required/>
    </div>
    <div class="borang-grid">
      <label for="no-tel">Nombor Telefon</label>
      <input type="tel" placeholder="010-1234567" name="telPembeli" required/>
    </div>
    <div class="borang-flexbox">
      <button class="borang-button" type="submit" name="submit">Daftar</button>
    </div>
    <hr class="borang-hr" />
    <p class="borang-p">
      Sudah ada akaun? <a href="index.php">Log Masuk</a>
    </p>
</form>
</body>


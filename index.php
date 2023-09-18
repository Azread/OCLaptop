<?php
session_start();
include("sambungan.php");

if (isset($_POST["submit"])) {
    // Dapatkan nilai dari borang log masuk
    $userid = $_POST["userid"];
    $password = $_POST["password"];
    $jumpa = FALSE;

    // Semak jika pengguna adalah pembeli
    $sql = "SELECT * FROM pembeli";
    $result = mysqli_query($sambungan, $sql);
    while ($pembeli = mysqli_fetch_array($result)) {
        if ($pembeli["idPembeli"] == $userid && $pembeli["password"] == $password) {
            $jumpa = TRUE;
            // Tetapkan maklumat pengguna ke sesi
            $_SESSION["idPengguna"] = $pembeli["idPembeli"];
            $_SESSION["nama"] = $pembeli["namaPembeli"];
            $_SESSION["status"] = "pembeli";
            break;
        }
    }

    // Semak jika pengguna adalah penjual jika bukan pembeli
    if (!$jumpa) {
        $sql = "SELECT * FROM penjual";
        $result = mysqli_query($sambungan, $sql);
        while ($penjual = mysqli_fetch_array($result)) {
            if ($penjual["idPenjual"] == $userid && $penjual["password"] == $password) {
                $jumpa = TRUE;
                // Tetapkan maklumat pengguna ke sesi
                $_SESSION["idPengguna"] = $penjual["idPenjual"];
                $_SESSION["nama"] = $penjual["namaPenjual"];
                $_SESSION["status"] = "penjual";
                break;
            }
        }
    }

    // Jika maklumat pengguna ditemui, alihkan ke halaman yang betul berdasarkan status
    if ($jumpa) {
        if ($_SESSION["status"] == "pembeli") {
            header("Location: pembeli_home.php");
        } elseif ($_SESSION["status"] == "penjual") {
            header("Location: penjual_home.php");
        }
    } else {
        // Jika maklumat pengguna tidak sah, paparkan mesej ralat dan alihkan semula ke halaman log masuk
        echo "<script>
            alert('Kesalahan pada username atau password');
            window.location='index.php';
        </script>";
    }
}
?>

<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="css/borang.css">
<img src="imej/logo.png" class="title-logo">
<form class="borang" action="index.php" method="post">
    <p class="title">Log Masuk</p>
    <div class="borang-grid">
        <label for="id-pengguna">ID Pengguna</label>
        <input type="text" name="userid" placeholder="ID Pengguna" />
    </div>
    <div class="borang-grid">
        <label for="kata-laluan">Kata Laluan</label>
        <input type="password" name="password" placeholder="Kata Laluan" />
    </div>
    <div class="borang-flexbox">
        <button class="borang-button" type="submit" name="submit">Log Masuk</button>
    </div>
    <hr class="borang-hr" />
    <p class="borang-p">Tak ada akaun? <a href="signup.php">Daftar</a></p>
</form>


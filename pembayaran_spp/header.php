<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

?>

<!doctype html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Pembayaran SPP</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container-fluid">

    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 bg-primary min-vh-100 p-3">

            <h4 class="text-white text-center mb-4">
                SPP Sekolah
            </h4>

            <div class="text-white text-center mb-3">

                <strong>
                    <?= $_SESSION['nama'] ?>
                </strong>

                <br>

                <small>
                    <?= ucfirst($_SESSION['level']) ?>
                </small>

            </div>

            <hr class="text-white">

            <div class="nav flex-column nav-pills">

                <a href="dashboard.php"
                   class="nav-link text-white mb-2">
                    Dashboard
                </a>

                <a href="siswa.php"
                   class="nav-link text-white mb-2">
                    Data Siswa
                </a>

                <a href="petugas.php"
                   class="nav-link text-white mb-2">
                    Data Petugas
                </a>

                <a href="pembayaran.php"
                   class="nav-link text-white mb-2">
                    Pembayaran
                </a>

                <a href="cek_pembayaran.php"
                   class="nav-link text-white mb-2">
                    Cek Pembayaran
                </a>

                <hr class="text-white">

                <a href="logout.php"
                   class="nav-link text-white">
                    Logout
                </a>

            </div>

        </div>

        <!-- KONTEN UTAMA -->
        <div class="col-md-10 p-4">
<?php

session_start();

include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_user
    WHERE username='$username'
    AND password='$password'"
);

$user = mysqli_fetch_assoc($query);

if ($user) {

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['level'] = $user['level'];

    header("Location: dashboard.php");
    exit;

} else {

    header("Location: login.php?pesan=gagal");
    exit;

}
?>
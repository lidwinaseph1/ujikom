<?php
include '../koneksi.php';

$aksi = $_POST['aksi'];

if ($aksi == 'tambah') {

    $id_petugas = $_POST['id_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];

    mysqli_query($koneksi, "
        INSERT INTO tb_petugas
        (id_petugas, username, password, nama_petugas, level)
        VALUES
        ('$id_petugas', '$username', '$password', '$nama_petugas', '$level')
    ");

    header("Location: ../petugas.php");
    exit;
}


if ($aksi == 'edit') {

    $id_petugas = $_POST['id_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];

    mysqli_query($koneksi, "
        UPDATE tb_petugas SET
            username='$username',
            password='$password',
            nama_petugas='$nama_petugas',
            level='$level'
        WHERE id_petugas='$id_petugas'
    ");

    header("Location: ../petugas.php");
    exit;
}


if ($aksi == 'hapus') {

    $id_petugas = $_POST['id_petugas'];

    mysqli_query(
        $koneksi,
        "DELETE FROM tb_petugas WHERE id_petugas='$id_petugas'"
    );

    header("Location: ../petugas.php");
    exit;
}
?>
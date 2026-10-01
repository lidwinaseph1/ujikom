<?php

include '../koneksi.php';

$aksi = $_POST['aksi'];

if ($aksi == 'tambah') {

    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $id_spp = $_POST['id_spp'];

    $kelas = mysqli_query(
        $koneksi,
        "SELECT nama_kelas FROM tb_kelas WHERE id_kelas='$id_kelas'"
    );

    $data_kelas = mysqli_fetch_assoc($kelas);
    $nama_kelas = $data_kelas['nama_kelas'];

    mysqli_query($koneksi, "
        INSERT INTO tb_siswa
        (nisn, nis, nama, id_kelas, nama_kelas, alamat, no_telp, id_spp)
        VALUES
        ('$nisn', '$nis', '$nama', '$id_kelas', '$nama_kelas', '$alamat', '$no_telp', '$id_spp')
    ");

    header("Location: ../siswa.php");
}


if ($aksi == 'edit') {

    $nisn_lama = $_POST['nisn_lama'];

    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $id_spp = $_POST['id_spp'];

    $kelas = mysqli_query(
        $koneksi,
        "SELECT nama_kelas FROM tb_kelas WHERE id_kelas='$id_kelas'"
    );

    $data_kelas = mysqli_fetch_assoc($kelas);
    $nama_kelas = $data_kelas['nama_kelas'];

    mysqli_query($koneksi, "
        UPDATE tb_siswa SET
            nisn='$nisn',
            nis='$nis',
            nama='$nama',
            id_kelas='$id_kelas',
            nama_kelas='$nama_kelas',
            alamat='$alamat',
            no_telp='$no_telp',
            id_spp='$id_spp'
        WHERE nisn='$nisn_lama'
    ");

    header("Location: ../siswa.php");
}


if ($aksi == 'hapus') {

    $nisn = $_POST['nisn'];

    mysqli_query(
        $koneksi,
        "DELETE FROM tb_siswa WHERE nisn='$nisn'"
    );

    header("Location: ../siswa.php");
}
?>
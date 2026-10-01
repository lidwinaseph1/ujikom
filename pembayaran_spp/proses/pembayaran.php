<?php

include '../koneksi.php';

$aksi = $_POST['aksi'];

if ($aksi == 'tambah') {

    $id_pembayaran = $_POST['id_pembayaran'];
    $nisn = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $jumlah_bulan = $_POST['jumlah_bulan'];
    $nominal_bayar = $_POST['nominal_bayar'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $status = $_POST['status'];

    $data_siswa = mysqli_query(
        $koneksi,
        "SELECT id_spp FROM tb_siswa WHERE nisn='$nisn'"
    );

    $siswa = mysqli_fetch_assoc($data_siswa);
    $id_spp = $siswa['id_spp'];

    $kembalian = $jumlah_bayar - $nominal_bayar;

    $tgl_terakhir_bayar = $tgl_bayar;
    $batas_pembayaran = date('Y-m-d', strtotime($tgl_bayar . ' +1 month'));

    mysqli_query($koneksi, "
        INSERT INTO tb_pembayaran
        (
            id_pembayaran,
            status,
            nisn,
            tgl_bayar,
            tgl_terakhir_bayar,
            batas_pembayaran,
            jumlah_bulan,
            id_spp,
            nominal_bayar,
            jumlah_bayar,
            kembalian
        )
        VALUES
        (
            '$id_pembayaran',
            '$status',
            '$nisn',
            '$tgl_bayar',
            '$tgl_terakhir_bayar',
            '$batas_pembayaran',
            '$jumlah_bulan',
            '$id_spp',
            '$nominal_bayar',
            '$jumlah_bayar',
            '$kembalian'
        )
    ");

    header("Location: ../pembayaran.php");
    exit;
}


if ($aksi == 'edit') {

    $id_pembayaran = $_POST['id_pembayaran'];
    $nisn = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $jumlah_bulan = $_POST['jumlah_bulan'];
    $nominal_bayar = $_POST['nominal_bayar'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $status = $_POST['status'];

    $data_siswa = mysqli_query(
        $koneksi,
        "SELECT id_spp FROM tb_siswa WHERE nisn='$nisn'"
    );

    $siswa = mysqli_fetch_assoc($data_siswa);
    $id_spp = $siswa['id_spp'];

    $kembalian = $jumlah_bayar - $nominal_bayar;

    $tgl_terakhir_bayar = $tgl_bayar;
    $batas_pembayaran = date('Y-m-d', strtotime($tgl_bayar . ' +1 month'));

    mysqli_query($koneksi, "
        UPDATE tb_pembayaran SET
            nisn='$nisn',
            tgl_bayar='$tgl_bayar',
            tgl_terakhir_bayar='$tgl_terakhir_bayar',
            batas_pembayaran='$batas_pembayaran',
            jumlah_bulan='$jumlah_bulan',
            id_spp='$id_spp',
            nominal_bayar='$nominal_bayar',
            jumlah_bayar='$jumlah_bayar',
            kembalian='$kembalian',
            status='$status'
        WHERE id_pembayaran='$id_pembayaran'
    ");

    header("Location: ../pembayaran.php");
    exit;
}


if ($aksi == 'hapus') {

    $id_pembayaran = $_POST['id_pembayaran'];

    mysqli_query(
        $koneksi,
        "DELETE FROM tb_pembayaran WHERE id_pembayaran='$id_pembayaran'"
    );

    header("Location: ../pembayaran.php");
    exit;
}
?>
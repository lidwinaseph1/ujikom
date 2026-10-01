<?php

include '../koneksi.php';

$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : '';

if ($aksi == '') {
    header("Location: ../pembayaran.php");
    exit;
}

if ($aksi == 'tambah') {

    $id_pembayaran = $_POST['id_pembayaran'];
    $nisn = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];

    $jumlah_bulan =
        (int) $_POST['jumlah_bulan'];

    $uang_bayar =
        (int) $_POST['nominal_bayar'];


    // Ambil id_spp dan nominal SPP siswa
    $query = mysqli_query($koneksi, "

        SELECT
            tb_siswa.id_spp,
            tb_spp.nominal

        FROM tb_siswa

        JOIN tb_spp
            ON tb_siswa.id_spp = tb_spp.id_spp

        WHERE tb_siswa.nisn = '$nisn'

    ");


    $data = mysqli_fetch_assoc($query);


    $id_spp = $data['id_spp'];

    $nominal_spp =
        (int) $data['nominal'];


    // Hitung total tagihan
    $total_tagihan =
        $nominal_spp * $jumlah_bulan;


    // Tentukan status
    if ($uang_bayar >= $total_tagihan) {

        $status = 'Sudah Lunas';

        $kembalian =
            $uang_bayar - $total_tagihan;

    } else {

        $status = 'Belum Lunas';

        $kembalian = 0;
    }


    // Simpan pembayaran
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
            '$tgl_bayar',
            '$tgl_bayar',
            '$jumlah_bulan',
            '$id_spp',
            '$uang_bayar',
            '$total_tagihan',
            '$kembalian'
        )

    ");


    header(
        "Location: ../pembayaran.php"
    );

    exit;
}

?>
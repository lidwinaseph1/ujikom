<?php
include 'koneksi.php';
include 'header.php';

// Total siswa
$total_siswa = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM tb_siswa")
);

// Total petugas
$total_petugas = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM tb_petugas")
);

// Total transaksi
$total_transaksi = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM tb_pembayaran")
);

// Jumlah siswa yang sudah lunas
$query_lunas = mysqli_query($koneksi, "
    SELECT COUNT(DISTINCT nisn) AS total
    FROM tb_pembayaran
    WHERE status = 'Sudah Lunas'
");

$data_lunas = mysqli_fetch_assoc($query_lunas);

$sudah_lunas = $data_lunas['total'];

// Jumlah siswa yang belum lunas
$belum_lunas = $total_siswa - $sudah_lunas;


// Transaksi terbaru
$transaksi_terbaru = mysqli_query($koneksi, "
    SELECT 
        tb_pembayaran.id_pembayaran,
        tb_pembayaran.tgl_bayar,
        tb_pembayaran.jumlah_bayar,
        tb_pembayaran.status,
        tb_siswa.nama
    FROM tb_pembayaran
    JOIN tb_siswa
        ON tb_pembayaran.nisn = tb_siswa.nisn
    ORDER BY tb_pembayaran.tgl_bayar DESC
    LIMIT 5
");
?>

<!-- HEADER DASHBOARD -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Dashboard</h3>

        <p class="text-muted mb-0">
            Ringkasan data pembayaran SPP
        </p>
    </div>

    <span class="badge bg-primary fs-6 px-3 py-2">
        Sistem Pembayaran SPP
    </span>

</div>


<!-- CARD STATISTIK -->
<div class="row g-4 mb-4">

    <!-- TOTAL SISWA -->
    <div class="col-md-6 col-lg-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-1">
                            Total Siswa
                        </p>

                        <h2 class="fw-bold mb-0 text-primary">
                            <?= $total_siswa ?>
                        </h2>

                    </div>

                    <div class="bg-primary text-white rounded-circle px-3 py-2 fs-4">
                        👨‍🎓
                    </div>

                </div>

                <hr>

                <a href="siswa.php" class="text-decoration-none">
                    Lihat data siswa →
                </a>

            </div>

        </div>

    </div>


    <!-- TOTAL PETUGAS -->
    <div class="col-md-6 col-lg-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-1">
                            Total Petugas
                        </p>

                        <h2 class="fw-bold mb-0 text-warning">
                            <?= $total_petugas ?>
                        </h2>

                    </div>

                    <div class="bg-warning text-dark rounded-circle px-3 py-2 fs-4">
                        👤
                    </div>

                </div>

                <hr>

                <a href="petugas.php" class="text-decoration-none">
                    Lihat data petugas →
                </a>

            </div>

        </div>

    </div>


    <!-- SUDAH LUNAS -->
    <div class="col-md-6 col-lg-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-1">
                            Siswa Sudah Lunas
                        </p>

                        <h2 class="fw-bold mb-0 text-success">
                            <?= $sudah_lunas ?>
                        </h2>

                    </div>

                    <div class="bg-success text-white rounded-circle px-3 py-2 fs-4">
                        ✓
                    </div>

                </div>

                <hr>

                <a href="cek_pembayaran.php" class="text-decoration-none">
                    Lihat pembayaran →
                </a>

            </div>

        </div>

    </div>


    <!-- BELUM LUNAS -->
    <div class="col-md-6 col-lg-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <p class="text-muted mb-1">
                            Siswa Belum Lunas
                        </p>

                        <h2 class="fw-bold mb-0 text-danger">
                            <?= $belum_lunas ?>
                        </h2>

                    </div>

                    <div class="bg-danger text-white rounded-circle px-3 py-2 fs-4">
                        !
                    </div>

                </div>

                <hr>

                <small class="text-muted">
                    Dari total <?= $total_siswa ?> siswa
                </small>

            </div>

        </div>

    </div>

</div>


<!-- INFORMASI SINGKAT -->
<div class="row g-4 mb-4">

    <div class="col-md-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h5 class="mb-3">
                    Ringkasan Sistem
                </h5>

                <p class="text-muted">
                    Sistem ini digunakan untuk mengelola data siswa,
                    petugas, transaksi pembayaran SPP, serta pengecekan
                    status pembayaran siswa.
                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="siswa.php" class="btn btn-outline-primary">
                        Data Siswa
                    </a>

                    <a href="pembayaran.php" class="btn btn-outline-success">
                        Pembayaran
                    </a>

                    <a href="cek_pembayaran.php" class="btn btn-outline-warning">
                        Cek Pembayaran
                    </a>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h5 class="mb-3">
                    Status Pembayaran
                </h5>

                <div class="mb-3">

                    <div class="d-flex justify-content-between">

                        <span>
                            Sudah Lunas
                        </span>

                        <strong class="text-success">
                            <?= $sudah_lunas ?>
                        </strong>

                    </div>

                </div>

                <div>

                    <div class="d-flex justify-content-between">

                        <span>
                            Belum Lunas
                        </span>

                        <strong class="text-danger">
                            <?= $belum_lunas ?>
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- TRANSAKSI TERBARU -->
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-0">
                    Transaksi Terbaru
                </h5>

                <small class="text-muted">
                    5 transaksi pembayaran terakhir
                </small>

            </div>

            <a href="pembayaran.php" class="btn btn-sm btn-primary">
                Lihat Semua
            </a>

        </div>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th>No</th>
                        <th>ID Pembayaran</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                if (mysqli_num_rows($transaksi_terbaru) > 0) {

                    while ($row = mysqli_fetch_assoc($transaksi_terbaru)) {
                ?>

                    <tr>

                        <td>
                            <?= $no++ ?>
                        </td>

                        <td>
                            <span class="fw-semibold">
                                <?= $row['id_pembayaran'] ?>
                            </span>
                        </td>

                        <td>
                            <?= $row['nama'] ?>
                        </td>

                        <td>
                            <?= date(
                                'd-m-Y',
                                strtotime($row['tgl_bayar'])
                            ) ?>
                        </td>

                        <td class="fw-semibold">
                            Rp <?= number_format(
                                $row['jumlah_bayar'],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>

                            <?php if ($row['status'] == 'Sudah Lunas') { ?>

                                <span class="badge rounded-pill bg-success">
                                    Sudah Lunas
                                </span>

                            <?php } else { ?>

                                <span class="badge rounded-pill bg-danger">
                                    Belum Lunas
                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                <?php
                    }

                } else {
                ?>

                    <tr>

                        <td colspan="6" class="text-center py-4 text-muted">
                            Belum ada transaksi pembayaran
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>
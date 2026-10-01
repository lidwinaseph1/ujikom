<?php
include 'koneksi.php';
include 'header.php';

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$query = "
    SELECT 
        tb_pembayaran.*,
        tb_siswa.nama,
        tb_siswa.nis,
        tb_siswa.nama_kelas
    FROM tb_pembayaran
    JOIN tb_siswa 
        ON tb_pembayaran.nisn = tb_siswa.nisn
";

if ($cari != '') {
    $query .= "
        WHERE tb_siswa.nisn LIKE '%$cari%'
        OR tb_siswa.nama LIKE '%$cari%'
    ";
}

$query .= " ORDER BY tb_pembayaran.tgl_bayar DESC";

$data = mysqli_query($koneksi, $query);
?>

<h3 class="mb-4">Cek Pembayaran</h3>

<!-- FORM PENCARIAN -->
<div class="card mb-4">
    <div class="card-body">

        <form method="GET" class="row g-2">

            <div class="col-md-9">
                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="Cari NISN atau nama siswa..."
                    value="<?= $cari ?>"
                >
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="cek_pembayaran.php" class="btn btn-secondary">
                    Reset
                </a>
            </div>

        </form>

    </div>
</div>


<!-- TABEL PEMBAYARAN -->
<div class="card">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    if (mysqli_num_rows($data) > 0) {

                        while ($row = mysqli_fetch_assoc($data)) {
                    ?>

                    <tr>
                        <td><?= $no++ ?></td>

                        <td>
                            <?= $row['nisn'] ?>
                        </td>

                        <td>
                            <?= $row['nama'] ?>
                        </td>

                        <td>
                            <?= $row['nama_kelas'] ?>
                        </td>

                        <td>
                            <?= $row['tgl_bayar'] ?>
                        </td>

                        <td>
                            Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?>
                        </td>

                        <td>

                            <?php if ($row['status'] == 'Sudah Lunas') { ?>

                                <span class="badge bg-success">
                                    Sudah Lunas
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-danger">
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
                        <td colspan="7" class="text-center">
                            Data pembayaran tidak ditemukan
                        </td>
                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
<?php
include 'koneksi.php';
include 'header.php';

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$query = "
    SELECT
        s.nisn,
        s.nama,
        s.nama_kelas,
        spp.nominal AS nominal_spp,

        p.tgl_bayar,
        p.jumlah_bayar,
        p.nominal_bayar,
        p.status

    FROM tb_siswa s

    JOIN tb_spp spp
        ON s.id_spp = spp.id_spp

    LEFT JOIN tb_pembayaran p
        ON s.nisn = p.nisn
";

if ($cari != '') {

    $query .= "
        WHERE
        s.nisn LIKE '%$cari%'
        OR s.nama LIKE '%$cari%'
    ";
}

$query .= "
    ORDER BY s.nama ASC
";

$data = mysqli_query($koneksi, $query);
?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">Cek Pembayaran</h3>

        <p class="text-muted mb-0">
            Status pembayaran SPP siswa
        </p>
    </div>

</div>


<!-- PENCARIAN -->
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET" class="row g-2">

            <div class="col-md-9">

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="Cari NISN atau nama siswa..."
                    value="<?= htmlspecialchars($cari) ?>"
                >

            </div>

            <div class="col-md-3">

                <button
                    type="submit"
                    class="btn btn-primary">
                    Cari
                </button>

                <a
                    href="cek_pembayaran.php"
                    class="btn btn-secondary">
                    Reset
                </a>

            </div>

        </form>

    </div>

</div>


<!-- TABEL -->
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-warning">

                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Total Tagihan</th>
                        <th>Sudah Dibayar</th>
                        <th>Sisa Tagihan</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                if (mysqli_num_rows($data) > 0) {

                    while ($row = mysqli_fetch_assoc($data)) {

                        // Jika belum pernah bayar
                        if ($row['jumlah_bayar'] == null) {

                            $total_tagihan = $row['nominal_spp'];
                            $sudah_dibayar = 0;
                            $sisa_tagihan = $row['nominal_spp'];
                            $status = 'Belum Lunas';

                        } else {

                            $total_tagihan = $row['jumlah_bayar'];
                            $sudah_dibayar = $row['nominal_bayar'];

                            $sisa_tagihan =
                                $total_tagihan - $sudah_dibayar;

                            if ($sisa_tagihan < 0) {
                                $sisa_tagihan = 0;
                            }

                            $status = $row['status'];
                        }
                ?>

                    <tr>

                        <td>
                            <?= $no++ ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nisn']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nama']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nama_kelas']) ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $total_tagihan,
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $sudah_dibayar,
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>

                            <?php if ($status == 'Belum Lunas') { ?>

                                <span class="text-danger fw-bold">

                                    Rp <?= number_format(
                                        $sisa_tagihan,
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </span>

                            <?php } else { ?>

                                <span class="text-success fw-bold">
                                    Rp 0
                                </span>

                            <?php } ?>

                        </td>

                        <td>

                            <?php if ($status == 'Sudah Lunas') { ?>

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

                        <td
                            colspan="8"
                            class="text-center py-4 text-muted">

                            Data siswa tidak ditemukan

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>
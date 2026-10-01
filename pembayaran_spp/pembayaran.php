<?php
include 'koneksi.php';
include 'header.php';

// Ambil data pembayaran
$data = mysqli_query($koneksi, "
    SELECT 
        p.*,
        s.nama
    FROM tb_pembayaran p
    JOIN tb_siswa s ON p.nisn = s.nisn
    ORDER BY p.tgl_bayar DESC
");

// Ambil data siswa untuk dropdown
$siswa = mysqli_query($koneksi, "
    SELECT 
        s.nisn,
        s.nama,
        spp.nominal
    FROM tb_siswa s
    JOIN tb_spp spp ON s.id_spp = spp.id_spp
    ORDER BY s.nama ASC
");
?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="mb-1">Pembayaran SPP</h3>
        <p class="text-muted mb-0">
            Kelola transaksi pembayaran siswa
        </p>
    </div>

    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalTambah">
        + Tambah Pembayaran
    </button>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead class="table-success">

                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Jumlah Bulan</th>
                        <th>Total Tagihan</th>
                        <th>Uang Bayar</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while ($row = mysqli_fetch_assoc($data)) {
                ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td>
                            <?= $row['id_pembayaran'] ?>
                        </td>

                        <td>
                            <?= $row['nama'] ?>
                        </td>

                        <td>
                            <?= $row['tgl_bayar'] ?>
                        </td>

                        <td>
                            <?= $row['jumlah_bulan'] ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $row['jumlah_bayar'],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $row['nominal_bayar'],
                                0,
                                ',',
                                '.'
                            ) ?>
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

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="proses/pembayaran.php"
                method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Pembayaran
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="aksi"
                        value="tambah">


                    <div class="mb-3">

                        <label class="form-label">
                            ID Pembayaran
                        </label>

                        <input
                            type="text"
                            name="id_pembayaran"
                            class="form-control"
                            required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Siswa
                        </label>

                        <select
                            name="nisn"
                            id="nisn"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih Siswa
                            </option>

                            <?php
                            mysqli_data_seek($siswa, 0);

                            while ($s = mysqli_fetch_assoc($siswa)) {
                            ?>

                                <option
                                    value="<?= $s['nisn'] ?>"
                                    data-nominal="<?= $s['nominal'] ?>">

                                    <?= $s['nisn'] ?>
                                    -
                                    <?= $s['nama'] ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Nominal SPP / Bulan
                        </label>

                        <input
                            type="number"
                            id="nominal_spp"
                            class="form-control"
                            readonly>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Jumlah Bulan
                        </label>

                        <input
                            type="number"
                            name="jumlah_bulan"
                            id="jumlah_bulan"
                            class="form-control"
                            value="1"
                            min="1"
                            required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Total Tagihan
                        </label>

                        <input
                            type="number"
                            id="total_tagihan"
                            class="form-control"
                            readonly>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Uang Dibayar
                        </label>

                        <input
                            type="number"
                            name="nominal_bayar"
                            class="form-control"
                            required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Bayar
                        </label>

                        <input
                            type="date"
                            name="tgl_bayar"
                            class="form-control"
                            required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

const siswaSelect = document.getElementById('nisn');
const nominalSpp = document.getElementById('nominal_spp');
const jumlahBulan = document.getElementById('jumlah_bulan');
const totalTagihan = document.getElementById('total_tagihan');

function hitungTagihan() {

    const option =
        siswaSelect.options[siswaSelect.selectedIndex];

    const nominal =
        parseInt(option.getAttribute('data-nominal')) || 0;

    const bulan =
        parseInt(jumlahBulan.value) || 0;

    nominalSpp.value = nominal;

    totalTagihan.value =
        nominal * bulan;
}

siswaSelect.addEventListener(
    'change',
    hitungTagihan
);

jumlahBulan.addEventListener(
    'input',
    hitungTagihan
);

</script>


<?php include 'footer.php'; ?>
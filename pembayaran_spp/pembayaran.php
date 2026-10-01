<?php
include 'koneksi.php';
include 'header.php';

$data = mysqli_query($koneksi, "
    SELECT tb_pembayaran.*, tb_siswa.nama
    FROM tb_pembayaran
    JOIN tb_siswa ON tb_pembayaran.nisn = tb_siswa.nisn
    ORDER BY tb_pembayaran.tgl_bayar DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Pembayaran</h3>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Pembayaran
    </button>
</div>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Bayar</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($data)) {
                ?>

                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['id_pembayaran'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['tgl_bayar'] ?></td>
                    <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>

                        <button
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit<?= $row['id_pembayaran'] ?>">
                            Edit
                        </button>

                        <button
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalHapus<?= $row['id_pembayaran'] ?>">
                            Hapus
                        </button>

                    </td>
                </tr>


                <!-- MODAL EDIT -->
                <div class="modal fade" id="modalEdit<?= $row['id_pembayaran'] ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form action="proses/pembayaran.php" method="POST">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden" name="aksi" value="edit">
                                    <input type="hidden" name="id_pembayaran" value="<?= $row['id_pembayaran'] ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Siswa</label>

                                        <select name="nisn" class="form-select" required>

                                            <?php
                                            $siswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa");

                                            while ($s = mysqli_fetch_assoc($siswa)) {
                                            ?>
                                                <option value="<?= $s['nisn'] ?>"
                                                    <?= $s['nisn'] == $row['nisn'] ? 'selected' : '' ?>>

                                                    <?= $s['nisn'] ?> - <?= $s['nama'] ?>

                                                </option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Bayar</label>
                                        <input type="date" name="tgl_bayar" class="form-control"
                                            value="<?= $row['tgl_bayar'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Bulan</label>
                                        <input type="number" name="jumlah_bulan" class="form-control"
                                            value="<?= $row['jumlah_bulan'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nominal Bayar</label>
                                        <input type="number" name="nominal_bayar" class="form-control"
                                            value="<?= $row['nominal_bayar'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Bayar</label>
                                        <input type="number" name="jumlah_bayar" class="form-control"
                                            value="<?= $row['jumlah_bayar'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>

                                        <select name="status" class="form-select">
                                            <option value="Sudah Lunas"
                                                <?= $row['status'] == 'Sudah Lunas' ? 'selected' : '' ?>>
                                                Sudah Lunas
                                            </option>

                                            <option value="Belum Lunas"
                                                <?= $row['status'] == 'Belum Lunas' ? 'selected' : '' ?>>
                                                Belum Lunas
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        Simpan
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>


                <!-- MODAL HAPUS -->
                <div class="modal fade" id="modalHapus<?= $row['id_pembayaran'] ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form action="proses/pembayaran.php" method="POST">

                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden" name="aksi" value="hapus">
                                    <input type="hidden" name="id_pembayaran"
                                        value="<?= $row['id_pembayaran'] ?>">

                                    Yakin ingin menghapus pembayaran
                                    <strong><?= $row['id_pembayaran'] ?></strong>?

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>

                                    <button type="submit" class="btn btn-danger">
                                        Hapus
                                    </button>

                                </div>

                            </form>

                        </div>
                    </div>
                </div>

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

            <form action="proses/pembayaran.php" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="aksi" value="tambah">

                    <div class="mb-3">
                        <label class="form-label">ID Pembayaran</label>
                        <input type="text" name="id_pembayaran" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Siswa</label>

                        <select name="nisn" class="form-select" required>

                            <option value="">Pilih Siswa</option>

                            <?php
                            $siswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa");

                            while ($s = mysqli_fetch_assoc($siswa)) {
                            ?>
                                <option value="<?= $s['nisn'] ?>">
                                    <?= $s['nisn'] ?> - <?= $s['nama'] ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tgl_bayar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bulan</label>
                        <input type="number" name="jumlah_bulan" class="form-control" value="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nominal Bayar</label>
                        <input type="number" name="nominal_bayar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">
                            <option value="Sudah Lunas">Sudah Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
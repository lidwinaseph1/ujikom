<?php
include 'koneksi.php';
include 'header.php';

$data = mysqli_query($koneksi, "
    SELECT tb_siswa.*, tb_kelas.nama_kelas
    FROM tb_siswa
    JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas
");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Siswa</h3>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Siswa
    </button>
</div>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>No. Telp</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($data)) {
                ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nisn'] ?></td>
                        <td><?= $row['nis'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['no_telp'] ?></td>

                        <td>
                            <button
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit<?= $row['nisn'] ?>">
                                Edit
                            </button>

                            <button
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapus<?= $row['nisn'] ?>">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <!-- MODAL EDIT -->
                    <div class="modal fade" id="modalEdit<?= $row['nisn'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="proses/siswa.php" method="POST">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <input type="hidden" name="aksi" value="edit">
                                        <input type="hidden" name="nisn_lama" value="<?= $row['nisn'] ?>">

                                        <div class="mb-3">
                                            <label class="form-label">NISN</label>
                                            <input type="text" name="nisn" class="form-control"
                                                value="<?= $row['nisn'] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">NIS</label>
                                            <input type="text" name="nis" class="form-control"
                                                value="<?= $row['nis'] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="nama" class="form-control"
                                                value="<?= $row['nama'] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Kelas</label>

                                            <select name="id_kelas" class="form-select" required>

                                                <?php
                                                $kelas = mysqli_query($koneksi, "SELECT * FROM tb_kelas");

                                                while ($k = mysqli_fetch_assoc($kelas)) {
                                                ?>
                                                    <option
                                                        value="<?= $k['id_kelas'] ?>"
                                                        <?= $k['id_kelas'] == $row['id_kelas'] ? 'selected' : '' ?>>

                                                        <?= $k['nama_kelas'] ?>

                                                    </option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea name="alamat" class="form-control"><?= $row['alamat'] ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">No Telp</label>
                                            <input type="text" name="no_telp" class="form-control"
                                                value="<?= $row['no_telp'] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">SPP</label>

                                            <select name="id_spp" class="form-select" required>

                                                <?php
                                                $spp = mysqli_query($koneksi, "SELECT * FROM tb_spp");

                                                while ($s = mysqli_fetch_assoc($spp)) {
                                                ?>
                                                    <option
                                                        value="<?= $s['id_spp'] ?>"
                                                        <?= $s['id_spp'] == $row['id_spp'] ? 'selected' : '' ?>>

                                                        <?= $s['id_spp'] ?> - Rp <?= $s['nominal'] ?>

                                                    </option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>

                                        <button class="btn btn-primary" type="submit">
                                            Simpan
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- MODAL HAPUS -->
                    <div class="modal fade" id="modalHapus<?= $row['nisn'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="proses/siswa.php" method="POST">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Siswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <input type="hidden" name="aksi" value="hapus">
                                        <input type="hidden" name="nisn" value="<?= $row['nisn'] ?>">

                                        Yakin ingin menghapus
                                        <strong><?= $row['nama'] ?></strong>?

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

            <form action="proses/siswa.php" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="aksi" value="tambah">

                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>

                        <select name="id_kelas" class="form-select" required>

                            <option value="">Pilih Kelas</option>

                            <?php
                            $kelas = mysqli_query($koneksi, "SELECT * FROM tb_kelas");

                            while ($k = mysqli_fetch_assoc($kelas)) {
                            ?>
                                <option value="<?= $k['id_kelas'] ?>">
                                    <?= $k['nama_kelas'] ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" name="no_telp" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SPP</label>

                        <select name="id_spp" class="form-select" required>

                            <option value="">Pilih SPP</option>

                            <?php
                            $spp = mysqli_query($koneksi, "SELECT * FROM tb_spp");

                            while ($s = mysqli_fetch_assoc($spp)) {
                            ?>
                                <option value="<?= $s['id_spp'] ?>">
                                    <?= $s['id_spp'] ?> - Rp <?= $s['nominal'] ?>
                                </option>
                            <?php } ?>

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
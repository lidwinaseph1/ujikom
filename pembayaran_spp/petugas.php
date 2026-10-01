<?php
include 'koneksi.php';
include 'header.php';

$data = mysqli_query($koneksi, "SELECT * FROM tb_petugas");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Petugas</h3>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Petugas
    </button>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Petugas</th>
                    <th>Username</th>
                    <th>Nama Petugas</th>
                    <th>Level</th>
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
                    <td><?= $row['id_petugas'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['nama_petugas'] ?></td>
                    <td><?= $row['level'] ?></td>

                    <td>
                        <button
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#edit<?= $row['id_petugas'] ?>">
                            Edit
                        </button>

                        <button
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#hapus<?= $row['id_petugas'] ?>">
                            Hapus
                        </button>
                    </td>
                </tr>

                <!-- MODAL EDIT -->
                <div class="modal fade" id="edit<?= $row['id_petugas'] ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form action="proses/petugas.php" method="POST">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Petugas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden" name="aksi" value="edit">
                                    <input type="hidden" name="id_petugas" value="<?= $row['id_petugas'] ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control"
                                            value="<?= $row['username'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="text" name="password" class="form-control"
                                            value="<?= $row['password'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nama Petugas</label>
                                        <input type="text" name="nama_petugas" class="form-control"
                                            value="<?= $row['nama_petugas'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Level</label>

                                        <select name="level" class="form-select">
                                            <option value="admin"
                                                <?= $row['level'] == 'admin' ? 'selected' : '' ?>>
                                                Admin
                                            </option>

                                            <option value="petugas"
                                                <?= $row['level'] == 'petugas' ? 'selected' : '' ?>>
                                                Petugas
                                            </option>

                                            <option value="siswa"
                                                <?= $row['level'] == 'siswa' ? 'selected' : '' ?>>
                                                Siswa
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
                <div class="modal fade" id="hapus<?= $row['id_petugas'] ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form action="proses/petugas.php" method="POST">

                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Petugas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <input type="hidden" name="aksi" value="hapus">
                                    <input type="hidden" name="id_petugas" value="<?= $row['id_petugas'] ?>">

                                    Yakin ingin menghapus
                                    <strong><?= $row['nama_petugas'] ?></strong>?

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


<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="proses/petugas.php" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Petugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="aksi" value="tambah">

                    <div class="mb-3">
                        <label class="form-label">ID Petugas</label>
                        <input type="text" name="id_petugas" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Level</label>

                        <select name="level" class="form-select">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="siswa">Siswa</option>
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
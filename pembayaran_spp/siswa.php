<?php

include 'koneksi.php';
include 'header.php';


// ==============================
// AMBIL DATA SISWA
// ==============================

$query_siswa = mysqli_query($koneksi, "
    SELECT 
        tb_siswa.*,
        tb_kelas.nama_kelas AS kelas
    FROM tb_siswa
    LEFT JOIN tb_kelas
        ON tb_siswa.id_kelas = tb_kelas.id_kelas
    ORDER BY tb_siswa.nama ASC
");

$data_siswa = [];

while ($row = mysqli_fetch_assoc($query_siswa)) {
    $data_siswa[] = $row;
}


// ==============================
// AMBIL DATA KELAS
// ==============================

$query_kelas = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_kelas ORDER BY nama_kelas ASC"
);

$data_kelas = [];

while ($kelas = mysqli_fetch_assoc($query_kelas)) {
    $data_kelas[] = $kelas;
}


// ==============================
// AMBIL DATA SPP
// ==============================

$query_spp = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_spp ORDER BY tahun DESC"
);

$data_spp = [];

while ($spp = mysqli_fetch_assoc($query_spp)) {
    $data_spp[] = $spp;
}

?>


<!-- ============================== -->
<!-- POPUP PESAN -->
<!-- ============================== -->

<?php if (isset($_GET['pesan'])) { ?>

    <?php if ($_GET['pesan'] == 'duplikat') { ?>

        <script>
            alert("Data tidak dapat ditambahkan karena NISN sudah terdaftar!");
        </script>

    <?php } elseif ($_GET['pesan'] == 'tambah') { ?>

        <script>
            alert("Data siswa berhasil ditambahkan!");
        </script>

    <?php } elseif ($_GET['pesan'] == 'edit') { ?>

        <script>
            alert("Data siswa berhasil diubah!");
        </script>

    <?php } elseif ($_GET['pesan'] == 'hapus') { ?>

        <script>
            alert("Data siswa berhasil dihapus!");
        </script>

    <?php } ?>

<?php } ?>


<!-- ============================== -->
<!-- HEADER HALAMAN -->
<!-- ============================== -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="mb-1">
            Data Siswa
        </h3>

        <p class="text-muted mb-0">
            Kelola data siswa
        </p>

    </div>


    <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalTambah">

        + Tambah Siswa

    </button>

</div>


<!-- ============================== -->
<!-- TABEL SISWA -->
<!-- ============================== -->

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-primary">

                    <tr>

                        <th>No</th>

                        <th>NISN</th>

                        <th>NIS</th>

                        <th>Nama</th>

                        <th>Kelas</th>

                        <th>Alamat</th>

                        <th>No. Telp</th>

                        <th>SPP</th>

                        <th width="150">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php if (count($data_siswa) > 0) { ?>

                    <?php
                    $no = 1;

                    foreach ($data_siswa as $row) {
                    ?>

                        <tr>

                            <td>
                                <?= $no++ ?>
                            </td>


                            <td>
                                <?= htmlspecialchars($row['nisn']) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars($row['nis']) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars($row['nama']) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars($row['kelas']) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars($row['alamat']) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars($row['no_telp']) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars($row['id_spp']) ?>
                            </td>


                            <td>

                                <button
                                    type="button"
                                    class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit_<?= $row['nisn'] ?>">

                                    Edit

                                </button>


                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHapus_<?= $row['nisn'] ?>">

                                    Hapus

                                </button>

                            </td>

                        </tr>

                    <?php } ?>


                <?php } else { ?>

                    <tr>

                        <td
                            colspan="9"
                            class="text-center py-4 text-muted">

                            Belum ada data siswa

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>



<!-- ============================== -->
<!-- MODAL TAMBAH SISWA -->
<!-- ============================== -->

<div
    class="modal fade"
    id="modalTambah"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="proses/siswa.php"
                method="POST">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Siswa
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


                    <!-- NISN -->
                    <div class="mb-3">

                        <label class="form-label">
                            NISN
                        </label>

                        <input
                            type="text"
                            name="nisn"
                            class="form-control"
                            maxlength="10"
                            required>

                    </div>


                    <!-- NIS -->
                    <div class="mb-3">

                        <label class="form-label">
                            NIS
                        </label>

                        <input
                            type="text"
                            name="nis"
                            class="form-control"
                            maxlength="8"
                            required>

                    </div>


                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nama Siswa
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            required>

                    </div>


                    <!-- KELAS -->
                    <div class="mb-3">

                        <label class="form-label">
                            Kelas
                        </label>

                        <select
                            name="id_kelas"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih Kelas
                            </option>

                            <?php foreach ($data_kelas as $kelas) { ?>

                                <option value="<?= $kelas['id_kelas'] ?>">

                                    <?= htmlspecialchars($kelas['nama_kelas']) ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- ALAMAT -->
                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            rows="3"></textarea>

                    </div>


                    <!-- TELEPON -->
                    <div class="mb-3">

                        <label class="form-label">
                            No. Telepon
                        </label>

                        <input
                            type="text"
                            name="no_telp"
                            class="form-control"
                            maxlength="13">

                    </div>


                    <!-- SPP -->
                    <div class="mb-3">

                        <label class="form-label">
                            SPP
                        </label>

                        <select
                            name="id_spp"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih SPP
                            </option>

                            <?php foreach ($data_spp as $spp) { ?>

                                <option value="<?= $spp['id_spp'] ?>">

                                    <?= htmlspecialchars($spp['tahun']) ?>
                                    -
                                    Rp <?= number_format(
                                        $spp['nominal'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </option>

                            <?php } ?>

                        </select>

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



<!-- ============================== -->
<!-- MODAL EDIT DAN HAPUS -->
<!-- ============================== -->

<?php foreach ($data_siswa as $row) { ?>


<!-- MODAL EDIT -->
<div
    class="modal fade"
    id="modalEdit_<?= $row['nisn'] ?>"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="proses/siswa.php"
                method="POST">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Siswa
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
                        value="edit">

                    <input
                        type="hidden"
                        name="nisn_lama"
                        value="<?= $row['nisn'] ?>">


                    <!-- NISN -->
                    <div class="mb-3">

                        <label class="form-label">
                            NISN
                        </label>

                        <input
                            type="text"
                            name="nisn"
                            class="form-control"
                            maxlength="10"
                            value="<?= htmlspecialchars($row['nisn']) ?>"
                            required>

                    </div>


                    <!-- NIS -->
                    <div class="mb-3">

                        <label class="form-label">
                            NIS
                        </label>

                        <input
                            type="text"
                            name="nis"
                            class="form-control"
                            maxlength="8"
                            value="<?= htmlspecialchars($row['nis']) ?>"
                            required>

                    </div>


                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nama Siswa
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="<?= htmlspecialchars($row['nama']) ?>"
                            required>

                    </div>


                    <!-- KELAS -->
                    <div class="mb-3">

                        <label class="form-label">
                            Kelas
                        </label>

                        <select
                            name="id_kelas"
                            class="form-select"
                            required>

                            <?php foreach ($data_kelas as $kelas) { ?>

                                <option
                                    value="<?= $kelas['id_kelas'] ?>"
                                    <?= $kelas['id_kelas'] == $row['id_kelas']
                                        ? 'selected'
                                        : '' ?>>

                                    <?= htmlspecialchars($kelas['nama_kelas']) ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- ALAMAT -->
                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            rows="3"><?= htmlspecialchars($row['alamat']) ?></textarea>

                    </div>


                    <!-- TELEPON -->
                    <div class="mb-3">

                        <label class="form-label">
                            No. Telepon
                        </label>

                        <input
                            type="text"
                            name="no_telp"
                            class="form-control"
                            maxlength="13"
                            value="<?= htmlspecialchars($row['no_telp']) ?>">

                    </div>


                    <!-- SPP -->
                    <div class="mb-3">

                        <label class="form-label">
                            SPP
                        </label>

                        <select
                            name="id_spp"
                            class="form-select"
                            required>

                            <?php foreach ($data_spp as $spp) { ?>

                                <option
                                    value="<?= $spp['id_spp'] ?>"
                                    <?= $spp['id_spp'] == $row['id_spp']
                                        ? 'selected'
                                        : '' ?>>

                                    <?= htmlspecialchars($spp['tahun']) ?>

                                    -

                                    Rp <?= number_format(
                                        $spp['nominal'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </option>

                            <?php } ?>

                        </select>

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

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- MODAL HAPUS -->
<div
    class="modal fade"
    id="modalHapus_<?= $row['nisn'] ?>"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="proses/siswa.php"
                method="POST">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Hapus Siswa
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
                        value="hapus">

                    <input
                        type="hidden"
                        name="nisn"
                        value="<?= $row['nisn'] ?>">


                    <p>
                        Apakah Anda yakin ingin menghapus siswa:
                    </p>

                    <strong>
                        <?= htmlspecialchars($row['nama']) ?>
                    </strong>

                    <br>

                    <small class="text-muted">
                        NISN: <?= htmlspecialchars($row['nisn']) ?>
                    </small>

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
                        class="btn btn-danger">

                        Hapus

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<?php } ?>


<?php include 'footer.php'; ?>
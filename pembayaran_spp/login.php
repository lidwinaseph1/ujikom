<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Pembayaran SPP</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-primary">

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-md-5 col-lg-4">

            <div class="card border-0 shadow">

                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <h3 class="text-primary">
                            Pembayaran SPP
                        </h3>

                        <p class="text-muted mb-0">
                            Silakan login terlebih dahulu
                        </p>

                    </div>

                    <?php if (isset($_GET['pesan'])) { ?>

                        <?php if ($_GET['pesan'] == 'gagal') { ?>

                            <div class="alert alert-danger">
                                Username atau password salah.
                            </div>

                        <?php } ?>

                        <?php if ($_GET['pesan'] == 'logout') { ?>

                            <div class="alert alert-success">
                                Anda berhasil logout.
                            </div>

                        <?php } ?>

                    <?php } ?>

                    <form action="proses_login.php" method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
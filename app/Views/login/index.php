<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?> </title>

    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css'); ?> ">
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?> ">
</head>

<body id="login-body">
    <div class="konten-login">
        <div class="form-login-wrapper">
            <form action="<?= base_url('login'); ?>" method="POST" class="form-login">
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control <?= (validation_errors()) ? 'is-invalid' : ''; ?>" id="email" aria-describedby="emailHelp" name="email" autofocus value="<?= old('email'); ?> ">
                    <div class="invalid-feedback">
                        <?= validation_show_error('email'); ?>
                    </div>
                    <div class="peringatan-email">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= (validation_errors() ? 'is-invalid' : ''); ?>" id="password" name="password">
                    <div class="invalid-feedback">
                        <?= validation_show_error('password'); ?>
                    </div>
                </div>
                <!-- jika password yang dimasukkan salah munculkan pesan peringatan -->
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <!-- jika berhasil logout munculkan pesan berhasil logout -->
                <?php if (session()->get('success')) : ?>
                    <div class="alert alert-success">
                        <?= session()->get('success'); ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>


            </form>
        </div>
    </div>
</body>

</html>
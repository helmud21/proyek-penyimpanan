<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul; ?></title>

    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css'); ?> ">
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.min.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-secondary .text-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('/dashboard'); ?> ">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('/dashboard'); ?> ">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/about'); ?> ">About Us</a>
                    </li>
                </ul>
            </div>
            <?php if (session()->get('isLoggedIn')) : ?>

                <div class="ms-auto">
                    <a
                        href="<?= base_url('logout'); ?>"
                        class="btn btn-danger">
                        Logout
                    </a>
                </div>

            <?php endif; ?>
        </div>
    </nav>
    <?= $this->renderSection('konten'); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.3/js/dataTables.min.js"></script>
    <script src="<?= base_url('script/bootstrap.bundle.min.js'); ?>"></script>
    <script>
        const BASE_URL = '<?= base_url(); ?>';
    </script>
    <script src="<?= base_url('script/javascript.js'); ?>"></script>
</body>

</html>
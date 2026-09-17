<?= $this->extend('layout/template'); ?>
<?= $this->section('konten'); ?>
<div class="container dashboard-konten">
    <div class="row">
        <div class="col">
            <h1 class="text-center mt-2">Dashboard Penyimpanan</h1>
            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalBarang">
                Tambah Data Barang
            </button>
            <!-- jika data berhasil ditambahkan muncul pesan sukses -->
            <?php if (session()->get('success')) : ?>
                <div class="alert alert-success">
                    <?= session()->get('success'); ?>
                </div>
            <?php endif; ?>
            <div id="alertSuccess" class="alert alert-success d-none my-2" role="alert">
                <i class="bi bi-check-circle"></i>
                <span id="alertSukses"></span>
            </div>
            <table id="tabelDashboardAdmin" class="display">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Jumlah Barang</th>
                    </tr>
                </thead>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="modalBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formBarang" class="form-barang">
                                <?= csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" autofocus value="<?= old('nama_barang'); ?>">
                                    <div id="errorNamaBarang" class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori Barang</label>
                                    <input type="text" class="form-control" id="kategori" name="kategori" value="<?= old('kategori'); ?>">
                                    <div id="errorKategori" class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Barang</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" value="<?= old('jumlah'); ?>">
                                    <div id="errorJumlah" class="invalid-feedback"></div>
                                </div>

                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" form="formBarang" class="btn btn-primary">Tambah Barang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>
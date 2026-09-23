<?= $this->extend('layout/template'); ?>
<?= $this->section('konten'); ?>
<div class="container dashboard-konten">
    <div class="row">
        <div class="col">
            <h1 class="text-center mt-2">Dashboard Penyimpanan</h1>
            <button type="button" id="btnTambahData" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalBarang">
                Tambah Data Barang
            </button>
            <!-- Jika data berhasil ditambahkan/diubah/delete menampilkan pesan sukses -->
            <?php if (session()->get('success')) : ?>
                <div class="alert alert-success">
                    <?= session()->get('success'); ?>
                </div>
            <?php endif; ?>
            <div id="alertSuccess" class="alert alert-success d-none my-2 text-center" role="alert">
                <i class="bi bi-check-circle"></i>
                <span id="alertSuccessMessage"></span>
            </div>
            <table id="tabelDashboardAdmin" class="display">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Gambar Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <!-- Modal form tambah/edit data barang-->
            <div class="modal fade" id="modalBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judulModal">Form Tambah Data Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formBarang" class="form-barang" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <input type="hidden" id="id_barang" name="id_barang">
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
                                <div class="mb-3">
                                    <input type="file" class="form-control d-none" id="gambar" name="gambar" value="<?= old('gambar'); ?>">
                                    <label for="gambar" class="btn btn-secondary">Pilih Gambar</label>
                                    <span id="namaFileGambar" class="ms-2"> . . . </span>
                                    <div id="errorGambar" class="invalid-feedback"></div>
                                </div>
                                <div class="mt-2 d-none" id="previewGambarWrapper">
                                    <img id="previewGambar" class="img-thumbnail" src="" alt="Preview gambar" style="max-height: 200px; max-width: 200px;">
                                </div>

                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" form="formBarang" class="btn btn-primary" id="btnSubmitAdmin">Tambah Barang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal konfirmasi hapus data barang -->
            <div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="judulModalHapus" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="judulModalHapus">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">
                                Apakah Anda yakin ingin menghapus data barang ini?
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">Hapus</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>
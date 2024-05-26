<?php
session_start();
require_once '../../../../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

require_once TEMPLATE_PATH . '/header.php';
require_once TEMPLATE_PATH . '/navbar.php';

?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-footer bg-primary rounded-top d-flex justify-content-between align-items-center">
                        <p class="display-5 text-bold fw-semibold text-white mb-0">Mengelola Kategori Journal & Artikel</p>
                        <div>
                            <button class="btn btn-danger btn-sm" id="deleteSelectedJCategoriesBtn">
                                <span class="mdi mdi-minus-circle-outline align-middle"></span> Hapus
                            </button>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahJKategoriModal">
                                <span class="mdi mdi-plus-circle-outline align-middle"></span> Tambah Kategori
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="categoryJTable" class="display">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAllJCategories"></th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="tambahJKategoriModal" tabindex="-1" aria-labelledby="tambahJKategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="tambahJKategoriModalLabel">Tambah Kategori Baru</h5>
                </div>
                <div class="modal-body">
                    <form id="formTambahJKategori">
                        <div class="mb-3">
                            <label for="namaKategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="namaKategori" name="nama_kategori" autocomplete="off" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary" form="formTambahJKategori">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Kategori -->
<div class="modal fade" id="editKategoriJModal" tabindex="-1" aria-labelledby="editKategoriJModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="editKategoriJModalLabel">Edit Kategori</h5>
            </div>
            <div class="modal-body">
                <form id="formEditJKategori">
                    <input type="hidden" id="editJKategoriId" name="id_kategori">
                    <div class="mb-3">
                        <label for="editJNamaKategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="editJNamaKategori" name="nama_kategori" autocomplete="off" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary" form="formEditJKategori">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?php require_once TEMPLATE_PATH . '/footer.php'; ?>
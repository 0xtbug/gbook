<?php
session_start();
require_once '../../../config.php';
require_once DATABASE_PATH . '/db_connection.php';

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
                <p class="display-5 text-bold fw-semibold text-white mb-0">Mengelola Buku</p>
                    <div>
                        <button class="btn btn-danger btn-sm" id="deleteSelectedBooksBtn">
                            <span class="mdi mdi-minus-circle-outline align-middle"></span> Hapus
                        </button>
                        <button class="btn btn-success btn-sm" id="addBtn">
                            <span class="mdi mdi-plus-circle-outline align-middle"></span> Tambah
                        </button>
                    </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="bookTable" class="display">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAllBooks"></th>
                                        <th>Judul</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Tahun Terbit</th>
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


<?php require_once TEMPLATE_PATH . '/footer.php'; ?>
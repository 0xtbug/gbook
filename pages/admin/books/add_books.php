<?php
session_start();
require_once '../../../config.php';

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
                <p class="display-5 text-bold fw-semibold text-white mb-0">Mengedit Buku</p>
                    <div>
                        <a href="<?= BASE_URL. "pages/admin/books/manage_books.php"; ?>">
                        <button class="btn btn-success btn-sm" id="addBtn">
                            <span class="mdi mdi-arrow-left align-middle"></span> Kembali
                        </button></a>
                    </div>
                </div>
                
                <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="judul">Judul*</label>
                    <input type="text" class="form-control" id="judul" name="judul"  placeholder="Judul" required>
                    </div>
                    <div class="form-group">
                    <label for="namaPengarang">Nama Pengarang*</label>
                    <input type="text" class="form-control" id="namaPengarang" name="pengarang" placeholder="Nama Pengarang" required>
                    </div>
                    <div class="form-group row">
                    <div class="col-md-6">
                        <label for="namaPenerbit">Nama Penerbit*</label>
                        <input type="text" class="form-control" id="namaPenerbit" name="penerbit" placeholder="Nama Penerbit" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggalTerbit">Tanggal Terbit*</label>
                        <input type="date" class="form-control" id="tanggalTerbit" name="tanggal_terbit" placeholder="Tanggal Terbit" autocomplete="off" required>
                    </div>
                    </div>
                    <div class="form-group">
                    <label>Upload Gambar Buku*</label>
                    <input type="file" name="img[]" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="file" class="form-control file-upload-info" name="cover" placeholder="Upload Gambar" accept="image/*" required>
                    </div>
                    <p class="mb-0">Format: .jpg, .jpeg, .png, .gif</p>
                    </div>
                    <div class="form-group">
                    <label>Upload File Buku*</label>
                    <input type="file" name="pdf[]" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="file" class="form-control file-upload-info" name="url_buku" placeholder="Upload File" accept=".pdf" required>
                    </div>
                    <p class="mb-0">Format: .pdf</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $cover = $_FILES['cover'];
    $url_buku = $_FILES['url_buku'];

    // Panggil fungsi addBook
    addBook($judul, $pengarang, $penerbit, $tanggal_terbit, $cover, $url_buku, $conn);
}

?>
<?php require_once TEMPLATE_PATH . '/footer.php'; ?>
<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

require_once TEMPLATE_PATH . '/header.php';
require_once TEMPLATE_PATH . '/navbar.php';
require_once FUNCTIONS_PATH . 'functions.php';

$user_id = $_SESSION['user_id'];
$favorite_books = getFavoriteBooks($user_id, $conn);
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-footer rounded-top d-flex justify-content-between align-items-center">
            <p class="display-5 text-bold fw-semibold mb-0">Favorit</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php if (count($favorite_books) > 0): ?>
                    <?php foreach ($favorite_books as $book): ?>
                      <tr>
                        <td>
                          <img src="<?= BASE_URL . 'uploads/books/covers/' . htmlspecialchars($book['cover']); ?>" alt="Cover" class="img-thumbnail" alt="Cover Buku" style="height: 80px; width: 60px;  border-radius:1em;-moz-border-radius: 1em;">
                        </td>
                        <td><?= htmlspecialchars($book['judul']); ?></td>
                        <td><?= htmlspecialchars($book['pengarang']); ?></td>
                        <td>
                          <a href="detail_book.php?id=<?= $book['id']; ?>" class="btn btn-primary btn-sm">Detail</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada buku favorit yang ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once TEMPLATE_PATH . '/footer.php'; ?>

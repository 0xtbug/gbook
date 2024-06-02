<?php
session_start();
require_once '../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$bookmarks = getUserBookmarks($user_id, $conn);
require_once TEMPLATE_PATH . '/header.php';
require_once TEMPLATE_PATH . '/navbar.php';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-footer rounded-top d-flex justify-content-between align-items-center">
                        <p class="display-5 text-bold fw-semibold mb-0">Penanda Buku</p>
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
                                <?php if (count($bookmarks) > 0): ?>
                                    <?php foreach ($bookmarks as $bookmark): ?>
                                        <tr>
                                            <td><img src="<?= BASE_URL . 'uploads/books/covers/' . htmlspecialchars($bookmark['cover']); ?> " class="img-thumbnail" alt="Cover Buku" style="height: 80px; width: 60px;  border-radius:1em;-moz-border-radius: 1em;"></td>
                                            <td><?= htmlspecialchars($bookmark['judul']); ?></td>
                                            <td><?= htmlspecialchars($bookmark['pengarang']); ?></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm removeBookmarkBtn" data-id="<?= $bookmark['id']; ?>">
                                                    <i class="mdi mdi mdi-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada buku yang ditandai.</td>
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
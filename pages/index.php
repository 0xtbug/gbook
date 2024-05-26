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

// Ambil kategori, tipe, dan kata kunci pencarian dari URL
$category = isset($_GET['category']) ? $_GET['category'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mengambil buku atau jurnal berdasarkan kategori atau pencarian
if ($type == 'search' && !empty($search)) {
    $books = searchBooks($search, $conn);
    $journals = searchJournals($search, $conn);
    if(!empty($journals)){
      $items = array_merge($books, $journals);
    }else{
      $items = $books;
    }
} elseif ($category && $type == 'book') {
    $items = getBooksByCategory($category, $conn);
} elseif ($category && $type == 'journal&artikel') {
    $items = getJournalsByCategory($category, $conn);
    // Jika jurnal tidak tersedia, tampilkan buku saja
    if (empty($items)) {
        $items = getBooksByCategory($category, $conn);
    }
} else {
    $books = getAllBooks($conn);
    $journals = getAllJournals($conn);
    // Jika jurnal tidak tersedia, hanya tampilkan buku
    if (!empty($journals)) {
        $items = array_merge($books, $journals);
    } else {
        $items = $books;
    }
}
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
    <?php if (empty($items)): ?>
        <div class="col-12">
          <div class="alert alert-warning text-center" role="alert">
            Buku Tidak Tersedia
          </div>
        </div>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
            <div class="col-md-3 grid-margin grid-margin-md-0">
              <div class="card shadow-sm">
                <a href="<?= BASE_URL . 'pages/detail_' . (isset($item['kategori_jurnal']) ? 'journal' : 'book') . '.php?id=' . $item['id']; ?>" style="text-decoration: none; color: inherit;">
                  <div class="card-body">
                    <img src="<?= BASE_URL . 'uploads/' . (isset($item['kategori_jurnal']) ? 'journals' : 'books') . '/covers/' . $item['cover']; ?>" class="card-img-top" alt="Cover">
                    <p class="card-text mt-2"><?= $item['pengarang']; ?></p>
                    <h4 class="card-title"><?= $item['judul']; ?></h4>
                  </div>
                </a>
              </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
  </div>

<?php require_once TEMPLATE_PATH . '/footer.php'; ?>

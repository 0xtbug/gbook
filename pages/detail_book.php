<?php
session_start();
require_once '../config.php';
require_once FUNCTIONS_PATH . 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit();
}

// Validasi dan sanitasi parameter GET
if (isset($_GET['id'])) {
    $bookId = validateId($_GET['id']);
    $bookId = sanitizeInput($bookId, $conn);
} else {
    die("ID diperlukan.");
}

// Mengambil detail buku menggunakan fungsi getBookDetails
$book = getBookDetails($bookId, $conn);
$reviews = getBookReviews($bookId, $conn);
$ratingData = getAverageRating($bookId, $conn);
$averageRating = $ratingData['average_rating'] !== null ? round($ratingData['average_rating'], 1) : 0;
$totalRatings = $ratingData['total_ratings'];

if (!$book) {
    echo("Buku tidak ditemukan.<br>Kembali ke halaman utama dalam 3 detik...");
    echo '
    <script type="text/javascript">
        setTimeout(function() {
            window.location.href = "' . BASE_URL . 'pages/index.php";
        }, 3000);
    </script>
    ';
    exit();    
}

require_once TEMPLATE_PATH . '/header.php';
require_once TEMPLATE_PATH . '/navbar.php';
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-4 grid-margin" id="bookCard">
        <div class="card">
          <div class="card-body text-center">
            <img src="<?= BASE_URL . 'uploads/books/covers/' . $book['cover']; ?>" class="card-img-top" alt="Cover Buku">
          </div>
        </div>
        <button type="button" class="btn btn-primary mt-3 shadow-lg rounded" style="width: 100%;" onclick="showBook('<?= BASE_URL . 'uploads/books/' . $book['url_buku']; ?>')">Baca Buku</button>
      </div>
      <div class="col-md-8 grid-margin stretch-card" id="detailCardContainer">
        <div class="card">
          <div class="" id="detailCard">
            <div class="card-footer d-flex justify-content-end">
              <button class="btn btn-link text-danger"><i class="mdi mdi-heart" style="font-size: 1.5rem;"></i></button>
              <button class="btn btn-link"><i class="mdi mdi-bookmark" style="font-size: 1.5rem;"></i></button>
            </div>
          </div>
          <div class="card-body" id="bookContainer">
            <h5 class="card-text"><?= $book['pengarang']; ?></h5>
            <h4 class="card-title" style="font-size: 2.0rem;"><?= $book['judul']; ?></h4>
            <p class="card-text"><span style="font-size: 35px;color: gold;">&#9733;</span> <?= $averageRating; ?> / 5.0 dari <?= $totalRatings; ?> pengguna</p>
            <hr>
            <div class="d-flex justify-content-between">
              <h5 class="card-text fw-bold mb-3">Detail Buku</h5>
            </div>
            <div class="d-flex justify-content-between">
              <p class="card-text"><span class="fw-bold">Tanggal Terbit:</span> <br> <?= date('d M Y', strtotime($book['tanggal_terbit'])); ?></p>
              <p class="card-text text-end"><span class="fw-bold">Penerbit:</span> <br><?= $book['penerbit']; ?></p>
            </div>
            <hr>
            <h5 class="card-text fw-bold">Reviews</h5>
            <div class="review mt-3" style="max-height: 300px; overflow-y: auto;">
              <?php if (empty($reviews)): ?>
                <p class="text-center">Belum ada komentar di buku ini.</p>
              <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                <div class="d-flex">
                  <i class="mdi mdi-account-circle icon-md"></i>
                  <div class="ml-2">
                    <h6><?= htmlspecialchars($review['username']); ?></h6>
                    <p><span style="font-size: 20px;color: gold;">
                      <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                        &#9733;
                      <?php endfor; ?>
                    </span></p>
                    <p><?= htmlspecialchars($review['review_text']); ?></p>
                  </div>
                </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <hr>
            <h5 class="card-text fw-bold">Tulis Review</h5>
            <form class="review-input" method="post">
              <input type="hidden" name="book_id" value="<?= $bookId; ?>">
              <div class="review-stars">
                <input type="hidden" name="rating" id="rating" value="0">
                <span data-rating="1">&#9734;</span>
                <span data-rating="2">&#9734;</span>
                <span data-rating="3">&#9734;</span>
                <span data-rating="4">&#9734;</span>
                <span data-rating="5">&#9734;</span>
              </div>
              <textarea class="review-textarea form-control mt-2" rows="3" name="review_text" placeholder="Tulis review"></textarea>
              <button class="review-submit btn btn-primary mt-2" type="submit">Kirim Review</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once TEMPLATE_PATH . '/footer.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id = $_SESSION['user_id']; // Asumsi user_id disimpan di session
  $book_id = sanitizeInput($_POST['book_id'], $conn);
  $rating = sanitizeInput($_POST['rating'], $conn);
  $review_text = sanitizeInput($_POST['review_text'], $conn);

  submitReview($user_id, $book_id, $rating, $review_text, $conn);
}

?>
<script>
function showBook(bookUrl) {
    var iframeHtml = '<iframe src="' + bookUrl + '" style="width: 100%; height: 80vh;" frameborder="0"></iframe>';
    document.getElementById('bookContainer').innerHTML = iframeHtml;

    // Sembunyikan card dan footer
    document.getElementById('bookCard').style.display = 'none';
    document.getElementById('detailCard').style.display = 'none';

    // Ubah kelas kolom menjadi col-lg-12
    var detailCardContainer = document.getElementById('detailCardContainer');
    detailCardContainer.classList.remove('col-md-8');
    detailCardContainer.classList.add('col-lg-12');
}

// Menangani klik pada bintang rating
document.querySelectorAll('.review-stars span').forEach(function(star) {
    star.addEventListener('click', function() {
        var rating = this.getAttribute('data-rating');
        document.getElementById('rating').value = rating;
        var stars = this.parentElement.children;
        for (var i = 0; i < stars.length; i++) {
            if (i < rating) {
                stars[i].innerHTML = '&#9733;';
            } else {
                stars[i].innerHTML = '&#9734;';
            }
        }
    });
});
</script>

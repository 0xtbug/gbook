<?php
require_once DATABASE_PATH . '/db_connection.php';
include_once('alert.php');

// =============================== START OF USERS FUNCTIONS ==================================

function loginUser($email, $password, $conn) {
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    // Mengecek apakah ada user dengan email tersebut
    $query = $conn->query("SELECT * FROM mahasiswa WHERE email='$email'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();
        // Cek apakah status user 'off'
        if ($user['status'] == 'off') {
            alert("error", "User belum aktif", "register.php");
        } else {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = $user['id']; // Menyimpan user_id ke dalam session
                alert_timer("Berhasil login", "../pages/index.php");
            } else {
                alert("error", "Password salah", "login.php");
            }
        }
    } else {
        alert("error", "Email tidak terdaftar", "login.php");
    }
}

function registerUser($email, $password, $confirm_password, $conn) {
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $confirm_password = $conn->real_escape_string($confirm_password);

    // Cek jika password dan konfirmasi password sama
    if ($password != $confirm_password) {
        alert("error", "password dan konfirmasi password tidak sama.", "register.php");
        exit;
    }

    // Mengecek email sudah ada atau belum
    $query = $conn->query("SELECT * FROM mahasiswa WHERE email='$email'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();
        if ($user['status'] == 'off') {
            // Jika status off, update password dan ubah status ke on
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->query("UPDATE mahasiswa SET password='$hashed_password', status='on' WHERE email='$email'");

            if ($update) {
                alert_timer("Email anda terdaftar di database", "login.php");
            } else {
                alert("error", "Terjadi kesalahan", "");
            }
        } elseif ($user['status'] == 'on') {
            // Jika status sudah on, beri tahu bahwa akun tidak dapat dibuat
            alert("error", "Email Anda sudah terdaftar di database", "");
        }
    } else {
        alert("error", "Email Anda belum terdaftar di database, akun tidak dapat dibuat", "");
    }
}

function getAllBooks($conn) {
    $stmt = $conn->prepare("SELECT * FROM books");
    $stmt->execute();
    $result = $stmt->get_result();
    $books = [];

    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    $stmt->close();
    return $books;
}

function getBookDetails($id, $conn) {
    // Menggunakan prepared statement untuk mengambil data buku berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();

    return $book;
}



function isFavoriteBook($user_id, $book_id, $conn) {
    $stmt = $conn->prepare("SELECT * FROM favorite_books WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $isFavorite = $result->num_rows > 0;
    $stmt->close();
    return $isFavorite;
}

function isBookmark($user_id, $book_id, $conn) {
    $stmt = $conn->prepare("SELECT * FROM bookmarks WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $isBookmark = $result->num_rows > 0;
    $stmt->close();
    return $isBookmark;
}

function addFavoriteBook($user_id, $book_id, $conn) {
    if (!isFavoriteBook($user_id, $book_id, $conn)) {
        $stmt = $conn->prepare("INSERT INTO favorite_books (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $book_id);
        return $stmt->execute();
    }
    return false;
}

function removeFavoriteBook($user_id, $book_id, $conn) {
    $stmt = $conn->prepare("DELETE FROM favorite_books WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    return $stmt->execute();
}

function addBookmark($user_id, $book_id, $conn) {
    if (!isBookmark($user_id, $book_id, $conn)) {
        $stmt = $conn->prepare("INSERT INTO bookmarks (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $book_id);
        return $stmt->execute();
    }
    return false;
}

function removeBookmark($user_id, $book_id, $conn) {
    $stmt = $conn->prepare("DELETE FROM bookmarks WHERE user_id = ? AND book_id = ?");
    $stmt->bind_param("ii", $user_id, $book_id);
    return $stmt->execute();
}

function getUserBookmarks($user_id, $conn) {
    $stmt = $conn->prepare("SELECT b.id, b.judul, b.pengarang, b.penerbit, b.tanggal_terbit, b.cover 
                            FROM bookmarks bm 
                            JOIN books b ON bm.book_id = b.id 
                            WHERE bm.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookmarks = [];
    while ($row = $result->fetch_assoc()) {
        $bookmarks[] = $row;
    }
    $stmt->close();
    return $bookmarks;
}

function getFavoriteBooks($user_id, $conn) {
    $stmt = $conn->prepare("SELECT b.id, b.judul, b.pengarang, b.penerbit, b.cover, b.url_buku 
                            FROM favorite_books f 
                            JOIN books b ON f.book_id = b.id 
                            WHERE f.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $favorite_books = [];
    while ($row = $result->fetch_assoc()) {
        $favorite_books[] = $row;
    }

    $stmt->close();
    return $favorite_books;
}

function generateJAID($user_id) {
    return 'JA_' . uniqid();
}

function saveNewSubmission($user_id, $ja_id, $conn) {
    $stmt = $conn->prepare("DELETE FROM upload_journal WHERE finish = 0");
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO upload_journal (user_id, ja_id, date_uploads) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $user_id, $ja_id);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function saveSubmissionData($user_id, $category, $language, $conn) {
    // Periksa apakah ada data dengan ja_id yang finish = 0
    $checkStmt = $conn->prepare("SELECT ja_id FROM upload_journal WHERE user_id = ? AND finish = 0");
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->bind_result($ja_id);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($ja_id) {
        $stmt = $conn->prepare("UPDATE upload_journal SET category = ?, language = ?, date_uploads = NOW() WHERE ja_id = ?");
        $stmt->bind_param("sss", $category, $language, $ja_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO upload_journal (user_id, category, language, date_uploads) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $user_id, $category, $language);
    }

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}


function saveUploadedDocx($user_id, $fileName, $conn) {
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM upload_journal WHERE user_id = ?");
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        $stmt = $conn->prepare("UPDATE upload_journal SET file_path_docs = ?, date_uploads = NOW() WHERE user_id = ?");
        $stmt->bind_param("si", $fileName, $user_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO upload_journal (user_id, file_path_docs, date_uploads) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $user_id, $fileName);
    }

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function saveAuthorData($user_id, $firstName, $middleName, $lastName, $email, $affiliation, $country, $conn) {
    $status = "Awaiting Assignment";
    $stmt = $conn->prepare("INSERT INTO upload_journal_user (user_id, first_name, middle_name, last_name, email, affiliation, country, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $user_id, $firstName, $middleName, $lastName, $email, $affiliation, $country, $status);
    
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

function saveFormSubmissionData($user_id, $title, $subtitle, $abstract, $keyword, $references, $conn) {
    $checkStmt = $conn->prepare("SELECT ja_id FROM upload_journal WHERE user_id = ? AND finish = 0");
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->bind_result($ja_id);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($ja_id) {
        $stmt = $conn->prepare("UPDATE upload_journal SET title = ?, subtitle = ?, abstract = ?, keyword = ?, references = ?, date_uploads = NOW() WHERE ja_id = ?");
        $stmt->bind_param("ssssss", $title, $subtitle, $abstract, $keyword, $references, $ja_id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

// =============================== END OF USERS FUNCTIONS ==================================

// =============================== START OF ADMIN FUNCTIONS ==================================

function loginAdmin($email, $password, $conn) {
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    $query = $conn->query("SELECT * FROM pengurus WHERE email='$email'");
    if ($query->num_rows > 0) {
        $admin = $query->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $email;
            alert_timer("Berhasil login sebagai admin", "../pages/admin");
        } else {
            alert("error", "Password salah", "login.php");
        }
    } else {
        alert("error", "Email tidak terdaftar sebagai admin", "login.php");
    }
}

function addBook($judul, $pengarang, $penerbit, $tanggal_terbit, $cover, $url_buku, $conn) {
    // Konversi tanggal ke format MySQL
    $tanggal_terbit = date('Y-m-d', strtotime($tanggal_terbit));

    // Siapkan direktori untuk mengunggah file
    $cover_dir = UPLOADS_PATH . 'books/covers/';
    $book_dir = UPLOADS_PATH . 'books/';

    // Siapkan path file yang akan diunggah
    $cover_file = $cover_dir . basename($cover['name']);
    $book_file = $book_dir . basename($url_buku['name']);

    // Validasi file cover (hanya gambar yang diperbolehkan)
    $cover_file_type = strtolower(pathinfo($cover_file, PATHINFO_EXTENSION));
    if ($cover_file_type != 'jpg' && $cover_file_type != 'jpeg' && $cover_file_type != 'png' && $cover_file_type != 'gif') {
        alert("error", "Hanya file gambar (JPG, JPEG, PNG, GIF) yang diperbolehkan untuk cover.", "add_books.php");
        exit;
    }

    // Validasi file buku (hanya PDF yang diperbolehkan)
    $book_file_type = strtolower(pathinfo($book_file, PATHINFO_EXTENSION));
    if ($book_file_type != 'pdf') {
        alert("error", "Hanya file PDF yang diperbolehkan untuk buku.", "add_books.php");
        exit;
    }

    // Cek apakah buku sudah ada di database
    $stmt = $conn->prepare("SELECT * FROM books WHERE judul = ?");
    $stmt->bind_param("s", $judul);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        alert("error", "Buku dengan informasi yang sama sudah ada di database.", "add_books.php");
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

    // Unggah file cover
    if (move_uploaded_file($cover['tmp_name'], $cover_file)) {
        $cover_url = basename($cover['name']);
    } else {
        alert("error", "Terjadi kesalahan saat mengunggah cover.", "add_books.php");
        exit;
    }

    // Unggah file buku
    if (move_uploaded_file($url_buku['tmp_name'], $book_file)) {
        $book_url = basename($url_buku['name']);
    } else {
        alert("error", "Terjadi kesalahan saat mengunggah buku.", "add_book.php");
        exit;
    }

    // Simpan informasi buku ke dalam database
    $category = 'Lainnya';
    $stmt = $conn->prepare("INSERT INTO books (judul, pengarang, penerbit, tanggal_terbit, cover, url_buku, kategori) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $judul, $pengarang, $penerbit, $tanggal_terbit, $cover_url, $book_url, $category);

    if ($stmt->execute()) {
        alert_timer("Buku berhasil ditambahkan.", "add_books.php");
    } else {
        alert("error", "Terjadi kesalahan: " . $stmt->error, "add_books.php");
    }

    $stmt->close();
    $conn->close();
}



function editBooks($id, $judul, $pengarang, $penerbit, $tanggal_terbit, $cover, $url_buku, $conn) {
    // Konversi tanggal ke format MySQL
    $tanggal_terbit = date('Y-m-d', strtotime($tanggal_terbit));

    // Siapkan direktori untuk mengunggah file
    $cover_dir = UPLOADS_PATH . 'books/covers/';
    $book_dir = UPLOADS_PATH . 'books/';

    // Siapkan path file yang akan diunggah
    $cover_file = $cover_dir . basename($cover['name']);
    $book_file = $book_dir . basename($url_buku['name']);

    // Validasi file cover (hanya gambar yang diperbolehkan)
    $cover_file_type = strtolower(pathinfo($cover_file, PATHINFO_EXTENSION));
    if ($cover_file_type != 'jpg' && $cover_file_type != 'jpeg' && $cover_file_type != 'png' && $cover_file_type != 'gif') {
        alert("error", "Hanya file gambar (JPG, JPEG, PNG, GIF) yang diperbolehkan untuk cover.", "edit_books.php?id=$id");
        exit;
    }

    // Validasi file buku (hanya PDF yang diperbolehkan)
    $book_file_type = strtolower(pathinfo($book_file, PATHINFO_EXTENSION));
    if ($book_file_type != 'pdf') {
        alert("error", "Hanya file PDF yang diperbolehkan untuk buku.", "edit_books.php?id=$id");
        exit;
    }

    // Cek apakah judul buku sudah ada di database, kecuali buku dengan ID yang sedang diedit
    $stmt = $conn->prepare("SELECT * FROM books WHERE judul = ? AND id != ?");
    $stmt->bind_param("si", $judul, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        alert("error", "Judul buku sudah ada di database.", "edit_books.php?id=$id");
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();

    // Unggah file cover
    if (move_uploaded_file($cover['tmp_name'], $cover_file)) {
        $cover_url = basename($cover['name']);
    } else {
        alert("error", "Terjadi kesalahan saat mengunggah cover.", "edit_books.php?id=$id");
        exit;
    }

    // Unggah file buku
    if (move_uploaded_file($url_buku['tmp_name'], $book_file)) {
        $book_url = basename($url_buku['name']);
    } else {
        alert("error", "Terjadi kesalahan saat mengunggah buku.", "edit_books.php?id=$id");
        exit;
    }

    // Simpan informasi buku yang diperbarui ke dalam database
    $category = 'Lainnya';
    $stmt = $conn->prepare("UPDATE books SET judul=?, pengarang=?, penerbit=?, tanggal_terbit=?, cover=?, url_buku=?, kategori=? WHERE id=?");
    $stmt->bind_param("sssssssi", $judul, $pengarang, $penerbit, $tanggal_terbit, $cover_url, $book_url, $category, $id);

    if ($stmt->execute()) {
        alert_timer("Buku berhasil diperbarui.", "manage_books.php");
    } else {
        alert("error", "Terjadi kesalahan: " . $stmt->error, "edit_books.php?id=$id");
    }

    $stmt->close();
    $conn->close();
}


function getBooks($conn) {
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);

    $books = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }
    return $books;
}

function deleteBook($id, $conn) {
    // Hapus buku dari database berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
        
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}

function getBookById($id, $conn) {
    // Menggunakan prepared statement untuk mengambil data buku berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();
    
    return $book;
}

// =============================== START OF BOOK CATEGORY FUNCTIONS ==================================
function addCategoryBook($nama_kategori, $conn) {
    // Cek apakah kategori sudah ada
    $check_stmt = $conn->prepare("SELECT * FROM categories_books WHERE nama_kategori = ?");
    $check_stmt->bind_param("s", $nama_kategori);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Kategori sudah ada.']);
        $check_stmt->close();
        return;
    }
    $check_stmt->close();

    // Tambah kategori baru
    $stmt = $conn->prepare("INSERT INTO categories_books (nama_kategori) VALUES (?)");
    $stmt->bind_param("s", $nama_kategori);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $stmt->error]);
    }
    $stmt->close();
}

function editCategoryBook($id, $nama_kategori, $conn) {
    // Cek apakah kategori dengan nama yang sama sudah ada kecuali kategori yang sedang diedit
    $check_stmt = $conn->prepare("SELECT * FROM categories_books WHERE nama_kategori = ? AND id != ?");
    $check_stmt->bind_param("si", $nama_kategori, $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Kategori dengan nama yang sama sudah ada.']);
        $check_stmt->close();
        return;
    }
    $check_stmt->close();

    // Update kategori
    $stmt = $conn->prepare("UPDATE categories_books SET nama_kategori = ? WHERE id = ?");
    $stmt->bind_param("si", $nama_kategori, $id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $stmt->error]);
    }
    $stmt->close();
}

function deleteCategoryBook($id, $conn) {
    // Perbarui kolom kategori di tabel books menjadi 'Lainnya'
    $update_stmt = $conn->prepare("UPDATE books SET kategori = 'Lainnya' WHERE kategori = (SELECT nama_kategori FROM categories_books WHERE id = ?)");
    $update_stmt->bind_param("i", $id);
    if ($update_stmt->execute()) {
        // Hapus kategori dari tabel categories
        $delete_stmt = $conn->prepare("DELETE FROM categories_books WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        if ($delete_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus dan buku terkait diperbarui.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus kategori: ' . $delete_stmt->error]);
        }
        $delete_stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memperbarui buku: ' . $update_stmt->error]);
    }
    $update_stmt->close();
}

function getCategoriesBook($conn) {
    $categories = [];
    $stmt = $conn->prepare("SELECT nama_kategori FROM categories_books");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['nama_kategori'];
    }

    return $categories;
}

function getBooksByCategory($category, $conn) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE kategori = ?");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    
    return $books;
}

function getCategoriesBookById($id, $conn) {
    $stmt = $conn->prepare("SELECT * FROM categories_books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();
    
    return $category;
}


// Fungsi untuk menambah buku ke kategori
function addbooktoCategory($id, $category_id, $conn) {
    // Pastikan id valid dan bukan null
    if (!isset($id) || empty($id) || $category_id <= 0) {
        return false;
    }

    // Cari nama kategori berdasarkan category_id
    $stmt = $conn->prepare("SELECT nama_kategori FROM categories_books WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_kategori = $row['nama_kategori'];

        // Perbarui kolom kategori di tabel books
        $update_stmt = $conn->prepare("UPDATE books SET kategori = ? WHERE id = ?");
        $update_stmt->bind_param("si", $nama_kategori, $id);

        if ($update_stmt->execute()) {
            // Return true jika berhasil
            return true;
        } else {
            // Return false jika gagal
            return false;
        }
    } else {
        // Kategori tidak ditemukan
        return false;
    }
}

function searchBooks($keyword, $conn) {
    $keyword = "%$keyword%";
    $stmt = $conn->prepare("SELECT * FROM books WHERE judul LIKE ? OR pengarang LIKE ?");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("ss", $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    
    return $books;
}

// =============================== END OF BOOK CATEGORY FUNCTIONS ==================================

// =============================== START OF JOURNAL ARTICEL CATEGORY FUNCTIONS ==================================
function addCategoryJournalArticel($nama_kategori, $conn) {
    // Cek apakah kategori sudah ada
    $check_stmt = $conn->prepare("SELECT * FROM categories_journal_artikel WHERE nama_kategori = ?");
    $check_stmt->bind_param("s", $nama_kategori);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Kategori sudah ada.']);
        $check_stmt->close();
        return;
    }
    $check_stmt->close();

    // Tambah kategori baru
    $stmt = $conn->prepare("INSERT INTO categories_journal_artikel (nama_kategori) VALUES (?)");
    $stmt->bind_param("s", $nama_kategori);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $stmt->error]);
    }
    $stmt->close();
}

function editCategoryJournalArticel($id, $nama_kategori, $conn) {
    // Cek apakah kategori dengan nama yang sama sudah ada kecuali kategori yang sedang diedit
    $check_stmt = $conn->prepare("SELECT * FROM categories_journal_artikel WHERE nama_kategori = ? AND id != ?");
    $check_stmt->bind_param("si", $nama_kategori, $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Kategori dengan nama yang sama sudah ada.']);
        $check_stmt->close();
        return;
    }
    $check_stmt->close();

    // Update kategori
    $stmt = $conn->prepare("UPDATE categories_journal_artikel SET nama_kategori = ? WHERE id = ?");
    $stmt->bind_param("si", $nama_kategori, $id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $stmt->error]);
    }
    $stmt->close();
}

function deleteCategoryJournalArticel($id, $conn) {
    // Perbarui kolom kategori di tabel books menjadi 'Lainnya'
    $update_stmt = $conn->prepare("UPDATE books SET kategori = 'Lainnya' WHERE kategori = (SELECT nama_kategori FROM categories_journal_artikel WHERE id = ?)");
    $update_stmt->bind_param("i", $id);
    if ($update_stmt->execute()) {
        // Hapus kategori dari tabel categories
        $delete_stmt = $conn->prepare("DELETE FROM categories_journal_artikel WHERE id = ?");
        $delete_stmt->bind_param("i", $id);
        if ($delete_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus dan buku terkait diperbarui.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus kategori: ' . $delete_stmt->error]);
        }
        $delete_stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memperbarui buku: ' . $update_stmt->error]);
    }
    $update_stmt->close();
}


function getCategories($conn) {
    $sql = "SELECT * FROM categories_journal_artikel";
    $result = $conn->query($sql);

    $books = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }
    return $books;
}

function getCategoriesJournalArticel($conn) {
    $categories = [];
    $stmt = $conn->prepare("SELECT nama_kategori FROM categories_journal_artikel");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['nama_kategori'];
    }

    return $categories;
}

function getCategoriesJournalArticelById($id, $conn) {
    $stmt = $conn->prepare("SELECT * FROM categories_journal_artikel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();
    
    return $category;
}


// Fungsi untuk menambah buku ke kategori
function addJournalArticelToCategory($id, $category_id, $conn) {
    // Pastikan id valid dan bukan null
    if (!isset($id) || empty($id) || $category_id <= 0) {
        return false;
    }

    // Cari nama kategori berdasarkan category_id
    $stmt = $conn->prepare("SELECT nama_kategori FROM categories_journal_artikel WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_kategori = $row['nama_kategori'];

        // Perbarui kolom kategori di tabel books
        $update_stmt = $conn->prepare("UPDATE books SET kategori = ? WHERE id = ?");
        $update_stmt->bind_param("si", $nama_kategori, $id);

        if ($update_stmt->execute()) {
            // Return true jika berhasil
            return true;
        } else {
            // Return false jika gagal
            return false;
        }
    } else {
        // Kategori tidak ditemukan
        return false;
    }
}

function getJournalsByCategory($category, $conn) {
    $stmt = $conn->prepare("SELECT * FROM journal_artikel WHERE kategori = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $journals = [];
    while ($row = $result->fetch_assoc()) {
        $journals[] = $row;
    }
    
    return $journals;
}

function getAllJournals($conn) {
    $stmt = $conn->prepare("SELECT * FROM journal_artikel");
    $stmt->execute();
    $result = $stmt->get_result();
    
    $journals = [];
    while ($row = $result->fetch_assoc()) {
        $journals[] = $row;
    }
    
    return $journals;
}

function searchJournals($keyword, $conn) {
    $keyword = "%$keyword%";
    $stmt = $conn->prepare("SELECT * FROM journal_artikel WHERE judul LIKE ?");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("s", $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $journals = [];
    while ($row = $result->fetch_assoc()) {
        $journals[] = $row;
    }
    
    return $journals;
}
// =============================== END OF JOURNAL ARTICEL CATEGORY FUNCTIONS ==================================


// =============================== END OF ADMIN FUNCTIONS ==================================










// =============================== START OF GENERAL FUNCTIONS ==================================
function sanitizeInput($data, $conn) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}

function validateId($id) {
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        die("Mau ngapain dik..");
    }
    return $id;
}


function submitReview($user_id, $book_id, $rating, $review_text, $conn) {
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, book_id, rating, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $book_id, $rating, $review_text);

    if ($stmt->execute()) {
        $stmt->close();
        alert_timer("Review berhasil ditambahkan.", "detail_book.php?id=$book_id");
    } else {
        $stmt->close();
        alert("error", "Terjadi kesalahan saat menambahkan review.", "detail_book.php?id=$book_id");
    }
}

function getBookReviews($bookId, $conn) {
    $stmt = $conn->prepare("SELECT r.rating, r.review_text, m.email AS username FROM reviews r JOIN mahasiswa m ON r.user_id = m.id WHERE r.book_id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $reviews = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $reviews;
}


function getAverageRating($bookId, $conn) {
    $stmt = $conn->prepare("SELECT AVG(rating) as average_rating, COUNT(rating) as total_ratings FROM reviews WHERE book_id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data;
}

// =============================== END OF GENERAL FUNCTIONS ==================================
?>

// Handle add button
$('#addBtn').on('click', function() {
    window.location.href = 'add_books.php';
});

$('#logoutLink').on('click', function(e) {
    e.preventDefault(); // Prevent default link behavior
    var baseUrl = $('meta[name="base-url"]').attr('content');
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Apakah Anda ingin keluar dari Aplikasi?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#01509D',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Benar',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = baseUrl + "auth/logout.php";
        }
    });
});

function renderBookButtons(row) {
    return '<center>' +
    '<a href="edit_books.php?id=' + row[0] + '">' +
    '<button class="btn btn-primary btn-sm">' +
    '<span class="mdi mdi-pencil"></span>' +
    '</button></a> ' +
    '<button class="btn btn-danger btn-sm deleteBtn" data-id="' + row[0] + '">' +
    '<span class="mdi mdi-trash-can-outline"></span>' +
    '</button>' +
    '</center>';
}

function renderCategoryButtons(row) {
    return '<center>' +
    '<a href="add_book_categories.php?id=' + row[0] + '">' +
    '<button class="btn btn-success btn-sm">' +
    '<span class="mdi mdi-plus-circle-outline"></span>' +
    '</button></a> ' +
    '<button class="btn btn-primary btn-sm editBtn" data-id="' + row[0] + '" data-nama="' + row[1] + '">' +
    '<span class="mdi mdi-pencil"></span>' +
    '</button> ' +
    '<button class="btn btn-danger btn-sm deleteBtn" data-id="' + row[0] + '">' +
    '<span class="mdi mdi-trash-can-outline"></span>' +
    '</button>' +
    '</center>';
}

$(document).ready(function() {
    initializeDataTable('#bookTable', 'books_proccess.php', 'delete_books.php', 'add_books.php', 'edit_books.php', 'Buku', 5, renderBookButtons, '#selectAllBooks', null,'#deleteSelectedBooksBtn');
    initializeDataTable('#categoryTable', 'categories_process.php', 'delete_categories.php', 'add_categories.php', 'edit_categories.php', 'Kategori', 2, renderCategoryButtons, '#selectAllCategories', null, '#deleteSelectedCategoriesBtn', '#formTambahKategori', '#formEditKategori', '#tambahKategoriModal', '#editKategoriId', '#editNamaKategori', '#editKategoriModal');
    initializeDataTable('#categoryJTable', 'categories_process.php', 'delete_categories.php', 'add_categories.php', 'edit_categories.php', 'Kategori', 2, renderCategoryButtons, '#selectAllJCategories', null, '#deleteSelectedJCategoriesBtn', '#formTambahJKategori', '#formEditJKategori','#tambahJKategoriModal', '#editJKategoriId', '#editJNamaKategori', '#editKategoriJModal');
    initializeDataTable('#addcategoryTable', 'add_book_categories_process.php', null, 'add_book_to_categories.php', null, 'Kategori', 5,null, '#selectAllCategories', '#addtoCategories', null, null, null, null, null, null);
    initializeDataTable('#addcategoryJTable', 'add_journalartikel_categories_process.php', null, 'add_journalartikel_to_categories.php', null, 'Kategori', 5,null, '#selectAllJToCategories', '#addtoJCategories', null, null, null, null, null, null);
});

function initializeDataTable(tableId, ajaxUrl, deleteUrl, addUrl, editUrl, entityName, totalColumn, renderButtons, selectAllId, addSelectedBtnId, deleteSelectedBtnId, formAddCategoryModal, formEditCategoryModal, addCategoryModal, editCategoryId, editCategoryName, editCategoryModal) {    
    deleteUrl = deleteUrl || '';
    addUrl = addUrl || '';
    editUrl = editUrl || '';
    renderButtons = renderButtons || function() { return ''; };
    selectAllId = selectAllId || '';
    addSelectedBtnId = addSelectedBtnId || '';
    deleteSelectedBtnId = deleteSelectedBtnId || '';
    formAddCategoryModal = formAddCategoryModal || '';
    formEditCategoryModal = formEditCategoryModal || '';
    addCategoryModal = addCategoryModal || '';
    editCategoryId = editCategoryId || '';
    editCategoryName = editCategoryName || '';
    editCategoryModal = editCategoryModal || '';

    var table = $(tableId).DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": ajaxUrl,
        "columnDefs": [
            {
                "searchable": false,
                "orderable": false,
                "targets": 0,
                "render": function(data, type, row) {
                    return '<input type="checkbox" class="selectBox" data-id="' + row[0] + '">';
                }
            },
            {
                "searchable": false,
                "orderable": false,
                "targets": totalColumn,
                "render": function(data, type, row) {
                    return renderButtons(row);
                }
            }
        ]
    });

    $(selectAllId).on('click', function() {
        $(tableId + ' .selectBox').prop('checked', this.checked);
    });

    $(deleteSelectedBtnId).on('click', function() {
        var ids = [];
        $(tableId + ' .selectBox:checked').each(function() {
            ids.push($(this).data('id'));
        });
        if (ids.length > 0) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda ingin menghapus ' + entityName + ' yang dipilih?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#01509D',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(deleteUrl, { ids: ids }, function(response) {
                        Swal.fire({
                            icon: 'success',
                            text: entityName + ' yang dipilih telah dihapus.',
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const b = Swal.getHtmlContainer().querySelector('b');
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        });
                        table.ajax.reload(); // Reload DataTables
                    }).fail(function() {
                        Swal.fire({
                            icon: 'error',
                            text: 'Terjadi kesalahan saat menghapus ' + entityName + '.',
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const b = Swal.getHtmlContainer().querySelector('b');
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        });
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                text: 'Silakan pilih setidaknya satu ' + entityName + ' untuk dihapus.',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector('b');
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            });
        }
    });

    function getCategoryIdFromUrl() {
        var params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    $(addSelectedBtnId).on('click', function() {
        var ids = [];
        var category_id = getCategoryIdFromUrl(); 
        $(tableId + ' .selectBox:checked').each(function() {
            ids.push($(this).data('id'));
        });
        if (ids.length > 0) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda ingin menambah ' + entityName + ' yang dipilih?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#01509D',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tambah!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(addUrl, { ids: ids, category_id: category_id }, function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                text: entityName + ' telah dipilih.',
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const b = Swal.getHtmlContainer().querySelector('b');
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft();
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: response.message,
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const b = Swal.getHtmlContainer().querySelector('b');
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft();
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            });
                        }
                        table.ajax.reload(); // Reload DataTables
                    }, 'json');
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                text: 'Silakan pilih setidaknya satu ' + entityName + ' untuk ditambah.',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector('b');
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            });
        }
    });

    $(tableId + ' tbody').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Apakah Anda ingin menghapus ' + entityName + ' ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#01509D',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(deleteUrl, { id: id }, function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: entityName + ' telah dihapus.',
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const b = Swal.getHtmlContainer().querySelector('b');
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const b = Swal.getHtmlContainer().querySelector('b');
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        });
                    }
                    table.ajax.reload(); // Reload DataTables
                }, 'json');
            }
        });
    });

    $(formAddCategoryModal).on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.post(addUrl, formData, function(response) {
            $(addCategoryModal).modal('hide');
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    text: entityName + ' telah disimpan.',
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    text: response.message,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }
            table.ajax.reload();
        }, 'json');
    });

    $(tableId + ' tbody').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        $(editCategoryId).val(id);
        $(editCategoryName).val(nama);
        $(editCategoryModal).modal('show');
    });

    $(formEditCategoryModal).on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.post(editUrl, formData, function(response) {
            $(editCategoryModal).modal('hide');
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    text: entityName + ' telah diperbarui.',
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    text: response.message,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }
            table.ajax.reload();
        }, 'json');
    });
}

// ===================== Tambahan Kode Baru =====================

function showBook(bookUrl) {
    var iframeHtml = '<iframe src="' + bookUrl + '" style="width: 100%; height: 80vh;" frameborder="0"></iframe>';
    document.getElementById('bookContainer').innerHTML = iframeHtml;

    document.getElementById('bookCard').style.display = 'none';
    document.getElementById('detailCard').style.display = 'none';

    var detailCardContainer = document.getElementById('detailCardContainer');
    detailCardContainer.classList.remove('col-md-8');
    detailCardContainer.classList.add('col-lg-12');
}

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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.favoriteBtn').forEach(function(button) {
        button.addEventListener('click', function() {
            var bookId = this.getAttribute('data-id');
            if (button.classList.contains('text-danger')) {
                removeFavoriteBook(bookId, button);
            } else {
                addFavoriteBook(bookId, button);
            }
        });
    });

    document.querySelectorAll('.bookmarkBtn').forEach(function(button) {
        button.addEventListener('click', function() {
            var bookId = this.getAttribute('data-id');
            if (button.classList.contains('text-danger')) {
                removeBookmark(bookId, button);
            } else {
                addBookmark(bookId, button);
            }
        });
    });

    document.querySelectorAll('.removeBookmarkBtn').forEach(button => {
        button.addEventListener('click', function() {
            var bookId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Apakah Anda ingin menghapus buku dari penanda?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#01509D',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('remove_bookmark.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ book_id: bookId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Buku telah dihapus dari penanda.',
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const b = Swal.getHtmlContainer().querySelector('b');
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft();
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: 'Terjadi kesalahan saat menghapus buku dari penanda.',
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const b = Swal.getHtmlContainer().querySelector('b');
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft();
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            text: 'Terjadi kesalahan: ' + error,
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                const b = Swal.getHtmlContainer().querySelector('b');
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft();
                                }, 100);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        });
                    });
                }
            });
        });
    });
});

function addFavoriteBook(bookId, button) {
    fetch('add_favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ book_id: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.add('text-danger');
            button.querySelector('i').classList.remove('mdi-heart-outline');
            button.querySelector('i').classList.add('mdi-heart');
        }
    });
}

function removeFavoriteBook(bookId, button) {
    fetch('remove_favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ book_id: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.remove('text-danger');
            button.querySelector('i').classList.remove('mdi-heart');
            button.querySelector('i').classList.add('mdi-heart-outline');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            text: 'Terjadi kesalahan: ' + error,
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        });
    });
}

function addBookmark(bookId, button) {
    fetch('add_bookmark.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ book_id: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.add('text-danger');
            button.querySelector('i').classList.remove('mdi-bookmark-outline');
            button.querySelector('i').classList.add('mdi-bookmark');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            text: 'Terjadi kesalahan: ' + error,
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        });
    });
}

function removeBookmark(bookId, button) {
    fetch('remove_bookmark.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ book_id: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.remove('text-danger');
            button.querySelector('i').classList.remove('mdi-bookmark');
            button.querySelector('i').classList.add('mdi-bookmark-outline');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            text: 'Terjadi kesalahan: ' + error,
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft();
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        });
    });
}

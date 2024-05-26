



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
    // $('#editKategoriId').val(id);
    // $('#editNamaKategori').val(nama);
    // $('#editKategoriModal').modal('show');

    initializeDataTable('#addcategoryTable', 'add_book_categories_process.php', null, 'add_book_to_categories.php', null, 'Kategori', 5,null, '#selectAllCategories', '#addtoCategories', null, null, null, null, null, null);
    
    initializeDataTable('#addcategoryJTable', 'add_journalartikel_categories_process.php', null, 'add_journalartikel_to_categories.php', null, 'Kategori', 5,null, '#selectAllJToCategories', '#addtoJCategories', null, null, null, null, null, null);
});

function initializeDataTable(tableId, ajaxUrl, deleteUrl, addUrl, editUrl, entityName, totalColumn, renderButtons, selectAllId, addSelectedBtnId, deleteSelectedBtnId, formAddCategoryModal, formEditCategoryModal, addCategoryModal, editCategoryId, editCategoryName, editCategoryModal) {    

        // Set default values
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
                        Swal.fire(
                            'Terhapus!',
                            entityName + ' yang dipilih telah dihapus.',
                            'success'
                        );
                        table.ajax.reload(); // Reload DataTables
                    }).fail(function() {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus ' + entityName + '.',
                            'error'
                        );
                    });
                }
            });
        } else {
            Swal.fire(
                'Tidak ada pilihan',
                'Silakan pilih setidaknya satu ' + entityName + ' untuk dihapus.',
                'warning'
            );
        }
    });

    function getCategoryIdFromUrl() {
        var params = new URLSearchParams(window.location.search);
        return params.get('id');
    }
    // add to categories
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
                            Swal.fire(
                                'Terpilih!',
                                entityName + ' telah dipilih.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error',
                                response.message,
                                'error'
                            );
                        }
                        table.ajax.reload(); // Reload DataTables
                    }, 'json');
                }
            });
        } else {
            Swal.fire(
                'Tidak ada pilihan',
                'Silakan pilih setidaknya satu ' + entityName + ' untuk ditambah.',
                'warning'
            );
        }
    });


      // Handle delete button using event delegation
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
                        console.log(response);
                        Swal.fire(
                            'Terhapus!',
                            entityName + ' telah dihapus.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                    table.ajax.reload(); // Reload DataTables
                }, 'json');
            }
        });
    });

    // ====================== category ======================
    // Handle form submission for adding category
    $(formAddCategoryModal).on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.post(addUrl, formData, function(response) {
            $(addCategoryModal).modal('hide');
            if (response.status === 'success') {
                Swal.fire(
                    'Berhasil!',
                    entityName + ' telah disimpan.',
                    'success'
                );
            } else {
                Swal.fire(
                    'Error',
                    response.message,
                    'error'
                );
            }
            table.ajax.reload();
        }, 'json');
    });
    
    // Handle edit button
    $(tableId + ' tbody').on('click', '.editBtn', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        $(editCategoryId).val(id);
        $(editCategoryName).val(nama);
        $(editCategoryModal).modal('show');
    });
    
    // Handle form submission for editing category
    $(formEditCategoryModal).on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.post(editUrl, formData, function(response) {
            $(editCategoryModal).modal('hide');
            if (response.status === 'success') {
                Swal.fire(
                    'Berhasil!',
                    entityName + ' telah diperbarui.',
                    'success'
                );
            } else {
                Swal.fire(
                    'Error',
                    response.message,
                    'error'
                );
            }
            table.ajax.reload();
        }, 'json');
    });

    // ====================== End category ======================


}

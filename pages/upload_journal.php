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
$getjournalCategories = getCategories($conn);
?>
    <div class="main-panel">
        <div class="content-wrapper" id="initialContent">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-primary fw-bold" id="tab1-tab" data-bs-toggle="tab" href="#tab1" role="tab"
                                        aria-controls="tab1" aria-selected="true">
                                        Submissions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#tab2" role="tab"
                                        aria-controls="tab2" aria-selected="false">
                                        Active Submissions
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                    <h5 class="fw-bold mb-3">Informasi E-Journal GUBOOK Perpustakaan Digital</h5>
                                    <p>Perpustakaan digital saat ini telah menjadi rumah bagi beragam pengetahuan, termasuk hasil penelitian ilmiah yang diperoleh melalui Open Journal System (OJS). OJS yang disajikan di dalam GUBOOK Perpustakaan Digital ini menyediakan platform yang memungkinkan peneliti dan kontributor untuk mempublikasikan kajian mereka secara luas.</p>
                                    <p>Dengan fokus pada keilmuan, e-Journal GUBOOK Perpustakaan Digital mengakomodasi berbagai jenis penelitian, mulai dari kajian teori hingga penelitian empiris. Para peneliti dapat mengunggah makalah ilmiah mereka dalam berbagai disiplin ilmu, seperti sains, teknologi, kedokteran, ilmu sosial, humaniora, dan banyak lagi.</p>
                                    <p>Melalui e-Journal GUBOOK Perpustakaan Digital, para peneliti dapat dengan mudah mengakses dan membagikan temuan mereka kepada masyarakat ilmiah secara global. Selain itu, kontribusi dari para peneliti ini membantu memperkaya pengetahuan dan mendorong diskusi yang lebih dalam dalam berbagai bidang.</p>
                                    <p class="mt-3">Fitur utama dari e-Journal GUBOOK Perpustakaan Digital meliputi:</p>
                                    <ol>
                                        <li>Sistem manajemen artikel yang efisien: Memudahkan peneliti untuk mengunggah, mengedit, dan memantau status publikasi dari karya ilmiah mereka.</li>
                                        <li>Proses peer-review yang transparan: Memastikan kualitas dan validitas setiap artikel yang dipublikasikan melalui peninjauan oleh para pakar dalam bidang terkait.</li>
                                        <li>Akses terbuka (open access): Memungkinkan siapapun untuk mengakses dan membaca artikel-artikel yang diterbitkan tanpa batasan, mendorong diseminasi pengetahuan yang luas.</li>
                                        <li>Indeksasi yang luas: Menempatkan artikel-artikel yang dipublikasikan dalam e-Journal GUBOOK Perpustakaan Digital di berbagai basis data indeksasi ilmiah untuk meningkatkan visibilitas dan sitasi.</li>
                                    </ol>
                                    <p>Dengan komitmen untuk mempromosikan keterbukaan, kolaborasi, dan peningkatan dalam penelitian ilmiah, perpustakaan digital kami dengan bangga mempersembahkan e-Journal GUBOOK Perpustakaan Digital sebagai wadah bagi para peneliti dan kontributor untuk berbagi temuan mereka kepada dunia.</p>
                                    <div class="form-group mt-5">
                                        <button id="newSubmissionBtn" type="button" class="btn btn-light shadow-sm fw-bold me-3 mb-2">New Submission</button>
                                        <button type="button" class="btn btn-light shadow-sm fw-bold mb-2">Template Jurnal</button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                    <p>This is the content of Tab 2.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper d-none" id="formContent">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="fw-semibold">Formulir Tahap 1</h4>
                        </div>
                        <div class="card-body">
                            <h4>Submission Category</h4>
                            <select id="submissionCategory" class="form-select bg-primary text-white mb-3" aria-label="Default select example">
                              <?php foreach ($getjournalCategories as $category): ?>
                                <option value="<?= $category['nama_kategori']; ?>"><?= $category['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                              </select>
                              <h4>Submission Language</h4>
                            <select id="submissionLanguage" name="category" class="form-select bg-primary text-white mb-3" aria-label="Default select example">
                                <option value="Indonesia" selected>Indonesia</option>
                                <option value="English">English</option>
                            </select>
                            <h4>Submission Requirements</h4>
                            <div class="p-4 py-0">
                                <div class="form-check mb-2">
                                    <input class="form-check-input requirement-checkbox" type="checkbox" value="" id="requirement1">
                                    <label class="form-check-label" for="requirement1">
                                        Naskah yang ditulis dalam bahasa Indonesia dan mengikuti kaidah penulisan bahasa Indonesia yang benar sesuai EYD
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input requirement-checkbox" type="checkbox" value="" id="requirement2">
                                    <label class="form-check-label" for="requirement2">
                                        Format penulisan naskah mengikuti template pada GUBOOK Perpustakaan Digital. <a href="#" class="text-decoration-none">DOWNLOAD TEMPLATE</a>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input requirement-checkbox" type="checkbox" value="" id="requirement3">
                                    <label class="form-check-label" for="requirement3">
                                        Naskah belum pernah dipublikasikan melalui media publikasi lainnya dan dibuktikan dengan surat pernyataan keaslian jurnal. <a href="#" class="text-decoration-none">Download Surat Pernyataan Keaslian Jurnal</a>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input requirement-checkbox" type="checkbox" value="" id="requirement4">
                                    <label class="form-check-label" for="requirement4">
                                        Naskah yang dikirimkan berupa berkas dokumen dalam format OpenOffice, Microsoft Word, atau RTF. Disarankan menggunakan ekstensi .docx
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input requirement-checkbox" type="checkbox" value="" id="requirement5">
                                    <label class="form-check-label" for="requirement5">
                                        Naskah yang diperbolehkan memiliki similarity sebanyak maksimal 20%, dibuktikan dengan melampirkan laporan hasil pengecekan plagiarisme
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input requirement-checkbox" type="checkbox" value="" id="requirement6">
                                    <label class="form-check-label" for="requirement6">
                                        Mencantumkan secara lengkap inputan metadata naskah seperti judul, abstract, keywords, dan referensi
                                    </label>
                                </div>
                                <div class="d-flex justify-content-end mt-4">
                                    <button id="cancelBtn" class="btn btn-secondary me-2">Cancel</button>
                                    <button id="saveContinueBtn" class="btn btn-primary">Save & Continue</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper d-none" id="uploadContent">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="fw-semibold">Formulir Tahap 2</h4>
                        </div>
                        <div class="card-body">
                            <h4>Upload Submission</h4>
                            <?php
                            // Generate CSRF token
                            $csrf_token = bin2hex(random_bytes(32));
                            $_SESSION['csrf_token'] = $csrf_token;
                            ?>
                            <form class="dropzone" id="myDropzone" enctype="multipart/form-data">
                              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            </form>
                            <h4 id="success_message"></h4> 
                            <div class="text-muted mt-2">
                                Supported format: .docx | Max file: 2Mb
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button id="cancelUploadBtn" class="btn btn-secondary me-2">Cancel</button>
                                <button id="saveContinueBtn2" class="btn btn-primary">Save & Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper d-none" id="reviewContent">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-footer rounded-top d-flex justify-content-between align-items-center">
                          <p class="display-5 text-bold fw-semibold mb-0">Formulir Tahap 3</p>
                          <div>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                                <span class="mdi mdi-plus-circle-outline align-middle"></span> Tambah Author
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table id="tauthor" class="display">
                              <thead>
                                <tr>
                                  <th>Nama</th>
                                  <th>Email</th>
                                  <th>Affiliation</th>
                                  <th>Country</th>
                                </tr>
                            </table>
                          </div>
                          <div class="d-flex justify-content-end mt-4">
                              <button id="cancelAuthorBtn" class="btn btn-secondary me-2">Cancel</button>
                              <button id="saveContinueAuthor" class="btn btn-primary">Save & Continue</button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      <!-- Modal -->
      <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="addAuthorModalLabel">Tambah Author</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form id="addAuthorForm">
                          <div class="mb-3">
                              <label for="firstName" class="form-label">First Name</label>
                              <input type="text" class="form-control" id="firstName" placeholder="Masukkan nama">
                          </div>
                          <div class="mb-3">
                              <label for="middleName" class="form-label">Middle Name</label>
                              <input type="text" class="form-control" id="middleName" placeholder="Masukkan nama">
                          </div>
                          <div class="mb-3">
                              <label for="lastName" class="form-label">Last Name</label>
                              <input type="text" class="form-control" id="lastName" placeholder="Masukkan nama">
                          </div>
                          <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" class="form-control" id="email" placeholder="Masukkan email">
                          </div>
                          <div class="mb-3">
                              <label for="affiliation" class="form-label">Affiliation</label>
                              <input type="text" class="form-control" id="affiliation" placeholder="Masukkan affiliation">
                          </div>
                          <div class="mb-3">
                              <label for="country" class="form-label">Country</label>
                              <select class="form-select bg-primary text-white mb-3" id="country" aria-label="Default select example">
                                  <option selected>Pilih negara</option>
                                  <option value="Indonesia">Indonesia</option>
                                  <option value="Malaysia">Malaysia</option>
                                  <option value="Singapura">Singapura</option>
                                  <option value="Thailand">Thailand</option>
                                  <option value="Vietnam">Vietnam</option>
                              </select>
                          </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>


    <div class="content-wrapper d-none" id="contentUpload">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="fw-semibold">Formulir Tahap 3.5</h4>
                        </div>
                        <div class="card-body">
                          <div class="row mb-3">
                            <div class="col">
                              <label for="title" class="form-label">Title</label>
                              <input type="text" class="form-control" id="title" placeholder="Title">
                            </div>
                            <div class="col">
                              <label for="subtitle" class="form-label">Subtitle</label>
                              <input type="text" class="form-control" id="subtitle" placeholder="Subtitle">
                            </div>
                          </div>
                          <div class="mb-3">
                            <label for="abstract" class="form-label">Abstract</label>
                            <textarea class="form-control" id="abstract" rows="4" placeholder="Abstract" style="height: 100px"></textarea>
                          </div>
                          <h5 class="fw-semibold mt-4">Additional Refinements</h5>
                          <div class="mb-3">
                            <label for="keyword" class="form-label">Keyword</label>
                            <input type="text" class="form-control" id="keyword" placeholder="Keyword">
                          </div>
                          <div class="mb-3">
                            <label for="references" class="form-label">References</label>
                            <input type="text" class="form-control" id="references" placeholder="References">
                          </div>
                          <div class="d-flex justify-content-end mt-4">
                            <button id="cancelDescBtn" class="btn btn-secondary me-2" type="button">Cancel</button>
                            <button id="saveDescBtn" class="btn btn-primary" type="submit">Save & Continue</button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper d-none" id="uploadSum">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="fw-semibold">Formulir Tahap 4</h4>
                        </div>
                        <div class="card-body">
                            <h4>Upload Submission</h4>
                            <?php
                            // Generate CSRF token
                            $csrf_token = bin2hex(random_bytes(32));
                            $_SESSION['csrf_token'] = $csrf_token;
                            ?>
                            <form class="dropzone" id="myDropzonepdf" enctype="multipart/form-data">
                              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            </form>
                            <h4 id="success_message"></h4> 
                            <div class="text-muted mt-2">
                                Supported format: .pdf | Max file: 2Mb
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button id="cancelUploadPdfBtn" class="btn btn-secondary me-2">Cancel</button>
                                <button id="submitFinalBtn" class="btn btn-primary">Finish Submission</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>
          document.addEventListener("DOMContentLoaded", function() {
            Dropzone.options.myDropzone = {
                url: "tahap_2.php",
                autoProcessQueue: true,
                paramName: "file",
                maxFilesize: 2,
                maxFiles: 1,
                acceptedFiles: ".docx",
                addRemoveLinks: false,
                dictDefaultMessage: "Drag and drop atau klik di sini untuk mengunggah file",
                init: function() {
                    this.on("success", function(file, responseText) {
                        var response = JSON.parse(responseText);
                        if (response.error) {
                            var errorMessage = document.createElement('div');
                            errorMessage.classList.add('dz-error-message');
                            errorMessage.textContent = response.error;
                            file.previewElement.appendChild(errorMessage);
                        } else {
                          var successMessage = document.createElement('div');
                          successMessage.classList.add('dz-success-message');
                          successMessage.innerHTML = `${response.success}<br>${response.time}<br>${response.date}`;
                          file.previewElement.appendChild(successMessage);
                        }
                    });
                    this.on("error", function(file, responseText) {
                      Swal.fire({
                        icon: 'error',
                        text: 'File tidak valid',
                        timer: 1000,
                        showConfirmButton: false
                      });
                        this.removeFile(file);
                    });
                },
            };


            new DataTable('#tauthor', {
            ajax: 'table_author_process.php',
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                  "searchable": false,
                  "orderable": false,
                }
            ]
          });
        });


          document.addEventListener("DOMContentLoaded", function() {
            Dropzone.options.myDropzonepdf = {
                url: "upload_file_pdf.php",
                autoProcessQueue: true,
                paramName: "file",
                maxFilesize: 2,
                maxFiles: 1,
                acceptedFiles: ".pdf",
                addRemoveLinks: false,
                dictDefaultMessage: "Drag and drop atau klik di sini untuk mengunggah file",
                init: function() {
                    this.on("success", function(file, responseText) {
                        var response = JSON.parse(responseText);
                        if (response.error) {
                            var errorMessage = document.createElement('div');
                            errorMessage.classList.add('dz-error-message');
                            errorMessage.textContent = response.error;
                            file.previewElement.appendChild(errorMessage);
                        } else {
                          var successMessage = document.createElement('div');
                          successMessage.classList.add('dz-success-message');
                          successMessage.innerHTML = `${response.success}<br>${response.time}<br>${response.date}`;
                          file.previewElement.appendChild(successMessage);
                        }
                    });
                    this.on("error", function(file, responseText) {
                      Swal.fire({
                        icon: 'error',
                        text: 'File tidak valid',
                        timer: 1000,
                        showConfirmButton: false
                      });
                        this.removeFile(file);
                    });
                },
            };
        });

        document.getElementById('newSubmissionBtn').addEventListener('click', function() {
            document.getElementById('initialContent').classList.add('d-none');
            document.getElementById('formContent').classList.remove('d-none');
        });

        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('formContent').classList.add('d-none');
            document.getElementById('initialContent').classList.remove('d-none');
        });

        document.getElementById('saveContinueBtn').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.requirement-checkbox');
            let allChecked = true;

            // checkboxes.forEach((checkbox) => {
            //     if (!checkbox.checked) {
            //         allChecked = false;
            //     }
            // });

            if (!allChecked) {
                Swal.fire({
                  icon: 'error',
                  text: 'Requirements tidak valid',
                  timer: 1000,
                  showConfirmButton: false
                });
            } else {
                document.getElementById('formContent').classList.add('d-none');
                document.getElementById('uploadContent').classList.remove('d-none');
            }
        });

        document.getElementById('cancelUploadBtn').addEventListener('click', function() {
            document.getElementById('uploadContent').classList.add('d-none');
            document.getElementById('formContent').classList.remove('d-none');
        });

        document.getElementById('saveContinueBtn2').addEventListener('click', function() {
            document.getElementById('uploadContent').classList.add('d-none');
            document.getElementById('reviewContent').classList.remove('d-none');
        });

        document.getElementById('cancelAuthorBtn').addEventListener('click', function() {
            document.getElementById('reviewContent').classList.add('d-none');
            document.getElementById('uploadContent').classList.remove('d-none');
        });

        document.getElementById('saveContinueAuthor').addEventListener('click', function() {
            document.getElementById('reviewContent').classList.add('d-none');
            document.getElementById('contentUpload').classList.remove('d-none');
        });

        document.getElementById('cancelDescBtn').addEventListener('click', function() {
            document.getElementById('contentUpload').classList.add('d-none');
            document.getElementById('reviewContent').classList.remove('d-none');
        });
        
        document.getElementById('saveDescBtn').addEventListener('click', function() {
          document.getElementById('contentUpload').classList.add('d-none');
          document.getElementById('uploadSum').classList.remove('d-none');
        });
        
        document.getElementById('cancelUploadPdfBtn').addEventListener('click', function() {
            document.getElementById('uploadSum').classList.add('d-none');
            document.getElementById('contentUpload').classList.remove('d-none');
        });

        document.getElementById('submitFinalBtn').addEventListener('click', function() {
            Swal.fire({
              icon: 'success',
              text: 'Submission berhasil!',
              timer: 2000,
              showConfirmButton: false
            }).then(() => {
                document.getElementById('uploadSum').classList.add('d-none');
                document.getElementById('initialContent').classList.remove('d-none');
            });

        });

        document.getElementById('newSubmissionBtn').addEventListener('click', function(event) {
          event.preventDefault();
          
          fetch('new_submission.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  Swal.fire({
                      icon: 'success',
                      text: 'Submission berhasil dibuat!',
                      timer: 2000,
                      showConfirmButton: false
                  }).then(() => {
                      document.getElementById('initialContent').classList.add('d-none');
                      document.getElementById('formContent').classList.remove('d-none');
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      text: data.message,
                      timer: 2000,
                      showConfirmButton: false
                  });
              }
          })
          .catch(error => {
              Swal.fire({
                  icon: 'error',
                  text: 'Terjadi kesalahan saat membuat submission.',
                  timer: 2000,
                  showConfirmButton: false
              });
          });
      });

      document.getElementById('saveContinueBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        const category = document.getElementById('submissionCategory').value;
        const language = document.getElementById('submissionLanguage').value;

        const formData = new FormData();
        formData.append('category', category);
        formData.append('language', language);

        fetch('tahap_1.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    text: 'Data berhasil disimpan!',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    document.getElementById('formContent').classList.add('d-none');
                    document.getElementById('uploadContent').classList.remove('d-none');
                });
            } 
        });
    });


    document.getElementById('addAuthorForm').addEventListener('submit', function(event) {
          event.preventDefault();
          
          const firstName = document.getElementById('firstName').value;
          const middleName = document.getElementById('middleName').value;
          const lastName = document.getElementById('lastName').value;
          const email = document.getElementById('email').value;
          const affiliation = document.getElementById('affiliation').value;
          const country = document.getElementById('country').value;

          const formData = new FormData();
          formData.append('first_name', firstName);
          formData.append('middle_name', middleName);
          formData.append('last_name', lastName);
          formData.append('email', email);
          formData.append('affiliation', affiliation);
          formData.append('country', country);

          fetch('tahap_3.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  Swal.fire({
                      icon: 'success',
                      text: 'Data author berhasil ditambahkan!',
                      timer: 2000,
                      showConfirmButton: false
                  }).then(() => {
                      document.getElementById('addAuthorForm').reset();
                      $('#addAuthorModal').modal('hide');
                      $('#tauthor').DataTable().ajax.reload();
                  });
              } else {
                  Swal.fire({
                      icon: 'error',
                      text: data.message,
                      timer: 2000,
                      showConfirmButton: false
                  });
              }
          })
          .catch(error => {
              Swal.fire({
                  icon: 'error',
                  text: 'Terjadi kesalahan saat mengirim data.',
                  timer: 2000,
                  showConfirmButton: false
              });
          });
      });

    </script>
<?php require_once TEMPLATE_PATH . '/footer.php'; ?>

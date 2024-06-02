<?php
require_once FUNCTIONS_PATH . 'functions.php';

// Ambil daftar kategori
$bookCategories = getCategoriesBook($conn);
$journalCategories = getCategoriesJournalArticel($conn);
?>
  
  <!-- partial:partials/_navbar.html -->
   <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="index.php">
            <img src="<?= BASE_URL ?>assets/images/gubook.svg" alt="logo" style="height:100px; margin-top:2px;"/>
          </a>
          <a class="navbar-brand brand-logo-mini d-none" href="index.html">
            <img src="images/logo-mini.svg" alt="logo" />
          </a>
        </div>
      </div>
      
      <div class="navbar-menu-wrapper d-flex align-items-top"> 
      <nav class="nav justify-content-center" aria-label="Secondary navigation">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Select Category
            </a>
            <ul class="dropdown-menu">
            <li class="dropdown-submenu">
                <a class="dropdown-item" href="#"> Buku <span class="float-end custom-toggle-arrow">&#187</span></a>
                <ul class="dropdown-menu">
                    <?php foreach ($bookCategories as $category): ?>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/index.php?category=<?= urlencode($category) ?>&type=book"><?= htmlspecialchars($category) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a class="dropdown-item" href="#"> Journal & Artikel <span class="float-end custom-toggle-arrow">&#187</span></a>
                <ul class="dropdown-menu">
                    <?php foreach ($journalCategories as $category): ?>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/index.php?category=<?= urlencode($category) ?>&type=journal&artikel"><?= htmlspecialchars($category) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            </ul>
        </li>
    </nav>

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              
        <li class="nav-item">
            <form class="search-form" action="<?= BASE_URL ?>pages/index.php" method="GET">
                <i class="icon-search"></i>
                <input type="search" name="search" class="form-control" placeholder="Search Here" title="Search here">
                <input type="hidden" name="type" value="search">
            </form>
        </li>


          <li class="nav-item dropdown"> 
            <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="icon-bell"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
              <a class="dropdown-item py-3">
                <p class="mb-0 font-weight-medium float-left">You have 1 unread mails </p>
                <span class="badge badge-pill badge-primary float-right">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="https://i.pinimg.com/736x/d3/30/d9/d330d9d6ca79833cde7bdd54ad2aea92.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis font-weight-medium text-dark">Tubagus Ganteng</p>
                  <p class="fw-light small-text mb-0"> LARIIIIIIII ADA METEORRRR   </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-account-circle" style="font-size: 2rem;"></i>
            </a>
            <!-- <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-md rounded-circle" src="images/faces/face8.jpg" alt="Profile image">
                <p class="mb-1 mt-3 font-weight-semibold">Allen Moreno</p>
                <p class="fw-light text-muted mb-0">allenmoreno@gmail.com</p>
              </div>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
            </div> -->
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
          </li>
        </ul>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
              <form class="form w-100">
                <div class="form-group d-flex">
                  <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                </div>
              </form>
            </div>
            <div class="list-wrapper px-3">
              <ul class="d-flex flex-column-reverse todo-list">
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Team review meeting at 3.00 PM
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Prepare for presentation
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Resolve all the low priority tickets due today
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Schedule meeting for next week
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Project review
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
              </ul>
            </div>
            <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 11 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
              <p class="text-gray mb-0">The total number of sessions</p>
            </div>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 7 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
              <p class="text-gray mb-0 ">Call Sarah Graves</p>
            </div>
          </div>
          <!-- To do section tab ends -->
          <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
              <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
            </div>
            <ul class="chat-list">
              <li class="list active">
                <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Thomas Douglas</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">19 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <div class="wrapper d-flex">
                    <p>Catherine</p>
                  </div>
                  <p>Away</p>
                </div>
                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                <small class="text-muted my-auto">23 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Daniel Russell</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">14 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <p>James Richardson</p>
                  <p>Away</p>
                </div>
                <small class="text-muted my-auto">2 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Madeline Kennedy</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">5 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Sarah Graves</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">47 min</small>
              </li>
            </ul>
          </div>
          <!-- chat tab ends -->
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">

        <li class="nav-item nav-category">Menu</li>
        <?php if(isset($_SESSION['admin'])): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL . 'pages/admin/books/manage_books.php';?>">
                <i class="mdi mdi-library-books menu-icon"></i>
                <span class="menu-title">Mengelola Buku</span>
                <i class="menu-arrow"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL . 'pages/admin/journal/manage_journals.php';?>">
                <i class="mdi mdi-book-multiple menu-icon"></i>
                <span class="menu-title">Mengelola Journal</span>
                <i class="menu-arrow"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="charts">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Mengelola Kategori</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL . 'pages/admin/category/books/manage_categories.php';?>">Buku</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= BASE_URL . 'pages/admin/category/journal_artikel/manage_categories.php';?>">Journal & Artikel</a></li>
              </ul>
            </div>
        </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="mdi mdi-home-variant menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                <i class="menu-arrow"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="upload_journal.php">
                <i class="mdi mdi-book-multiple menu-icon"></i>
                <span class="menu-title">Upload Journal</span>
                <i class="menu-arrow"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_bookmark.php">
                <i class="mdi mdi-bookmark-outline menu-icon"></i>
                <span class="menu-title">Penanda Buku</span>
                <i class="menu-arrow"></i> 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_favorite.php">
                <i class="mdi mdi-heart-outline menu-icon"></i>
                <span class="menu-title">Favorit</span>
                <i class="menu-arrow"></i> 
            </a>
        </li>
        <?php endif; ?>
        <li class="nav-item nav-category">Logout</li>
        <li class="nav-item">
          <a class="nav-link" id="logoutLink" data-bs-toggle="collapse" href="#ui-logout" aria-expanded="false" aria-controls="ui-logout">
              <i class="mdi mdi-logout menu-icon"></i>
              <span class="menu-title">Logout</span>
              <i class="menu-arrow"></i> 
          </a>
      </li>
         
        </ul>
      </nav>
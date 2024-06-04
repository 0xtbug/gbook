<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="base-url" content="<?= BASE_URL; ?>">
  <title>Gubook</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= BASE_URL;?>assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?= BASE_URL;?>assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL;?>assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?= BASE_URL;?>assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?= BASE_URL;?>assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?= BASE_URL;?>assets/vendors/css/vendor.bundle.base.css">
  
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
   <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?= BASE_URL;?>assets/css/vertical-layout-light/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= BASE_URL;?>assets/images/favicon.png" />
</head>
<style>

.dropdown:hover >.dropdown-menu{
  display: block !important;
}
.dropdown-submenu:hover > .dropdown-menu{
  display: block !important;
    left: 100%;
    margin-top: -37px;
}

.dropdown-item{
  font-size: small; /* 13px */
}
.dropdown-toggle::after{
  font-size: var(--font-md);
  margin-bottom: -20px;
}
.dropdown-menu li a.active{
  color:#fff;
}

.custom-toggle-arrow{
      font-size: 18px;
      margin-top: 1px;
      line-height: 12px;
}
.review-stars span {
        cursor: pointer; /* Menambahkan gaya cursor pointer */
}
.dz-success-mark svg, .dz-error-mark svg {
            display: none;
        }
        .dz-preview.dz-success .dz-success-mark {
            display: block;
        }
        .dz-preview .dz-success-mark {
            display: none;
        }
        .dz-preview .dz-error-mark {
            display: none;
        }
        .dz-preview .dz-progress {
            display: none;
        }
        .dz-preview.dz-success .dz-details {
            border: 1px solid #4caf50;
            border-radius: 5px;
            padding: 10px;
            background: #e8f5e9;
        }
        .dz-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dz-details .dz-filename {
            display: flex;
            align-items: center;
        }
        .dz-details .dz-filename span {
            margin-left: 10px;
        }
        .dz-size, .dz-remove {
            display: flex;
            align-items: center;
            color: #555;
        }
        .dz-remove {
            background: none;
            border: none;
            color: red;
        }
</style>
<body>

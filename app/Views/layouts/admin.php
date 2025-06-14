<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'PressStarter' ?> | Admin Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Summernote -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= base_url('assets/img/logo.png') ?>" alt="PressStarter" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url() ?>" class="nav-link" target="_blank">Lihat Website</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
          <?= session()->get('full_name') ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="<?= base_url('admin/profile') ?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('auth/logout') ?>" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('admin/dashboard') ?>" class="brand-link">
      <img src="<?= base_url('assets/img/logo.png') ?>" alt="PressStarter" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">PressStarter</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if (session()->get('avatar')): ?>
            <img src="<?= base_url('uploads/avatars/' . session()->get('avatar')) ?>" class="img-circle elevation-2" alt="User Image">
          <?php else: ?>
            <img src="https://via.placeholder.com/160x160/28a745/fff?text=<?= substr(session()->get('full_name'), 0, 1) ?>" class="img-circle elevation-2" alt="User Image">
          <?php endif; ?>
        </div>
        <div class="info">
          <a href="<?= base_url('admin/profile') ?>" class="d-block"><?= session()->get('full_name') ?></a>
          <small class="text-muted"><?= ucfirst(session()->get('role')) ?></small>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?= base_url('admin/news') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/news') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>Kelola Berita</p>
            </a>
          </li>

          <?php if (in_array(session()->get('role'), ['admin', 'editor'])): ?>
          <li class="nav-item">
            <a href="<?= base_url('admin/news/pending') ?>" class="nav-link <?= (uri_string() == 'admin/news/pending') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-clock"></i>
              <p>
                Berita Pending
                <?php 
                $newsModel = new \App\Models\NewsModel();
                $pendingCount = $newsModel->where('status', 'pending')->countAllResults();
                if ($pendingCount > 0): 
                ?>
                <span class="badge badge-warning right"><?= $pendingCount ?></span>
                <?php endif; ?>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('admin/categories') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/categories') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tags"></i>
              <p>Kelola Kategori</p>
            </a>
          </li>
          <?php endif; ?>

          <?php if (session()->get('role') == 'admin'): ?>
          <li class="nav-item">
            <a href="<?= base_url('admin/users') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Kelola User</p>
            </a>
          </li>
          <?php endif; ?>

          <li class="nav-header">ACCOUNT</li>
          <li class="nav-item">
            <a href="<?= base_url('admin/profile') ?>" class="nav-link <?= (uri_string() == 'admin/profile') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>Profile</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('auth/logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= $title ?? 'Dashboard' ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?? 'Dashboard' ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fas fa-check"></i> <?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fas fa-ban"></i> <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
        
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#">PressStarter</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Summernote
    $('.summernote').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html>


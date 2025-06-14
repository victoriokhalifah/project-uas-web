<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url() ?>" class="h1"><b>Press</b>Starter</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Lupa password? Masukkan email Anda untuk reset password.</p>

      <!-- Flash Messages -->
      <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= session()->getFlashdata('success') ?>
      </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= session()->getFlashdata('error') ?>
      </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/forgot-password') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?= base_url('auth/login') ?>">Kembali ke login</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<?= $this->endSection() ?>


<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url() ?>" class="h1"><b>Press</b>Starter</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Reset password Anda</p>

      <!-- Flash Messages -->
      <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= session()->getFlashdata('error') ?>
      </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/reset-password/' . $token) ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                 placeholder="Password Baru" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <?php if (isset($validation) && $validation->hasError('password')): ?>
          <div class="invalid-feedback">
            <?= $validation->getError('password') ?>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="password_confirm" class="form-control <?= isset($validation) && $validation->hasError('password_confirm') ? 'is-invalid' : '' ?>" 
                 placeholder="Konfirmasi Password Baru" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
          <div class="invalid-feedback">
            <?= $validation->getError('password_confirm') ?>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
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

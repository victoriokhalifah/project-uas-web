<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url() ?>" class="h1"><b>Berita</b>tor</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>

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

      <form action="<?= base_url('auth/login') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="input-group mb-3">
          <input type="text" name="login" class="form-control <?= isset($validation) && $validation->hasError('login') ? 'is-invalid' : '' ?>" 
                 placeholder="Email atau Username" value="<?= old('login') ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <?php if (isset($validation) && $validation->hasError('login')): ?>
          <div class="invalid-feedback">
            <?= $validation->getError('login') ?>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                 placeholder="Password" required>
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
        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" value="1">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
        </div>
      </form>

      <p class="mb-1">
        <a href="<?= base_url('auth/forgot-password') ?>">Lupa password?</a>
      </p>
      <p class="mb-0">
        <a href="<?= base_url('auth/register') ?>" class="text-center">Daftar akun baru</a>
      </p>
      
      <div class="text-center mt-3">
        <p class="mb-1">
          <small class="text-muted">Demo Accounts:</small><br>
          <small>Admin: admin@beritator.com / admin123</small><br>
          <small>Editor: editor@beritator.com / editor123</small><br>
          <small>Wartawan: wartawan@beritator.com / wartawan123</small>
        </p>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<?= $this->endSection() ?>

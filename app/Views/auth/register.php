<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url() ?>" class="h1"><b>Berita</b>tor</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Daftar akun baru</p>

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

      <form action="<?= base_url('auth/register') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="input-group mb-3">
          <input type="text" name="full_name" class="form-control <?= isset($validation) && $validation->hasError('full_name') ? 'is-invalid' : '' ?>" 
                 placeholder="Nama Lengkap" value="<?= old('full_name') ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <?php if (isset($validation) && $validation->hasError('full_name')): ?>
          <div class="invalid-feedback">
            <?= $validation->getError('full_name') ?>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                 placeholder="Username" value="<?= old('username') ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-circle"></span>
            </div>
          </div>
          <?php if (isset($validation) && $validation->hasError('username')): ?>
          <div class="invalid-feedback">
            <?= $validation->getError('username') ?>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                 placeholder="Email" value="<?= old('email') ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          <?php if (isset($validation) && $validation->hasError('email')): ?>
          <div class="invalid-feedback">
            <?= $validation->getError('email') ?>
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
        
        <div class="input-group mb-3">
          <input type="password" name="password_confirm" class="form-control <?= isset($validation) && $validation->hasError('password_confirm') ? 'is-invalid' : '' ?>" 
                 placeholder="Konfirmasi Password" required>
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
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
               Saya setuju dengan <a href="#">syarat dan ketentuan</a>
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
          </div>
        </div>
      </form>

      <a href="<?= base_url('auth/login') ?>" class="text-center">Sudah punya akun? Masuk di sini</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<?= $this->endSection() ?>

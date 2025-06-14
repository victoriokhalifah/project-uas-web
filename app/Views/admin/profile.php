<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Profile</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="<?= base_url('admin/profile') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
          
          <!-- Avatar -->
          <div class="form-group text-center">
            <div class="mb-3">
              <?php if ($user['avatar']): ?>
                <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" 
                     class="img-circle" width="100" height="100" alt="Avatar">
              <?php else: ?>
                <img src="https://via.placeholder.com/100x100/28a745/fff?text=<?= substr($user['full_name'], 0, 1) ?>" 
                     class="img-circle" width="100" height="100" alt="Avatar">
              <?php endif; ?>
            </div>
            <div class="form-group">
              <label for="avatar">Ganti Avatar</label>
              <input type="file" class="form-control-file" id="avatar" name="avatar" accept="image/*">
              <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
            </div>
          </div>

          <div class="form-group">
            <label for="full_name">Nama Lengkap</label>
            <input type="text" class="form-control <?= isset($validation) && $validation->hasError('full_name') ? 'is-invalid' : '' ?>" 
                   id="full_name" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required>
            <?php if (isset($validation) && $validation->hasError('full_name')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('full_name') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
                   id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
            <?php if (isset($validation) && $validation->hasError('username')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('username') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                   id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
            <?php if (isset($validation) && $validation->hasError('email')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('email') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="password">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                   id="password" name="password">
            <?php if (isset($validation) && $validation->hasError('password')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('password') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="password_confirm">Konfirmasi Password Baru</label>
            <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password_confirm') ? 'is-invalid' : '' ?>" 
                   id="password_confirm" name="password_confirm">
            <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('password_confirm') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label>Role</label>
            <input type="text" class="form-control" value="<?= ucfirst($user['role']) ?>" readonly>
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Update Profile</button>
          <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
</div>
<?= $this->endSection() ?>

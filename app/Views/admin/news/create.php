<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tambah Berita Baru</h3>
      </div>
      <!-- /.card-header -->
      <form action="<?= base_url('admin/news/create') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
          
          <div class="form-group">
            <label for="title">Judul Berita</label>
            <input type="text" class="form-control <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                   id="title" name="title" value="<?= old('title') ?>" required>
            <?php if (isset($validation) && $validation->hasError('title')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('title') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="category_id">Kategori</label>
            <select class="form-control <?= isset($validation) && $validation->hasError('category_id') ? 'is-invalid' : '' ?>" 
                    id="category_id" name="category_id" required>
              <option value="">Pilih Kategori</option>
              <?php foreach ($categories as $category): ?>
              <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                <?= esc($category['name']) ?>
              </option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($validation) && $validation->hasError('category_id')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('category_id') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="featured_image">Gambar Utama</label>
            <input type="file" class="form-control-file" id="featured_image" name="featured_image" accept="image/*">
            <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 5MB</small>
          </div>

          <div class="form-group">
            <label for="content">Konten Berita</label>
            <textarea class="form-control summernote <?= isset($validation) && $validation->hasError('content') ? 'is-invalid' : '' ?>" 
                      id="content" name="content" rows="10" required><?= old('content') ?></textarea>
            <?php if (isset($validation) && $validation->hasError('content')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('content') ?>
            </div>
            <?php endif; ?>
          </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan sebagai Draft
          </button>
          <a href="<?= base_url('admin/news') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>
</div>
<?= $this->endSection() ?>

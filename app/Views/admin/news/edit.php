<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Edit Berita</h3>
      </div>
      <!-- /.card-header -->
      <form action="<?= base_url('admin/news/edit/' . $news['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body">
          
          <div class="form-group">
            <label for="title">Judul Berita</label>
            <input type="text" class="form-control <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                   id="title" name="title" value="<?= old('title', $news['title']) ?>" required>
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
              <option value="<?= $category['id'] ?>" 
                      <?= old('category_id', $news['category_id']) == $category['id'] ? 'selected' : '' ?>>
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
            <?php if ($news['featured_image']): ?>
            <div class="mb-2">
              <img src="<?= base_url('uploads/news/' . $news['featured_image']) ?>" 
                   class="img-thumbnail" width="200" alt="Current Image">
              <p class="text-muted">Gambar saat ini</p>
            </div>
            <?php endif; ?>
            <input type="file" class="form-control-file" id="featured_image" name="featured_image" accept="image/*">
            <small class="form-text text-muted">Format: JPG, PNG, GIF. Max: 5MB. Kosongkan jika tidak ingin mengubah gambar.</small>
          </div>

          <div class="form-group">
            <label for="content">Konten Berita</label>
            <textarea class="form-control summernote <?= isset($validation) && $validation->hasError('content') ? 'is-invalid' : '' ?>" 
                      id="content" name="content" rows="10" required><?= old('content', $news['content']) ?></textarea>
            <?php if (isset($validation) && $validation->hasError('content')): ?>
            <div class="invalid-feedback">
              <?= $validation->getError('content') ?>
            </div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label>Status Saat Ini</label>
            <input type="text" class="form-control" value="<?= ucfirst($news['status']) ?>" readonly>
          </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Berita
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

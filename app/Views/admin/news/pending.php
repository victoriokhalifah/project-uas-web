<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Berita Pending Review</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <?php if (!empty($news)): ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tanggal Submit</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($news as $index => $item): ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td>
                  <strong><?= esc($item['title']) ?></strong>
                  <?php if ($item['featured_image']): ?>
                  <br><small class="text-muted"><i class="fas fa-image"></i> Ada gambar</small>
                  <?php endif; ?>
                  <br><small class="text-muted"><?= esc(substr(strip_tags($item['content']), 0, 100)) ?>...</small>
                </td>
                <td>
                  <span class="badge badge-primary"><?= esc($item['category_name']) ?></span>
                </td>
                <td><?= esc($item['author_name']) ?></td>
                <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="<?= base_url('admin/news/edit/' . $item['id']) ?>" 
                       class="btn btn-info btn-sm" title="Preview">
                      <i class="fas fa-eye"></i>
                    </a>
                    
                    <a href="<?= base_url('admin/news/approve/' . $item['id']) ?>" 
                       class="btn btn-success btn-sm" title="Approve & Publish"
                       onclick="return confirm('Approve dan publish berita ini?')">
                      <i class="fas fa-check"></i>
                    </a>
                    
                    <a href="<?= base_url('admin/news/reject/' . $item['id']) ?>" 
                       class="btn btn-danger btn-sm" title="Reject"
                       onclick="return confirm('Reject berita ini?')">
                      <i class="fas fa-times"></i>
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> Tidak ada berita yang pending review.
        </div>
        <?php endif; ?>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Berita</h3>
        <div class="card-tools">
          <a href="<?= base_url('admin/news/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Berita
          </a>
        </div>
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
                <th>Status</th>
                <th>Views</th>
                <th>Tanggal</th>
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
                </td>
                <td>
                  <span class="badge badge-primary"><?= esc($item['category_name']) ?></span>
                </td>
                <td><?= esc($item['author_name']) ?></td>
                <td>
                  <?php
                  $statusClass = [
                    'draft' => 'secondary',
                    'pending' => 'warning',
                    'published' => 'success',
                    'rejected' => 'danger'
                  ];
                  ?>
                  <span class="badge badge-<?= $statusClass[$item['status']] ?>">
                    <?= ucfirst($item['status']) ?>
                  </span>
                </td>
                <td><?= number_format($item['views']) ?></td>
                <td><?= date('d M Y', strtotime($item['created_at'])) ?></td>
                <td>
                  <div class="btn-group" role="group">
                    <?php if ($item['status'] == 'published'): ?>
                    <a href="<?= base_url('news/' . $item['slug']) ?>" target="_blank" 
                       class="btn btn-info btn-sm" title="Lihat">
                      <i class="fas fa-eye"></i>
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('admin/news/edit/' . $item['id']) ?>" 
                       class="btn btn-warning btn-sm" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    
                    <?php if ($item['status'] == 'draft' && (session()->get('role') == 'wartawan' && $item['author_id'] == session()->get('user_id'))): ?>
                    <a href="<?= base_url('admin/news/submit/' . $item['id']) ?>" 
                       class="btn btn-primary btn-sm" title="Submit untuk Review"
                       onclick="return confirm('Submit berita untuk review?')">
                      <i class="fas fa-paper-plane"></i>
                    </a>
                    <?php endif; ?>
                    
                    <?php if (session()->get('role') == 'admin' || (session()->get('role') == 'wartawan' && $item['author_id'] == session()->get('user_id'))): ?>
                    <a href="<?= base_url('admin/news/delete/' . $item['id']) ?>" 
                       class="btn btn-danger btn-sm" title="Hapus"
                       onclick="return confirm('Yakin ingin menghapus berita ini?')">
                      <i class="fas fa-trash"></i>
                    </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> Belum ada berita. 
          <a href="<?= base_url('admin/news/create') ?>">Buat berita pertama</a>
        </div>
        <?php endif; ?>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
<?= $this->endSection() ?>

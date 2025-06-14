<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= $total_news ?></h3>
        <p>Total Berita</p>
      </div>
      <div class="icon">
        <i class="fas fa-newspaper"></i>
      </div>
      <a href="<?= base_url('admin/news') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= $published_news ?></h3>
        <p>Berita Published</p>
      </div>
      <div class="icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <a href="<?= base_url('admin/news') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?= $pending_news ?></h3>
        <p>Berita Pending</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
      <a href="<?= base_url('admin/news/pending') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= $total_users ?></h3>
        <p>Total Users</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <?php if (session()->get('role') == 'admin'): ?>
      <a href="<?= base_url('admin/users') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      <?php else: ?>
      <div class="small-box-footer">&nbsp;</div>
      <?php endif; ?>
    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->

<!-- Additional Statistics -->
<div class="row">
  <div class="col-lg-4 col-6">
    <div class="small-box bg-primary">
      <div class="inner">
        <h3><?= number_format($total_views) ?></h3>
        <p>Total Views</p>
      </div>
      <div class="icon">
        <i class="fas fa-eye"></i>
      </div>
      <div class="small-box-footer">&nbsp;</div>
    </div>
  </div>
  
  <div class="col-lg-4 col-6">
    <div class="small-box bg-secondary">
      <div class="inner">
        <h3><?= $total_categories ?></h3>
        <p>Total Kategori</p>
      </div>
      <div class="icon">
        <i class="fas fa-tags"></i>
      </div>
      <?php if (in_array(session()->get('role'), ['admin', 'editor'])): ?>
      <a href="<?= base_url('admin/categories') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      <?php else: ?>
      <div class="small-box-footer">&nbsp;</div>
      <?php endif; ?>
    </div>
  </div>
  
  <div class="col-lg-4 col-6">
    <div class="small-box bg-dark">
      <div class="inner">
        <h3><?= $draft_news ?></h3>
        <p>Draft Berita</p>
      </div>
      <div class="icon">
        <i class="fas fa-edit"></i>
      </div>
      <a href="<?= base_url('admin/news') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<!-- Recent News -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-newspaper mr-1"></i>
          Berita Terbaru
        </h3>
        <div class="card-tools">
          <a href="<?= base_url('admin/news/create') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Berita
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <?php if (!empty($recent_news)): ?>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Views</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach (array_slice($recent_news, 0, 10) as $news): ?>
              <tr>
                <td>
                  <a href="<?= base_url('admin/news/edit/' . $news['id']) ?>">
                    <?= esc(character_limiter($news['title'], 50)) ?>
                  </a>
                </td>
                <td>
                  <span class="badge badge-primary"><?= esc($news['category_name']) ?></span>
                </td>
                <td><?= esc($news['author_name']) ?></td>
                <td>
                  <?php
                  $statusClass = [
                    'draft' => 'secondary',
                    'pending' => 'warning',
                    'published' => 'success',
                    'rejected' => 'danger'
                  ];
                  ?>
                  <span class="badge badge-<?= $statusClass[$news['status']] ?>">
                    <?= ucfirst($news['status']) ?>
                  </span>
                </td>
                <td><?= date('d M Y', strtotime($news['created_at'])) ?></td>
                <td><?= number_format($news['views']) ?></td>
                <td>
                  <div class="btn-group" role="group">
                    <?php if ($news['status'] == 'published'): ?>
                    <a href="<?= base_url('news/' . $news['slug']) ?>" target="_blank" 
                       class="btn btn-info btn-xs" title="Lihat">
                      <i class="fas fa-eye"></i>
                    </a>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('admin/news/edit/' . $news['id']) ?>" 
                       class="btn btn-warning btn-xs" title="Edit">
                      <i class="fas fa-edit"></i>
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

<!-- Popular News -->
<?php if (!empty($popular_news)): ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-fire mr-1"></i>
          Berita Populer
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <?php foreach ($popular_news as $news): ?>
          <div class="col-md-6 col-lg-4 mb-3">
            <div class="card card-outline card-primary">
              <div class="card-body">
                <h6 class="card-title">
                  <a href="<?= base_url('admin/news/edit/' . $news['id']) ?>">
                    <?= esc(character_limiter($news['title'], 40)) ?>
                  </a>
                </h6>
                <p class="card-text">
                  <small class="text-muted">
                    <i class="fas fa-tag"></i> <?= esc($news['category_name']) ?><br>
                    <i class="fas fa-eye"></i> <?= number_format($news['views']) ?> views
                  </small>
                </p>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Quick Actions -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-bolt mr-1"></i>
          Aksi Cepat
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="<?= base_url('admin/news/create') ?>" class="btn btn-primary btn-block">
              <i class="fas fa-plus"></i><br>
              Tambah Berita
            </a>
          </div>
          
          <?php if (in_array(session()->get('role'), ['admin', 'editor'])): ?>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-success btn-block">
              <i class="fas fa-tags"></i><br>
              Tambah Kategori
            </a>
          </div>
          
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="<?= base_url('admin/news/pending') ?>" class="btn btn-warning btn-block">
              <i class="fas fa-clock"></i><br>
              Review Berita
              <?php if ($pending_news > 0): ?>
              <span class="badge badge-light"><?= $pending_news ?></span>
              <?php endif; ?>
            </a>
          </div>
          <?php endif; ?>
          
          <?php if (session()->get('role') == 'admin'): ?>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-danger btn-block">
              <i class="fas fa-user-plus"></i><br>
              Tambah User
            </a>
          </div>
          <?php endif; ?>
          
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="<?= base_url() ?>" target="_blank" class="btn btn-info btn-block">
              <i class="fas fa-globe"></i><br>
              Lihat Website
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

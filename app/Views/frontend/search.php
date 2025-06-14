<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-light p-4 rounded">
                <h1 class="mb-3">
                    <i class="fas fa-search text-primary"></i> Hasil Pencarian
                </h1>
                
                <!-- Search Form -->
                <form action="<?= base_url('search') ?>" method="get" class="mb-3">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" class="form-control" 
                               placeholder="Cari berita..." value="<?= esc($keyword) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
                
                <p class="mb-0 text-muted">
                    <?php if ($total_news > 0): ?>
                        Ditemukan <strong><?= $total_news ?></strong> berita untuk kata kunci "<strong><?= esc($keyword) ?></strong>"
                    <?php else: ?>
                        Tidak ditemukan berita untuk kata kunci "<strong><?= esc($keyword) ?></strong>"
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Search Results -->
    <?php if (!empty($news)): ?>
    <div class="row">
        <?php foreach ($news as $item): ?>
        <div class="col-lg-6 mb-4">
            <div class="card news-card h-100 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php if ($item['featured_image']): ?>
                        <img src="<?= base_url('uploads/news/' . $item['featured_image']) ?>" 
                             class="img-fluid rounded-start h-100" style="object-fit: cover;" 
                             alt="<?= esc($item['title']) ?>">
                        <?php else: ?>
                        <div class="bg-light rounded-start h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted fa-2x"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex flex-column h-100">
                            <div class="mb-2">
                                <span class="badge bg-primary"><?= esc($item['category_name']) ?></span>
                            </div>
                            
                            <h5 class="card-title">
                                <a href="<?= base_url('news/' . $item['slug']) ?>" 
                                   class="text-decoration-none text-dark">
                                    <?= highlight_phrase(esc($item['title']), $keyword, '<mark>', '</mark>') ?>
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted flex-grow-1">
                                <?= highlight_phrase(esc(character_limiter(strip_tags($item['excerpt']), 120)), $keyword, '<mark>', '</mark>') ?>
                            </p>
                            
                            <div class="mt-auto">
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> <?= esc($item['author_name']) ?><br>
                                    <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($item['published_at'])) ?> |
                                    <i class="fas fa-eye"></i> <?= number_format($item['views']) ?> views
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($total_news > $per_page): ?>
    <div class="row">
        <div class="col-12">
            <nav aria-label="Search pagination">
                <ul class="pagination justify-content-center">
                    <?php 
                    $totalPages = ceil($total_news / $per_page);
                    $currentPage = $current_page;
                    $baseUrl = base_url('search');
                    ?>
                    
                    <!-- Previous -->
                    <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl ?>?q=<?= urlencode($keyword) ?>&page=<?= $currentPage - 1 ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <!-- Page Numbers -->
                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $baseUrl ?>?q=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <!-- Next -->
                    <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl ?>?q=<?= urlencode($keyword) ?>&page=<?= $currentPage + 1 ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <i class="fas fa-search fa-3x mb-3 text-warning"></i>
                <h4>Tidak Ada Hasil</h4>
                <p>Maaf, tidak ditemukan berita yang sesuai dengan kata kunci "<strong><?= esc($keyword) ?></strong>".</p>
                
                <div class="mt-4">
                    <h6>Saran pencarian:</h6>
                    <ul class="list-unstyled">
                        <li>• Periksa ejaan kata kunci</li>
                        <li>• Gunakan kata kunci yang lebih umum</li>
                        <li>• Coba kata kunci yang berbeda</li>
                    </ul>
                </div>
                
                <div class="mt-4">
                    <a href="<?= base_url() ?>" class="btn btn-primary me-2">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                    <button class="btn btn-outline-primary" onclick="document.querySelector('input[name=q]').focus()">
                        <i class="fas fa-search"></i> Cari Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Popular Categories -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tags"></i> Kategori Populer
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($categories as $category): ?>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <a href="<?= base_url('category/' . $category['slug']) ?>" 
                               class="btn btn-outline-primary btn-sm w-100">
                                <?= esc($category['name']) ?>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

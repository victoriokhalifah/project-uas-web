<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= esc($category['name']) ?>
            </li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded shadow">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="mb-2">
                            <i class="fas fa-tag"></i> <?= esc($category['name']) ?>
                        </h1>
                        <?php if ($category['description']): ?>
                        <p class="mb-0 fs-5"><?= esc($category['description']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <h4 class="mb-0"><?= $total_news ?></h4>
                            <small>Total Berita</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter and Sort -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <span class="me-3">Urutkan:</span>
                <select class="form-select form-select-sm" style="width: auto;" onchange="sortNews(this.value)">
                    <option value="latest">Terbaru</option>
                    <option value="popular">Terpopuler</option>
                    <option value="oldest">Terlama</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 text-md-end">
            <small class="text-muted">
                Menampilkan <?= count($news) ?> dari <?= $total_news ?> berita
            </small>
        </div>
    </div>
    
    <!-- News List -->
    <?php if (!empty($news)): ?>
    <div class="row" id="news-container">
        <?php foreach ($news as $item): ?>
        <div class="col-lg-6 mb-4 news-item" data-date="<?= strtotime($item['published_at']) ?>" data-views="<?= $item['views'] ?>">
            <div class="card news-card h-100 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php if ($item['featured_image']): ?>
                        <img src="<?= base_url('uploads/news/' . $item['featured_image']) ?>" 
                             class="img-fluid rounded-start h-100" style="object-fit: cover;" 
                             alt="<?= esc($item['title']) ?>">
                        <?php else: ?>
                        <div class="bg-light rounded-start h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-image text-muted fa-3x"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex flex-column h-100">
                            <h5 class="card-title">
                                <a href="<?= base_url('news/' . $item['slug']) ?>" 
                                   class="text-decoration-none text-dark">
                                    <?= esc($item['title']) ?>
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted flex-grow-1">
                                <?= esc(character_limiter(strip_tags($item['excerpt']), 120)) ?>
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
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php 
                    $totalPages = ceil($total_news / $per_page);
                    $currentPage = $current_page;
                    $baseUrl = base_url('category/' . $category['slug']);
                    ?>
                    
                    <!-- Previous -->
                    <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl ?>?page=<?= $currentPage - 1 ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <!-- Page Numbers -->
                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $baseUrl ?>?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <!-- Next -->
                    <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= $baseUrl ?>?page=<?= $currentPage + 1 ?>">
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
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>Belum Ada Berita</h4>
                <p>Belum ada berita dalam kategori ini. Silakan cek kategori lain atau kembali nanti.</p>
                <a href="<?= base_url() ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function sortNews(sortBy) {
    const container = document.getElementById('news-container');
    const newsItems = Array.from(container.querySelectorAll('.news-item'));
    
    newsItems.sort((a, b) => {
        switch(sortBy) {
            case 'latest':
                return parseInt(b.dataset.date) - parseInt(a.dataset.date);
            case 'oldest':
                return parseInt(a.dataset.date) - parseInt(b.dataset.date);
            case 'popular':
                return parseInt(b.dataset.views) - parseInt(a.dataset.views);
            default:
                return 0;
        }
    });
    
    // Clear container and re-append sorted items
    container.innerHTML = '';
    newsItems.forEach(item => container.appendChild(item));
}
</script>
<?= $this->endSection() ?>

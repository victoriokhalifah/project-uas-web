<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('category/' . $news['category_slug']) ?>">
                            <?= esc($news['category_name']) ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= esc(character_limiter($news['title'], 50)) ?>
                    </li>
                </ol>
            </nav>

            <!-- News Content -->
            <article class="mb-5">
                <!-- Category Badge -->
                <div class="mb-3">
                    <a href="<?= base_url('category/' . $news['category_slug']) ?>" 
                       class="badge bg-primary text-decoration-none fs-6">
                        <?= esc($news['category_name']) ?>
                    </a>
                </div>
                
                <!-- Title -->
                <h1 class="mb-3 display-6"><?= esc($news['title']) ?></h1>
                
                <!-- Meta Info -->
                <div class="mb-4 text-muted border-bottom pb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <i class="fas fa-user"></i> <?= esc($news['author_name']) ?> |
                            <i class="fas fa-calendar"></i> <?= date('d M Y H:i', strtotime($news['published_at'])) ?> |
                            <i class="fas fa-eye"></i> <?= number_format($news['views']) ?> views
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Featured Image -->
                <?php if ($news['featured_image']): ?>
                <div class="mb-4">
                    <img src="<?= base_url('uploads/news/' . $news['featured_image']) ?>" 
                         class="img-fluid rounded shadow" alt="<?= esc($news['title']) ?>">
                </div>
                <?php endif; ?>
                
                <!-- Content -->
                <div class="news-content fs-5 lh-lg">
                    <?= $news['content'] ?>
                </div>
                
                <!-- Tags/Keywords -->
                <div class="mt-4 pt-4 border-top">
                    <h6>Tags:</h6>
                    <span class="badge bg-secondary me-1"><?= esc($news['category_name']) ?></span>
                    <span class="badge bg-secondary me-1">Berita</span>
                    <span class="badge bg-secondary me-1">Terkini</span>
                </div>
                
                <!-- Share Buttons -->
                <div class="mt-4 pt-4 border-top">
                    <h6>Bagikan Artikel:</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                           target="_blank" class="btn btn-primary btn-sm">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($news['title']) ?>" 
                           target="_blank" class="btn btn-info btn-sm">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://wa.me/?text=<?= urlencode($news['title'] . ' - ' . current_url()) ?>" 
                           target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(current_url()) ?>" 
                           target="_blank" class="btn btn-primary btn-sm">
                            <i class="fab fa-linkedin"></i> LinkedIn
                        </a>
                        <button class="btn btn-secondary btn-sm" onclick="copyToClipboard()">
                            <i class="fas fa-copy"></i> Copy Link
                        </button>
                    </div>
                </div>
            </article>
        </div>
        
        <div class="col-lg-4">
            <!-- Related News -->
            <?php if (!empty($related_news)): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-newspaper"></i> Berita Terkait
                    </h5>
                </div>
                <div class="card-body">
                    <?php foreach ($related_news as $related): ?>
                    <div class="mb-3 pb-3 <?= $related !== end($related_news) ? 'border-bottom' : '' ?>">
                        <div class="row">
                            <?php if ($related['featured_image']): ?>
                            <div class="col-4">
                                <img src="<?= base_url('uploads/news/' . $related['featured_image']) ?>" 
                                     class="img-fluid rounded" alt="<?= esc($related['title']) ?>">
                            </div>
                            <div class="col-8">
                            <?php else: ?>
                            <div class="col-12">
                            <?php endif; ?>
                                <h6 class="mb-1">
                                    <a href="<?= base_url('news/' . $related['slug']) ?>" 
                                       class="text-decoration-none">
                                        <?= esc(character_limiter($related['title'], 60)) ?>
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($related['published_at'])) ?> |
                                    <i class="fas fa-eye"></i> <?= number_format($related['views']) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Popular News Widget -->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-fire"></i> Berita Populer
                    </h5>
                </div>
                <div class="card-body">
                    <?php 
                    $newsModel = new \App\Models\NewsModel();
                    $popularNews = $newsModel->getPopularNews(5);
                    foreach ($popularNews as $index => $popular): 
                    ?>
                    <div class="d-flex mb-3 <?= $index < 4 ? 'border-bottom pb-3' : '' ?>">
                        <div class="flex-shrink-0 me-3">
                            <span class="badge bg-danger rounded-pill"><?= $index + 1 ?></span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <a href="<?= base_url('news/' . $popular['slug']) ?>" 
                                   class="text-decoration-none">
                                    <?= esc(character_limiter($popular['title'], 50)) ?>
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-eye"></i> <?= number_format($popular['views']) ?> views
                            </small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tags"></i> Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <?php foreach ($categories as $category): ?>
                    <a href="<?= base_url('category/' . $category['slug']) ?>" 
                       class="btn btn-outline-success btn-sm mb-2 me-1">
                        <?= esc($category['name']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link berhasil disalin!');
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}

// Reading progress bar
window.addEventListener('scroll', function() {
    const article = document.querySelector('article');
    if (article) {
        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollTop = window.pageYOffset;
        
        const progress = Math.min(100, Math.max(0, 
            ((scrollTop - articleTop + windowHeight/2) / articleHeight) * 100
        ));
        
        // You can add a progress bar here if needed
    }
});
</script>
<?= $this->endSection() ?>

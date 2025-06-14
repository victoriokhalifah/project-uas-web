<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Beritator</h1>
                <p class="lead mb-4">Portal Berita Terpercaya dengan Informasi Terkini dan Akurat</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#latest-news" class="btn btn-light btn-lg smooth-scroll">
                        <i class="fas fa-newspaper"></i> Baca Berita
                    </a>
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Login Admin
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-newspaper display-1 opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search Section -->
<div class="bg-light py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="<?= base_url('search') ?>" method="get" class="d-flex" id="searchForm">
                    <input type="text" name="q" class="form-control form-control-lg" 
                           placeholder="Cari berita..." value="<?= esc($search_query) ?>" 
                           id="searchInput" required>
                    <button type="submit" class="btn btn-primary btn-lg ms-2" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <!-- Quick Search Suggestions -->
                <div class="mt-2">
                    <small class="text-muted">Pencarian populer: </small>
                    <button class="btn btn-sm btn-outline-secondary me-1 quick-search" data-query="teknologi">Teknologi</button>
                    <button class="btn btn-sm btn-outline-secondary me-1 quick-search" data-query="ekonomi">Ekonomi</button>
                    <button class="btn btn-sm btn-outline-secondary me-1 quick-search" data-query="olahraga">Olahraga</button>
                    <button class="btn btn-sm btn-outline-secondary me-1 quick-search" data-query="politik">Politik</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest News Section -->
<div class="container my-5" id="latest-news">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-newspaper text-primary"></i> Berita Terbaru
            </h2>
        </div>
    </div>
    
    <?php if (!empty($latest_news)): ?>
    <div class="row">
        <?php foreach ($latest_news as $index => $news): ?>
        <div class="col-lg-<?= $index === 0 ? '8' : '4' ?> col-md-6 mb-4">
            <div class="card news-card h-100 shadow-sm <?= $index === 0 ? 'featured-news' : '' ?>" 
                 onclick="window.location.href='<?= base_url('news/' . $news['slug']) ?>'" 
                 style="cursor: pointer;">
                <?php if ($news['featured_image']): ?>
                <img src="<?= base_url('uploads/news/' . $news['featured_image']) ?>" 
                     class="card-img-top news-image" alt="<?= esc($news['title']) ?>"
                     onerror="this.src='https://via.placeholder.com/400x200/6c757d/ffffff?text=No+Image'">
                <?php else: ?>
                <img src="https://via.placeholder.com/400x200/6c757d/ffffff?text=No+Image" 
                     class="card-img-top news-image" alt="No Image">
                <?php endif; ?>
                
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <a href="<?= base_url('category/' . $news['category_slug']) ?>" 
                           class="badge bg-primary text-decoration-none category-badge"
                           onclick="event.stopPropagation();">
                            <?= esc($news['category_name']) ?>
                        </a>
                    </div>
                    
                    <h<?= $index === 0 ? '3' : '5' ?> class="card-title">
                        <a href="<?= base_url('news/' . $news['slug']) ?>" 
                           class="text-decoration-none text-dark news-title-link"
                           onclick="event.stopPropagation();">
                            <?= esc($news['title']) ?>
                        </a>
                    </h<?= $index === 0 ? '3' : '5' ?>>
                    
                    <p class="card-text text-muted flex-grow-1">
                        <?= esc(character_limiter(strip_tags($news['excerpt']), $index === 0 ? 200 : 100)) ?>
                    </p>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user"></i> <?= esc($news['author_name']) ?><br>
                                <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($news['published_at'])) ?><br>
                                <i class="fas fa-eye"></i> <?= number_format($news['views']) ?> views
                            </small>
                            <button class="btn btn-sm btn-outline-primary read-more-btn" 
                                    onclick="event.stopPropagation(); window.location.href='<?= base_url('news/' . $news['slug']) ?>'">
                                Baca <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($index === 0): ?>
        </div>
        <div class="row">
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
    
    <div class="text-center mt-4">
        <?php if (!empty($categories)): ?>
        <a href="<?= base_url('category/' . $categories[0]['slug']) ?>" class="btn btn-outline-primary btn-lg me-2">
            Lihat Semua Berita <i class="fas fa-arrow-right"></i>
        </a>
        <?php endif; ?>
        <button class="btn btn-primary btn-lg" onclick="loadMoreNews()" id="loadMoreBtn">
            <i class="fas fa-plus"></i> Muat Lebih Banyak
        </button>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h4>Belum ada berita yang dipublikasi</h4>
                <p>Silakan kembali lagi nanti untuk membaca berita terbaru.</p>
                <a href="<?= base_url('auth/login') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Berita Pertama
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Popular News Section -->
<?php if (!empty($popular_news)): ?>
<div class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 text-center">
                    <i class="fas fa-fire text-danger"></i> Berita Populer
                </h2>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($popular_news as $news): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card news-card h-100 shadow-sm" 
                     onclick="window.location.href='<?= base_url('news/' . $news['slug']) ?>'" 
                     style="cursor: pointer;">
                    <?php if ($news['featured_image']): ?>
                    <img src="<?= base_url('uploads/news/' . $news['featured_image']) ?>" 
                         class="card-img-top news-image" alt="<?= esc($news['title']) ?>"
                         onerror="this.src='https://via.placeholder.com/400x200/6c757d/ffffff?text=No+Image'">
                    <?php else: ?>
                    <img src="https://via.placeholder.com/400x200/6c757d/ffffff?text=No+Image" 
                         class="card-img-top news-image" alt="No Image">
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-danger"><?= esc($news['category_name']) ?></span>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-eye"></i> <?= number_format($news['views']) ?>
                            </span>
                        </div>
                        
                        <h6 class="card-title flex-grow-1">
                            <a href="<?= base_url('news/' . $news['slug']) ?>" 
                               class="text-decoration-none text-dark"
                               onclick="event.stopPropagation();">
                                <?= esc($news['title']) ?>
                            </a>
                        </h6>
                        
                        <div class="mt-auto">
                            <button class="btn btn-sm btn-danger w-100" 
                                    onclick="event.stopPropagation(); window.location.href='<?= base_url('news/' . $news['slug']) ?>'">
                                <i class="fas fa-fire"></i> Baca Populer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <button class="btn btn-danger btn-lg" onclick="showAllPopular()">
                <i class="fas fa-fire"></i> Lihat Semua Berita Populer
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Categories Section -->
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center">
                <i class="fas fa-tags text-primary"></i> Kategori Berita
            </h2>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <?php foreach ($categories as $category): ?>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
            <button class="btn btn-outline-primary w-100 category-btn" 
                    onclick="window.location.href='<?= base_url('category/' . $category['slug']) ?>'"
                    data-category="<?= esc($category['name']) ?>">
                <i class="fas fa-folder-open"></i><br>
                <?= esc($category['name']) ?>
            </button>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Show All Categories Button -->
    <div class="text-center mt-4">
        <button class="btn btn-primary btn-lg" onclick="toggleAllCategories()" id="toggleCategoriesBtn">
            <i class="fas fa-th-large"></i> Lihat Semua Kategori
        </button>
    </div>
</div>

<!-- Newsletter Section -->
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3 class="mb-3">
                    <i class="fas fa-envelope"></i> Berlangganan Newsletter
                </h3>
                <p class="mb-4">Dapatkan berita terbaru langsung di email Anda setiap hari</p>
                
                <form class="d-flex flex-column flex-sm-row gap-2" id="newsletterForm">
                    <input type="email" class="form-control form-control-lg" 
                           placeholder="Masukkan email Anda" id="newsletterEmail" required>
                    <button type="submit" class="btn btn-light btn-lg" id="subscribeBtn">
                        <i class="fas fa-paper-plane"></i> Berlangganan
                    </button>
                </form>
                
                <small class="mt-2 d-block opacity-75">
                    Kami menghormati privasi Anda. Unsubscribe kapan saja.
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button class="btn btn-primary position-fixed d-none" id="backToTopBtn" 
        style="bottom: 20px; right: 20px; z-index: 1000; border-radius: 50%; width: 50px; height: 50px;"
        onclick="scrollToTop()">
    <i class="fas fa-arrow-up"></i>
</button>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search form functionality
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    
    searchForm.addEventListener('submit', function(e) {
        if (searchInput.value.trim() === '') {
            e.preventDefault();
            alert('Silakan masukkan kata kunci pencarian');
            searchInput.focus();
            return false;
        }
        
        // Show loading state
        searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        searchBtn.disabled = true;
    });
    
    // Quick search buttons
    document.querySelectorAll('.quick-search').forEach(button => {
        button.addEventListener('click', function() {
            const query = this.getAttribute('data-query');
            searchInput.value = query;
            searchForm.submit();
        });
    });
    
    // Newsletter form
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterEmail = document.getElementById('newsletterEmail');
    const subscribeBtn = document.getElementById('subscribeBtn');
    
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateEmail(newsletterEmail.value)) {
            alert('Silakan masukkan email yang valid');
            newsletterEmail.focus();
            return;
        }
        
        // Show loading state
        subscribeBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Berlangganan...';
        subscribeBtn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            alert('Terima kasih! Anda telah berlangganan newsletter kami.');
            newsletterEmail.value = '';
            subscribeBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Berlangganan';
            subscribeBtn.disabled = false;
        }, 2000);
    });
    
    // Back to top button
    const backToTopBtn = document.getElementById('backToTopBtn');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.remove('d-none');
        } else {
            backToTopBtn.classList.add('d-none');
        }
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Category button hover effects
    document.querySelectorAll('.category-btn').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.innerHTML = `<i class="fas fa-arrow-right"></i><br>Lihat ${this.getAttribute('data-category')}`;
        });
        
        button.addEventListener('mouseleave', function() {
            const categoryName = this.getAttribute('data-category');
            this.innerHTML = `<i class="fas fa-folder-open"></i><br>${categoryName}`;
        });
    });
});

// Load more news functionality
function loadMoreNews() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
    loadMoreBtn.disabled = true;
    
    // Simulate loading more news
    setTimeout(() => {
        alert('Fitur ini akan segera tersedia! Untuk saat ini, silakan kunjungi halaman kategori untuk melihat lebih banyak berita.');
        loadMoreBtn.innerHTML = '<i class="fas fa-plus"></i> Muat Lebih Banyak';
        loadMoreBtn.disabled = false;
    }, 1500);
}

// Show all popular news
function showAllPopular() {
    // Redirect to search with popular filter
    window.location.href = '<?= base_url("search?q=populer") ?>';
}

// Toggle all categories
function toggleAllCategories() {
    const btn = document.getElementById('toggleCategoriesBtn');
    
    // For now, just show an alert. In a real app, you'd show/hide more categories
    alert('Semua kategori sudah ditampilkan! Klik pada kategori manapun untuk melihat berita dalam kategori tersebut.');
}

// Scroll to top function
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Email validation function
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Add click tracking for analytics (optional)
function trackClick(element, action) {
    console.log(`Clicked: ${element} - Action: ${action}`);
    // Here you can add Google Analytics or other tracking code
}

// News card click handlers
document.addEventListener('click', function(e) {
    if (e.target.closest('.news-card')) {
        trackClick('news-card', 'view-article');
    } else if (e.target.closest('.category-btn')) {
        trackClick('category-button', 'view-category');
    } else if (e.target.closest('.quick-search')) {
        trackClick('quick-search', 'search');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('searchInput').focus();
    }
    
    // Escape to clear search
    if (e.key === 'Escape' && document.activeElement === document.getElementById('searchInput')) {
        document.getElementById('searchInput').value = '';
    }
});

// Auto-refresh news every 5 minutes (optional)
setInterval(function() {
    // You can add code here to check for new news and show a notification
    console.log('Checking for new news...');
}, 300000); // 5 minutes
</script>
<?= $this->endSection() ?>

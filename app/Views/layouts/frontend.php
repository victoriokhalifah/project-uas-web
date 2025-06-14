<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Beritator - Portal berita terpercaya dengan informasi terkini dan akurat">
    <meta name="keywords" content="berita, news, portal berita, informasi terkini">
    <meta name="author" content="Beritator">
    
    <title><?= $title ?? 'Beritator - Portal Berita Terpercaya' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #dc3545;
            --primary-dark: #c82333;
            --primary-light: #f8d7da;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .news-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
        }
        
        .news-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .news-image {
            height: 200px;
            object-fit: cover;
        }
        
        .footer {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #bd2130 100%);
            transform: translateY(-1px);
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
        }
        
        .navbar-nav .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: rgba(255,255,255,0.8) !important;
        }
        
        .bg-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        
        mark {
            background-color: var(--primary-light);
            padding: 0.1em 0.2em;
            border-radius: 0.2em;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }
        
        .featured-news .news-image {
            height: 300px;
        }
        
        .category-btn {
            padding: 1rem;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .category-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            background-color: var(--primary-color);
            color: white;
        }
        
        .category-btn i {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        
        .quick-search {
            transition: all 0.2s ease;
        }
        
        .quick-search:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .category-badge:hover {
            background-color: var(--primary-dark) !important;
        }
        
        .read-more-btn {
            transition: all 0.2s ease;
        }
        
        .read-more-btn:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .smooth-scroll {
            scroll-behavior: smooth;
        }
        
        #backToTopBtn {
            transition: all 0.3s ease;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        #backToTopBtn:hover {
            transform: scale(1.1);
            background-color: var(--primary-dark);
        }
        
        .news-title-link:hover {
            color: var(--primary-color) !important;
        }
        
        .card-header.bg-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
        }
        
        .card-header.bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        }
        
        .card-header.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
        }
        
        @media (max-width: 768px) {
            .category-btn {
                height: 70px;
                font-size: 0.8rem;
            }
            
            .featured-news .news-image {
                height: 250px;
            }
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-newspaper"></i> Beritator
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= base_url() ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <?php 
                    $categoryModel = new \App\Models\CategoryModel();
                    $navCategories = $categoryModel->getActiveCategories();
                    foreach (array_slice($navCategories, 0, 6) as $category): 
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'category/' . $category['slug']) !== false ? 'active' : '' ?>" 
                           href="<?= base_url('category/' . $category['slug']) ?>">
                            <?= esc($category['name']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    
                    <?php if (count($navCategories) > 6): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Lainnya
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach (array_slice($navCategories, 6) as $category): ?>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('category/' . $category['slug']) ?>">
                                    <?= esc($category['name']) ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/login') ?>">
                            <i class="fas fa-sign-in-alt"></i> Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-newspaper"></i> Beritator
                    </h5>
                    <p class="mb-3">Portal berita terpercaya dengan informasi terkini dan akurat. Kami berkomitmen menyajikan berita berkualitas untuk masyarakat Indonesia.</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Kategori</h6>
                    <ul class="list-unstyled">
                        <?php foreach (array_slice($navCategories, 0, 5) as $category): ?>
                        <li class="mb-2">
                            <a href="<?= base_url('category/' . $category['slug']) ?>" class="text-light text-decoration-none">
                                <?= esc($category['name']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Tautan Cepat</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url() ?>" class="text-light text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="<?= base_url('search') ?>" class="text-light text-decoration-none">Pencarian</a></li>
                        <li class="mb-2"><a href="<?= base_url('auth/login') ?>" class="text-light text-decoration-none">Login Admin</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 mb-4">
                    <h6 class="mb-3">Kontak Info</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Jakarta, Indonesia
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +62 21 1234 5678
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            info@beritator.com
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="bg-light my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> Beritator. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Powered by CodeIgniter 4 | Built with ❤️ in Indonesia
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Smooth scrolling for anchor links
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

        // Back to top button
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('backToTop');
            if (window.pageYOffset > 300) {
                if (!backToTop) {
                    const btn = document.createElement('button');
                    btn.id = 'backToTop';
                    btn.className = 'btn btn-primary position-fixed';
                    btn.style.cssText = 'bottom: 20px; right: 20px; z-index: 1000; border-radius: 50%; width: 50px; height: 50px;';
                    btn.innerHTML = '<i class="fas fa-arrow-up"></i>';
                    btn.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
                    document.body.appendChild(btn);
                }
            } else if (backToTop) {
                backToTop.remove();
            }
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>

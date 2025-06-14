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
                <a href="<?= base_url('category/' . $news['category_slug']) ?>" 
                   class="badge bg-primary text-decoration-none category-badge"
                   onclick="event.stopPropagation();">
                    <?= esc($news['category_name']) ?>
                </a>
            </div>
            
            <h6 class="card-title">
                <a href="<?= base_url('news/' . $news['slug']) ?>" 
                   class="text-decoration-none text-dark news-title-link"
                   onclick="event.stopPropagation();">
                    <?= esc($news['title']) ?>
                </a>
            </h6>
            
            <p class="card-text text-muted flex-grow-1">
                <?= esc(character_limiter(strip_tags($news['excerpt']), 100)) ?>
            </p>
            
            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
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

<!-- ── BLOG PAGE ──────────────────────────────────────────── -->

<div class="page-hero">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-16 text-center">
    <span class="section-badge">Our Blog</span>
    <h1 class="text-4xl md:text-5xl font-display font-bold text-white mt-4 mb-4">
      Insights & <span class="text-gradient">Articles</span>
    </h1>
    <p class="text-gray-400 max-w-2xl mx-auto text-lg">
      Stay updated with the latest trends in web development, digital marketing, and eco-technology.
    </p>
  </div>
</div>

<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
  <?php if (empty($posts)): ?>
    <div class="text-center py-20">
      <div class="text-6xl mb-4">✍️</div>
      <h2 class="text-2xl font-display font-semibold text-white mb-2">No posts yet</h2>
      <p class="text-gray-400">Check back soon — great content is coming!</p>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($posts as $post): ?>
        <article class="card group hover:-translate-y-1 transition-transform duration-300">
          <?php if ($post['thumbnail']): ?>
            <img src="<?= url('uploads/' . Security::e($post['thumbnail'])) ?>"
                 alt="<?= Security::e($post['title']) ?>"
                 class="w-full h-48 object-cover rounded-xl mb-4">
          <?php else: ?>
            <div class="w-full h-48 bg-gradient-to-br from-eco-900/40 to-slate-800 rounded-xl mb-4 flex items-center justify-center">
              <i class="fas fa-newspaper text-4xl text-eco-400 opacity-40"></i>
            </div>
          <?php endif; ?>
          <div class="text-xs text-eco-400 font-medium mb-2 flex items-center gap-2">
            <i class="fas fa-user"></i> <?= Security::e($post['author_name']) ?>
            <span class="text-gray-600">•</span>
            <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($post['published_at'])) ?>
          </div>
          <h2 class="text-lg font-display font-semibold text-white mb-2 group-hover:text-eco-400 transition-colors">
            <?= Security::e($post['title']) ?>
          </h2>
          <?php if ($post['excerpt']): ?>
            <p class="text-gray-400 text-sm mb-4 line-clamp-3"><?= Security::e($post['excerpt']) ?></p>
          <?php endif; ?>
          <a href="<?= url('blog/post?slug=' . urlencode($post['slug'])) ?>"
             class="btn-outline text-sm inline-flex items-center gap-2">
            Read More <i class="fas fa-arrow-right text-xs"></i>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

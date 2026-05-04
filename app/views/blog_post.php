<!-- ── BLOG POST DETAIL ──────────────────────────────────── -->

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16">

  <!-- Back link -->
  <a href="<?= url('blog') ?>" class="inline-flex items-center gap-2 text-gray-400 hover:text-eco-400 transition-colors text-sm mb-10 group">
    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Back to Blog
  </a>

  <article>
    <!-- Featured image -->
    <?php if ($post['thumbnail']): ?>
    <img src="<?= url('uploads/' . Security::e($post['thumbnail'])) ?>"
         alt="<?= Security::e($post['title']) ?>"
         class="w-full h-72 object-cover rounded-2xl mb-8 shadow-xl shadow-black/40">
    <?php endif; ?>

    <!-- Meta -->
    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-6">
      <span class="flex items-center gap-1.5">
        <span class="w-7 h-7 rounded-full bg-eco-500 flex items-center justify-center text-white font-bold text-xs">
          <?= strtoupper(substr($post['author_name'], 0, 1)) ?>
        </span>
        <?= Security::e($post['author_name']) ?>
      </span>
      <span class="text-gray-700">•</span>
      <span class="flex items-center gap-1.5">
        <i class="fas fa-calendar-alt text-eco-400 text-xs"></i>
        <?= date('F d, Y', strtotime($post['published_at'])) ?>
      </span>
    </div>

    <!-- Title -->
    <h1 class="text-3xl md:text-4xl font-display font-bold text-white mb-6 leading-tight">
      <?= Security::e($post['title']) ?>
    </h1>

    <!-- Excerpt callout -->
    <?php if ($post['excerpt']): ?>
    <p class="text-lg text-eco-400 font-medium mb-8 border-l-4 border-eco-500 pl-5 leading-relaxed">
      <?= Security::e($post['excerpt']) ?>
    </p>
    <?php endif; ?>

    <!-- Body (rendered HTML from rich editor) -->
    <div class="blog-body prose-content">
      <?= $post['body'] ?>
    </div>
  </article>

  <!-- Footer nav -->
  <div class="mt-16 pt-8 border-t border-white/10 flex items-center justify-between">
    <a href="<?= url('blog') ?>" class="btn-primary inline-flex items-center gap-2">
      <i class="fas fa-arrow-left"></i> All Posts
    </a>
    <!-- Share buttons -->
    <div class="flex items-center gap-3 text-sm text-gray-400">
      <span>Share:</span>
      <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode(url('blog/post?slug=' . $post['slug'])) ?>"
         target="_blank" class="hover:text-eco-400 transition" title="Share on Twitter">
        <i class="fab fa-twitter text-lg"></i>
      </a>
      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(url('blog/post?slug=' . $post['slug'])) ?>"
         target="_blank" class="hover:text-eco-400 transition" title="Share on LinkedIn">
        <i class="fab fa-linkedin text-lg"></i>
      </a>
      <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' — ' . url('blog/post?slug=' . $post['slug'])) ?>"
         target="_blank" class="hover:text-eco-400 transition" title="Share on WhatsApp">
        <i class="fab fa-whatsapp text-lg"></i>
      </a>
    </div>
  </div>

</div>

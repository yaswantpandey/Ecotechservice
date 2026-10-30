<!-- BLOG POST DETAIL -->

<article class="s-sec">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb">
      <a href="<?= url('') ?>">Home</a><span>/</span>
      <a href="<?= url('blog') ?>">Blog</a><span>/</span>
      <span aria-current="page"><?= Security::e($post['title']) ?></span>
    </nav>

    <div class="s-grid mt-8">
      <div style="grid-column:span 9">
        <p class="s-eyebrow">
          <?= Security::e($post['author_name']) ?> &mdash; <time datetime="<?= Security::e(date('Y-m-d', strtotime($post['published_at']))) ?>"><?= Security::e(date('F d, Y', strtotime($post['published_at']))) ?></time>
        </p>
        <h1 class="s-h1 mt-4"><?= Security::e($post['title']) ?></h1>
        <?php if ($post['excerpt']): ?>
        <p class="s-lede mt-6"><?= Security::e($post['excerpt']) ?></p>
        <?php endif; ?>
      </div>
    </div>

    <?php if ($post['thumbnail']): ?>
    <figure class="s-media s-media--16x10 mt-12">
      <img src="<?= url('uploads/' . Security::e($post['thumbnail'])) ?>"
           alt="<?= Security::e($post['title']) ?>" width="1200" height="750" loading="lazy" decoding="async">
    </figure>
    <?php endif; ?>

    <div class="s-grid mt-12">
      <!-- Body (rendered HTML from rich editor) -->
      <div class="s-prose" style="grid-column:span 8">
        <?= $post['body'] ?>
      </div>
      <aside style="grid-column:span 4">
        <p class="s-eyebrow">Share</p>
        <ul class="mt-3 space-y-2">
          <li><a class="s-link" href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode(url('blog/post?slug=' . $post['slug'])) ?>" target="_blank" rel="noopener"><i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a></li>
          <li><a class="s-link" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(url('blog/post?slug=' . $post['slug'])) ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin" aria-hidden="true"></i> LinkedIn</a></li>
          <li><a class="s-link" href="https://wa.me/?text=<?= urlencode($post['title'] . ' - ' . url('blog/post?slug=' . $post['slug'])) ?>" target="_blank" rel="noopener"><i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp</a></li>
        </ul>
        <p class="mt-8"><a href="<?= url('blog') ?>" class="s-btn--line s-btn--sm">All posts</a></p>
      </aside>
    </div>
  </div>
</article>

<!-- CTA -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7"><h2 class="s-h2">Want this applied to your project?</h2></div>
      <div style="grid-column:span 5">
        <p>Talk to the team that wrote it.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn--light">Contact us</a>
          <a href="<?= url('blog') ?>" class="s-btn--line">Back to the blog</a>
        </div>
      </div>
    </div>
  </div>
</section>

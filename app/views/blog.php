<!-- BLOG PAGE -->

<!-- Intro -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <p class="s-eyebrow">Blog</p>
        <h1 class="s-h1 mt-4">Notes and articles.</h1>
      </div>
      <div style="grid-column:span 5" class="lg:pt-10">
        <p class="s-lede">Writing on web development, digital marketing and eco-technology from the EcoTech team.</p>
      </div>
    </div>
  </div>
</section>

<section class="s-sec">
  <div class="s-shell">
    <?php if (empty($posts)): ?>
    <div class="s-panel s-panel--deep">
      <h2 class="s-h3">No posts yet</h2>
      <p class="s-mute mt-2">Check back soon &mdash; new articles are on the way.</p>
    </div>
    <?php else: ?>
    <div>
      <?php foreach ($posts as $post): ?>
      <a href="<?= url('blog/post?slug=' . urlencode($post['slug'])) ?>" class="s-work" data-reveal>
        <div class="s-media s-media--16x10">
          <?php if ($post['thumbnail']): ?>
          <img src="<?= url('uploads/' . Security::e($post['thumbnail'])) ?>"
               alt="<?= Security::e($post['title']) ?>" width="800" height="500" loading="lazy" decoding="async">
          <?php endif; ?>
        </div>
        <div>
          <p class="s-mono s-mute">
            <?= Security::e($post['author_name']) ?> &mdash; <time datetime="<?= Security::e(date('Y-m-d', strtotime($post['published_at']))) ?>"><?= Security::e(date('M d, Y', strtotime($post['published_at']))) ?></time>
          </p>
          <h2 class="s-h2 mt-3"><?= Security::e($post['title']) ?></h2>
          <?php if ($post['excerpt']): ?>
          <p class="s-mute mt-3"><?= Security::e($post['excerpt']) ?></p>
          <?php endif; ?>
          <p class="mt-5"><span class="s-link">Read article</span></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- CTA -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7"><h2 class="s-h2">Have a project in mind?</h2></div>
      <div style="grid-column:span 5">
        <p>Tell us what you are building and we will suggest a practical approach.</p>
        <div class="s-actions mt-6"><a href="<?= url('contact') ?>" class="s-btn--light">Contact us</a></div>
      </div>
    </div>
  </div>
</section>

<!-- ── TEMPLATES PAGE ─────────────────────────────────────── -->
<div class="page-hero">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-16 text-center">
    <span class="section-tag">Ready-Made Designs</span>
    <h1 class="font-display text-4xl sm:text-5xl font-bold text-white mt-4 mb-4">
      Premium <span class="text-gradient">Templates</span>
    </h1>
    <p class="text-gray-400 text-lg max-w-2xl mx-auto">
      Launch faster with our professionally crafted, fully responsive templates.
    </p>
  </div>
</div>

<section class="section-padding pt-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php if ($templates): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($templates as $t): ?>
      <div class="project-card group">
        <div class="project-thumb">
          <?php if ($t['thumbnail']): ?>
          <img src="<?= uploadUrl($t['thumbnail']) ?>" alt="<?= Security::e($t['title']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
          <?php else: ?>
          <div class="w-full h-full bg-gradient-to-br from-eco-900 to-gray-800 flex items-center justify-center">
            <i class="fas fa-palette text-eco-400/30 text-5xl"></i>
          </div>
          <?php endif; ?>
          <div class="project-overlay">
            <?php if ($t['preview_url']): ?>
            <a href="<?= Security::e($t['preview_url']) ?>" target="_blank" class="px-4 py-2 bg-eco-500 hover:bg-eco-400 text-white text-sm font-semibold rounded-lg transition">Preview</a>
            <?php endif; ?>
            <a href="<?= url('contact') ?>" class="px-4 py-2 border border-white/20 hover:border-white/60 text-white text-sm font-semibold rounded-lg transition">Get Template</a>
          </div>
        </div>
        <div class="p-5">
          <div class="flex items-center justify-between mb-2">
            <span class="project-badge"><?= $t['is_free'] ? 'Free' : 'Premium' ?></span>
            <?php if (!$t['is_free']): ?>
            <span class="text-eco-400 font-bold text-sm">$<?= number_format((float)$t['price'], 2) ?></span>
            <?php endif; ?>
          </div>
          <h3 class="font-display font-semibold text-white text-lg mb-2"><?= Security::e($t['title']) ?></h3>
          <p class="text-gray-400 text-sm leading-relaxed"><?= Security::e(truncate($t['description'], 100)) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-20 text-gray-500">
      <i class="fas fa-layer-group text-5xl mb-4 block"></i>
      <p>Templates coming soon.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- CTA -->
<section class="section-padding">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="cta-card">
      <div class="absolute inset-0 bg-gradient-to-br from-eco-600/20 to-eco-900/20 rounded-2xl"></div>
      <div class="relative">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Need a Custom Design?</h2>
        <p class="text-gray-400 mb-8">We build bespoke designs tailored to your brand and goals.</p>
        <a href="<?= url('contact') ?>" class="btn-primary">Request Custom Design</a>
      </div>
    </div>
  </div>
</section>

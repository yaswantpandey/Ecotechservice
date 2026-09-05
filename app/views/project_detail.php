<!-- ── PROJECT DETAIL ─────────────────────────────────────── -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16">
  <a href="<?= url('projects') ?>" class="inline-flex items-center space-x-2 text-gray-400 hover:text-eco-400 text-sm transition mb-8">
    <i class="fas fa-arrow-left text-xs"></i><span>Back to Portfolio</span>
  </a>
  <div class="mb-8">
    <span class="project-badge mb-3 inline-block"><?= ucfirst(Security::e($project['category'])) ?></span>
    <h1 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4"><?= Security::e($project['title']) ?></h1>
    <div class="flex flex-wrap gap-2 mb-4">
      <?php foreach (explode(',', $project['tech_stack']) as $tech): ?>
      <span class="tech-tag"><?= Security::e(trim($tech)) ?></span>
      <?php endforeach; ?>
    </div>
    <div class="flex flex-wrap gap-4">
      <?php if ($project['live_url']): ?>
      <a href="<?= Security::e($project['live_url']) ?>" target="_blank" class="btn-primary text-sm py-2"><i class="fas fa-external-link-alt mr-2"></i>Live Demo</a>
      <?php endif; ?>
      <?php if ($project['github_url']): ?>
      <a href="<?= Security::e($project['github_url']) ?>" target="_blank" class="btn-outline text-sm py-2"><i class="fab fa-github mr-2"></i>Source Code</a>
      <?php endif; ?>
    </div>
  </div>
  <?php 
  $fallbackThumbnails = [
      'pandey-reality'      => 'project_pandey_reality.jpg',
      'apna-cleaning'       => 'project_apna_cleaning.jpg',
      'kranti-furniture'    => 'project_kranti_furniture.jpg',
      'yaswant-portfolio'   => 'project_startup_landing.png',
      'ecotech-ai'          => 'project_solarmetrics.png',
      'ecotech-engineering' => 'project_greentrack.png',
  ];
  $detailThumb = !empty($project['thumbnail']) ? $project['thumbnail'] : ($fallbackThumbnails[$project['slug'] ?? ''] ?? 'project_startup_landing.png');
  ?>
  <div class="rounded-2xl overflow-hidden border border-gray-700 mb-10 aspect-video shadow-2xl">
    <img src="<?= uploadUrl($detailThumb) ?>" alt="<?= Security::e($project['title']) ?>" class="w-full h-full object-cover" loading="lazy">
  </div>
  <div class="mb-10">
    <h2 class="font-display text-2xl font-semibold text-white mb-4">About This Project</h2>
    <p class="text-gray-400 leading-relaxed"><?= nl2br(Security::e($project['description'])) ?></p>
  </div>
  <?php if ($images): ?>
  <h2 class="font-display text-2xl font-semibold text-white mb-6">Gallery</h2>
  <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-10">
    <?php foreach ($images as $img): ?>
    <div class="rounded-xl overflow-hidden border border-gray-700 aspect-video cursor-pointer" onclick="openLightbox('<?= uploadUrl($img['image_path']) ?>')">
      <img src="<?= uploadUrl($img['image_path']) ?>" alt="<?= Security::e($img['alt_text'] ?? '') ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy">
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="stat-card"><div class="text-gray-400 text-xs mb-1">Category</div><div class="text-white font-medium"><?= ucfirst(Security::e($project['category'])) ?></div></div>
    <div class="stat-card"><div class="text-gray-400 text-xs mb-1">Tech Stack</div><div class="text-white font-medium text-sm"><?= Security::e($project['tech_stack']) ?></div></div>
    <div class="stat-card"><div class="text-gray-400 text-xs mb-1">Completed</div><div class="text-white font-medium"><?= formatDate($project['created_at']) ?></div></div>
  </div>
</div>
<div id="lightbox" class="hidden fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4" onclick="this.classList.add('hidden')">
  <img id="lightboxImg" src="" alt="Gallery" class="max-w-full max-h-full rounded-xl shadow-2xl object-contain">
  <button class="absolute top-4 right-4 text-white/60 hover:text-white text-2xl"><i class="fas fa-times"></i></button>
</div>
<script>function openLightbox(src){document.getElementById('lightboxImg').src=src;document.getElementById('lightbox').classList.remove('hidden');}</script>

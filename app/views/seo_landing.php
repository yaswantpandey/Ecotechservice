<!-- P-SEO LANDING PAGE -->

<!-- Intro -->
<section class="s-sec">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb">
      <a href="<?= url('') ?>">Home</a><span>/</span>
      <a href="<?= url('services') ?>">Services</a><span>/</span>
      <span aria-current="page"><?= Security::e($page['service_name']) ?></span>
    </nav>
    <div class="s-grid mt-8">
      <div style="grid-column:span 7">
        <p class="s-eyebrow">Serving <?= Security::e($page['location']) ?> &amp; worldwide</p>
        <h1 class="s-h1 mt-4"><?= Security::e($page['h1_heading']) ?></h1>
      </div>
      <div style="grid-column:span 5" class="lg:pt-10">
        <p class="s-lede">We provide <strong><?= Security::e($page['service_name']) ?></strong> for businesses in <?= Security::e($page['location']) ?> &mdash; fast, scalable and secure solutions built around how your business actually works.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn">Get a free consultation</a>
          <a href="<?= url('services') ?>" class="s-btn--line">Explore all services</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Why us -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Why EcoTech</p>
        <h2 class="s-h2 mt-4">Why choose EcoTech for <?= Security::e($page['service_name']) ?> in <?= Security::e($page['location']) ?>?</h2>
      </div>
      <div style="grid-column:span 7">
        <p class="s-prose">Whether you are a startup in <?= Security::e($page['location']) ?> or an established company looking to scale, our <strong><?= Security::e($page['service_name']) ?></strong> work is designed to deliver a measurable return.</p>
      </div>
    </div>

    <ol class="s-list mt-12" data-reveal>
      <li><span class="s-num">01</span><h3 class="s-h3">Fast performance</h3><p>A current, lean stack so pages load quickly &mdash; better for search ranking and for keeping visitors.</p></li>
      <li><span class="s-num">02</span><h3 class="s-h3">Security from the start</h3><p>Modern security practice is built into every layer of the development process.</p></li>
      <li><span class="s-num">03</span><h3 class="s-h3">Responsive and scalable</h3><p>Works on every device and is architected to grow with your traffic.</p></li>
      <li><span class="s-num">04</span><h3 class="s-h3">Dedicated support</h3><p>Continuous maintenance and a support team you can reach after launch.</p></li>
    </ol>
  </div>
</section>

<!-- Process -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Process</p>
        <h2 class="s-h2 mt-4">How we work.</h2>
      </div>
      <div style="grid-column:span 7">
        <p class="s-prose">We follow an agile process built on transparency and short delivery cycles. From discovery and goal-mapping through deployment and scaling, the team makes sure your <strong><?= Security::e($page['target_keyword']) ?></strong> requirements are met.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <h2 class="s-h2">Ready to grow in <?= Security::e($page['location']) ?>?</h2>
      </div>
      <div style="grid-column:span 5">
        <p>Talk to our <?= Security::e($page['service_name']) ?> team and turn your idea into a working product.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn--light">Get your free quote</a>
          <a href="<?= url('services') ?>" class="s-btn--line">All services</a>
        </div>
      </div>
    </div>
  </div>
</section>

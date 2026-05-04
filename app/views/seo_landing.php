<!-- ── P-SEO LANDING PAGE ────────────────────────────────────── -->
<main class="pt-24 pb-20">
  
  <!-- Hero Section -->
  <section class="relative bg-gray-900 border-b border-gray-800 overflow-hidden pt-16 pb-24">
    <!-- Background Decor -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
      <div class="absolute -top-1/2 -right-1/4 w-[1000px] h-[1000px] rounded-full bg-eco-500/5 blur-[120px]"></div>
      <div class="absolute -bottom-1/2 -left-1/4 w-[800px] h-[800px] rounded-full bg-eco-600/5 blur-[100px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-eco-500/10 border border-eco-500/20 text-eco-400 text-sm font-medium mb-6">
        <i class="fas fa-map-marker-alt"></i> Serving <?= Security::e($page['location']) ?> & Worldwide
      </div>
      
      <h1 class="text-4xl md:text-6xl font-display font-bold text-white tracking-tight mb-6">
        <?= Security::e($page['h1_heading']) ?>
      </h1>
      
      <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto mb-10 leading-relaxed">
        We are the leading providers of <strong><?= Security::e($page['service_name']) ?></strong> in <?= Security::e($page['location']) ?>. Transform your digital presence with our high-performance, scalable, and secure technology solutions tailored for modern businesses.
      </p>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="<?= url('contact') ?>" class="btn-primary px-8 py-4 text-lg w-full sm:w-auto shadow-lg shadow-eco-500/20">
          Get a Free Consultation
        </a>
        <a href="<?= url('services') ?>" class="btn-outline px-8 py-4 text-lg w-full sm:w-auto">
          Explore All Services
        </a>
      </div>
    </div>
  </section>

  <!-- Content Section -->
  <section class="py-20 bg-gray-950">
    <div class="max-w-5xl mx-auto px-6 lg:px-8">
      <div class="prose prose-invert lg:prose-lg mx-auto">
        <h2 class="text-3xl font-display font-bold text-white mb-6">Why Choose Ecotech for <?= Security::e($page['service_name']) ?> in <?= Security::e($page['location']) ?>?</h2>
        <p class="text-gray-400 mb-6">
          Finding the right tech partner can be challenging. Whether you are a local startup in <?= Security::e($page['location']) ?> or an established enterprise looking to scale globally, our custom <strong><?= Security::e($page['service_name']) ?></strong> solutions are designed to deliver measurable ROI.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-12">
          <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl">
            <div class="w-12 h-12 bg-eco-500/20 rounded-xl flex items-center justify-center text-eco-400 text-xl mb-4">
              <i class="fas fa-rocket"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Blazing Fast Performance</h3>
            <p class="text-gray-500 text-sm">We utilize the latest tech stack to ensure your digital products load instantly, improving SEO and user retention.</p>
          </div>
          <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl">
            <div class="w-12 h-12 bg-eco-500/20 rounded-xl flex items-center justify-center text-eco-400 text-xl mb-4">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Enterprise Security</h3>
            <p class="text-gray-500 text-sm">Security isn't an afterthought. We bake modern security practices into every layer of our development process.</p>
          </div>
          <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl">
            <div class="w-12 h-12 bg-eco-500/20 rounded-xl flex items-center justify-center text-eco-400 text-xl mb-4">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Responsive & Scalable</h3>
            <p class="text-gray-500 text-sm">Your solution will look flawless on every device and seamlessly scale to accommodate millions of users.</p>
          </div>
          <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl">
            <div class="w-12 h-12 bg-eco-500/20 rounded-xl flex items-center justify-center text-eco-400 text-xl mb-4">
              <i class="fas fa-headset"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">24/7 Dedicated Support</h3>
            <p class="text-gray-500 text-sm">Our support team is always ready to assist you. We provide continuous maintenance to keep you ahead.</p>
          </div>
        </div>

        <h2 class="text-3xl font-display font-bold text-white mb-6">Our Process</h2>
        <p class="text-gray-400 mb-6">
          We follow an agile development methodology that guarantees transparency and rapid delivery. From the initial discovery phase mapping out your goals to deployment and scaling, our team ensures your <strong><?= Security::e($page['target_keyword']) ?></strong> needs are perfectly met.
        </p>
      </div>
    </div>
  </section>
  
  <!-- CTA Section -->
  <section class="py-24 relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
      <div class="p-12 md:p-16 rounded-3xl bg-gradient-to-br from-gray-900 to-gray-950 border border-gray-800 shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('<?= url('assets/img/grid-pattern.svg') ?>')] opacity-10"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-eco-500/10 rounded-full blur-[80px]"></div>
        
        <h2 class="text-3xl md:text-5xl font-display font-bold text-white mb-6 relative z-10">
          Ready to dominate <?= Security::e($page['location']) ?>'s market?
        </h2>
        <p class="text-gray-400 text-lg mb-8 relative z-10 max-w-2xl mx-auto">
          Contact the best <?= Security::e($page['service_name']) ?> experts today and let's turn your idea into a highly profitable digital reality.
        </p>
        <div class="relative z-10">
          <a href="<?= url('contact') ?>" class="btn-primary px-10 py-4 text-lg inline-flex items-center gap-3">
            Get Your Free Quote <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

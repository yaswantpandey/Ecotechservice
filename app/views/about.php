<!-- ── ABOUT PAGE ─────────────────────────────────────────── -->

<!-- Page Header -->
<div class="page-hero">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-16 text-center">
    <span class="section-tag">Our Story</span>
    <h1 class="font-display text-4xl sm:text-5xl font-bold text-white mt-4 mb-4">
      About <span class="text-gradient">Ecotech Service</span>
    </h1>
    <p class="text-gray-400 text-lg max-w-2xl mx-auto">
      We are a passionate team of developers, designers, and strategists building digital solutions that make a real difference.
    </p>
  </div>
</div>

<!-- ── Company Intro ── -->
<section class="section-padding">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div>
        <span class="section-tag">Who We Are</span>
        <h2 class="section-title mt-3 mb-6">Driven by <span class="text-gradient">Purpose</span>, Powered by Innovation</h2>
        <p class="text-gray-400 leading-relaxed mb-4">
          Ecotech Service was founded with a simple but powerful mission: to help businesses thrive in the digital age while embracing sustainable practices. Since our inception, we have delivered over 150 projects across 4 continents.
        </p>
        <p class="text-gray-400 leading-relaxed mb-8">
          Our multidisciplinary team combines deep technical expertise with creative thinking to build solutions that are not just functional — they are beautiful, fast, and built to last.
        </p>
        <div class="grid grid-cols-2 gap-4">
          <?php foreach ([
            ['icon'=>'fa-code',       'label'=>'Clean Code'],
            ['icon'=>'fa-shield-alt', 'label'=>'Secure by Default'],
            ['icon'=>'fa-bolt',       'label'=>'Fast Performance'],
            ['icon'=>'fa-leaf',       'label'=>'Eco-Conscious'],
          ] as $f): ?>
          <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-lg bg-eco-500/10 flex items-center justify-center">
              <i class="fas <?= $f['icon'] ?> text-eco-400 text-sm"></i>
            </div>
            <span class="text-gray-300 text-sm font-medium"><?= $f['label'] ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="relative">
        <div class="aspect-square rounded-2xl bg-gradient-to-br from-eco-900/50 to-gray-800 border border-gray-700 flex items-center justify-center">
          <div class="text-center">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-eco-400 to-eco-600 flex items-center justify-center mx-auto mb-4 shadow-2xl shadow-eco-500/30">
              <i class="fas fa-leaf text-white text-4xl"></i>
            </div>
            <p class="font-display font-bold text-2xl text-white">Ecotech Service</p>
            <p class="text-eco-400 text-sm mt-1">Building Sustainable Digital Futures</p>
          </div>
        </div>
        <!-- Floating card -->
        <div class="absolute -bottom-6 -left-6 bg-gray-800 border border-gray-700 rounded-xl p-4 shadow-xl">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg bg-eco-500 flex items-center justify-center">
              <i class="fas fa-trophy text-white"></i>
            </div>
            <div>
              <div class="font-bold text-white text-sm">Top Rated</div>
              <div class="text-gray-400 text-xs">5-Star Agency 2024</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Mission & Vision ── -->
<section class="section-padding bg-gray-900/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="service-card border-eco-500/20">
        <div class="w-12 h-12 rounded-xl bg-eco-500/10 border border-eco-500/20 flex items-center justify-center mb-5">
          <i class="fas fa-bullseye text-eco-400 text-xl"></i>
        </div>
        <h3 class="font-display font-bold text-white text-xl mb-3">Our Mission</h3>
        <p class="text-gray-400 leading-relaxed">
          To empower businesses with cutting-edge digital solutions that drive sustainable growth, foster innovation, and create lasting positive impact for clients and communities alike.
        </p>
      </div>
      <div class="service-card border-eco-500/20">
        <div class="w-12 h-12 rounded-xl bg-eco-500/10 border border-eco-500/20 flex items-center justify-center mb-5">
          <i class="fas fa-eye text-eco-400 text-xl"></i>
        </div>
        <h3 class="font-display font-bold text-white text-xl mb-3">Our Vision</h3>
        <p class="text-gray-400 leading-relaxed">
          To become the world's most trusted eco-technology agency — where every digital product we build contributes to a greener, smarter, and more connected world.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ── Stats ── -->
<section class="section-padding">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ([
        ['num'=>'150+','label'=>'Projects Completed','icon'=>'fa-briefcase'],
        ['num'=>'80+', 'label'=>'Happy Clients',     'icon'=>'fa-smile'],
        ['num'=>'5+',  'label'=>'Years in Business',  'icon'=>'fa-calendar'],
        ['num'=>'12',  'label'=>'Team Members',        'icon'=>'fa-users'],
      ] as $s): ?>
      <div class="stat-card text-center">
        <div class="w-12 h-12 rounded-xl bg-eco-500/10 flex items-center justify-center mx-auto mb-3">
          <i class="fas <?= $s['icon'] ?> text-eco-400 text-lg"></i>
        </div>
        <div class="font-display text-3xl font-bold text-eco-400 mb-1"><?= $s['num'] ?></div>
        <div class="text-sm text-gray-400"><?= $s['label'] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Founder ── -->
<section class="section-padding bg-gray-900/50">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <span class="section-tag">Leadership</span>
    <h2 class="section-title mt-3 mb-12">Meet the <span class="text-gradient">Founder</span></h2>
    <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-8">
      <div class="w-24 h-24 rounded-full bg-gradient-to-br from-eco-400 to-eco-600 flex items-center justify-center mx-auto mb-4 shadow-xl shadow-eco-500/30">
        <i class="fas fa-user text-white text-3xl"></i>
      </div>
      <h3 class="font-display font-bold text-white text-2xl mb-1">Alex Morgan</h3>
      <p class="text-eco-400 font-medium mb-4">Founder & CEO</p>
      <p class="text-gray-400 leading-relaxed max-w-2xl mx-auto">
        With over 10 years of experience in software engineering and digital marketing, Alex founded Ecotech Service with the vision of combining technology with environmental responsibility. He leads a global team dedicated to building impactful digital products.
      </p>
      <div class="flex items-center justify-center space-x-4 mt-6">
        <a href="#" class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-eco-500 flex items-center justify-center text-gray-400 hover:text-white transition-all text-sm"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" class="w-9 h-9 rounded-lg bg-gray-700 hover:bg-eco-500 flex items-center justify-center text-gray-400 hover:text-white transition-all text-sm"><i class="fab fa-twitter"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA ── -->
<section class="section-padding">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="cta-card">
      <div class="absolute inset-0 bg-gradient-to-br from-eco-600/20 to-eco-900/20 rounded-2xl"></div>
      <div class="relative">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Want to Work With Us?</h2>
        <p class="text-gray-400 mb-8">Let's create something extraordinary together.</p>
        <a href="<?= url('contact') ?>" class="btn-primary">Get In Touch</a>
      </div>
    </div>
  </div>
</section>

<!-- ── CONTACT PAGE ───────────────────────────────────────── -->
<div class="page-hero">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-16 text-center">
    <span class="section-tag">Get In Touch</span>
    <h1 class="font-display text-4xl sm:text-5xl font-bold text-white mt-4 mb-4">Contact <span class="text-gradient">Us</span></h1>
    <p class="text-gray-400 text-lg max-w-2xl mx-auto">Have a project in mind? We'd love to hear about it. Drop us a message!</p>
  </div>
</div>

<section class="section-padding pt-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
      <!-- Info -->
      <div class="space-y-6">
        <?php foreach ([
          ['icon'=>'fa-envelope','label'=>'Email','value'=>setting('site_email'),'href'=>'mailto:'.setting('site_email')],
          ['icon'=>'fa-phone','label'=>'Phone','value'=>setting('site_phone'),'href'=>'tel:'.setting('site_phone')],
          ['icon'=>'fa-map-marker-alt','label'=>'Address','value'=>setting('site_address'),'href'=>null],
        ] as $ci): ?>
        <div class="service-card flex items-start space-x-4 py-5">
          <div class="w-10 h-10 rounded-lg bg-eco-500/10 border border-eco-500/20 flex items-center justify-center flex-shrink-0">
            <i class="fas <?= $ci['icon'] ?> text-eco-400 text-sm"></i>
          </div>
          <div>
            <div class="text-gray-500 text-xs mb-1"><?= $ci['label'] ?></div>
            <?php if ($ci['href']): ?>
            <a href="<?= Security::e($ci['href']) ?>" class="text-white text-sm hover:text-eco-400 transition"><?= Security::e($ci['value']) ?></a>
            <?php else: ?>
            <div class="text-white text-sm"><?= Security::e($ci['value']) ?></div>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
        <!-- WhatsApp -->
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%2C%20I%20have%20a%20project%20inquiry."
           target="_blank"
           class="flex items-center space-x-3 bg-[#25D366] hover:bg-[#22c35e] text-white px-6 py-4 rounded-xl font-semibold transition-all shadow-lg shadow-green-500/20">
          <i class="fab fa-whatsapp text-2xl"></i>
          <div><div class="text-sm font-bold">Chat on WhatsApp</div><div class="text-xs font-normal opacity-80">Quick response guaranteed</div></div>
        </a>
      </div>

      <!-- Form -->
      <div class="lg:col-span-2">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
          <h2 class="font-display font-bold text-white text-2xl mb-6">Send Us a Message</h2>
          <form action="<?= url('contact/send') ?>" method="POST" class="space-y-5">
            <?= Security::csrfField() ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="form-label">Full Name *</label>
                <input type="text" name="name" required placeholder="John Doe" class="form-input">
              </div>
              <div>
                <label class="form-label">Email Address *</label>
                <input type="email" name="email" required placeholder="john@example.com" class="form-input">
              </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" placeholder="+1 (555) 000-0000" class="form-input">
              </div>
              <div>
                <label class="form-label">Subject *</label>
                <input type="text" name="subject" required placeholder="Project Inquiry" class="form-input">
              </div>
            </div>
            <div>
              <label class="form-label">Message *</label>
              <textarea name="message" required rows="5" placeholder="Tell us about your project..." class="form-input resize-none"></textarea>
            </div>
            <button type="submit" class="btn-primary w-full justify-center">
              <i class="fas fa-paper-plane mr-2"></i>Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── ENTERPRISE CONTACT & CONSULTATION PAGE ────────────────── -->

<!-- ── HERO SECTION ─────────────────────────────────────────── -->
<section class="relative pt-32 pb-14 overflow-hidden bg-slate-950 border-b border-slate-800/80">
  <!-- Ambient background glow -->
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_-10%,rgba(34,197,94,0.12),rgba(255,255,255,0))] pointer-events-none"></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <!-- Corporate Badge -->
    <div class="inline-flex items-center space-x-2 bg-slate-900 border border-slate-800 px-4 py-1.5 rounded-full text-slate-300 text-xs font-semibold tracking-wide mb-5">
      <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
      <span>Enterprise Engineering & Discovery Consultation</span>
    </div>

    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight max-w-4xl mx-auto leading-tight sm:leading-tight">
      Let's Build Something <span class="text-emerald-400">Exceptional</span> Together
    </h1>

    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto mt-4 leading-relaxed font-normal">
      Connect directly with our solution architects and software engineers. Whether you need an enterprise web application, mobile app, cloud architecture, or digital automation, we're ready to engineer your vision.
    </p>

    <!-- Trust SLA Badges -->
    <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6 mt-8 text-xs sm:text-sm font-medium text-slate-300">
      <div class="flex items-center space-x-2 bg-slate-900/80 border border-slate-800 px-3.5 py-1.5 rounded-xl">
        <i class="fas fa-bolt text-emerald-400"></i>
        <span>Guaranteed Response &lt; 2 Hours</span>
      </div>
      <div class="flex items-center space-x-2 bg-slate-900/80 border border-slate-800 px-3.5 py-1.5 rounded-xl">
        <i class="fas fa-shield-halved text-emerald-400"></i>
        <span>100% Confidential (NDA Available)</span>
      </div>
      <div class="flex items-center space-x-2 bg-slate-900/80 border border-slate-800 px-3.5 py-1.5 rounded-xl">
        <i class="fas fa-comments text-emerald-400"></i>
        <span>Direct Architect Consultation</span>
      </div>
    </div>
  </div>
</section>

<!-- ── MAIN CONTACT SECTION ───────────────────────────────────── -->
<section class="py-16 sm:py-20 bg-slate-950 relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 sm:gap-12 items-start">

      <!-- ── Left Column: Direct Channels & Process (5 cols) ── -->
      <div class="lg:col-span-5 space-y-6">

        <!-- Card 1: Instant WhatsApp Consultation -->
        <a href="https://wa.me/<?= setting('whatsapp_number') ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20new%20project%20inquiry."
           target="_blank"
           class="group block p-6 rounded-2xl bg-gradient-to-br from-[#25D366]/15 via-slate-900/90 to-slate-900 border border-[#25D366]/30 hover:border-[#25D366]/60 transition-all duration-300 shadow-xl shadow-green-950/20">
          <div class="flex items-start justify-between">
            <div class="flex items-center space-x-3.5">
              <div class="w-12 h-12 rounded-xl bg-[#25D366] text-white flex items-center justify-center text-2xl shadow-lg shadow-green-500/30 group-hover:scale-105 transition-transform">
                <i class="fab fa-whatsapp"></i>
              </div>
              <div>
                <div class="flex items-center space-x-2">
                  <span class="text-sm font-bold text-white">Instant WhatsApp Chat</span>
                  <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse mr-1"></span> Online
                  </span>
                </div>
                <p class="text-xs text-slate-400 mt-0.5">Direct chat with tech lead • Avg. reply 15 mins</p>
              </div>
            </div>
            <i class="fas fa-arrow-up-right-from-square text-xs text-emerald-400 opacity-60 group-hover:opacity-100 transition-opacity"></i>
          </div>
          <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs font-semibold text-emerald-400">
            <span>Launch WhatsApp Conversation</span>
            <i class="fas fa-arrow-right text-[11px] group-hover:translate-x-1 transition-transform"></i>
          </div>
        </a>

        <!-- Card 2: Direct Contact Channels -->
        <div class="p-6 rounded-2xl bg-slate-900/60 border border-slate-800 backdrop-blur-sm space-y-4">
          <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Direct Communication Channels</h3>

          <!-- Email -->
          <div class="flex items-start justify-between p-3.5 rounded-xl bg-slate-950/60 border border-slate-800/80 hover:border-slate-700 transition">
            <div class="flex items-start space-x-3.5">
              <div class="w-9 h-9 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-emerald-400 shrink-0 mt-0.5">
                <i class="fas fa-envelope text-sm"></i>
              </div>
              <div>
                <div class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Official Email</div>
                <a href="mailto:<?= Security::e(setting('site_email') ?: 'ecotech.servic@gmail.com') ?>" class="text-white text-sm font-semibold hover:text-emerald-400 transition break-all">
                  <?= Security::e(setting('site_email') ?: 'ecotech.servic@gmail.com') ?>
                </a>
                <div class="text-[11px] text-slate-500 mt-0.5">Response SLA: within 2 hours</div>
              </div>
            </div>
            <button type="button" onclick="copyToClipboard('<?= Security::e(setting('site_email') ?: 'ecotech.servic@gmail.com') ?>', this)" title="Copy email"
                    class="p-2 text-slate-400 hover:text-white transition rounded-lg hover:bg-slate-800">
              <i class="fas fa-copy text-xs"></i>
            </button>
          </div>

          <!-- Phone -->
          <div class="flex items-start justify-between p-3.5 rounded-xl bg-slate-950/60 border border-slate-800/80 hover:border-slate-700 transition">
            <div class="flex items-start space-x-3.5">
              <div class="w-9 h-9 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-emerald-400 shrink-0 mt-0.5">
                <i class="fas fa-phone text-sm"></i>
              </div>
              <div>
                <div class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Helpline &amp; Calls</div>
                <a href="tel:<?= Security::e(setting('site_phone') ?: '+91 7398301184') ?>" class="text-white text-sm font-semibold hover:text-emerald-400 transition">
                  <?= Security::e(setting('site_phone') ?: '+91 7398301184') ?>
                </a>
                <div class="text-[11px] text-slate-500 mt-0.5">Mon – Sat: 9:00 AM – 7:30 PM IST</div>
              </div>
            </div>
            <a href="tel:<?= Security::e(setting('site_phone') ?: '+91 7398301184') ?>" class="p-2 text-slate-400 hover:text-white transition rounded-lg hover:bg-slate-800">
              <i class="fas fa-phone-flip text-xs"></i>
            </a>
          </div>

          <!-- Headquarters Location -->
          <div class="flex items-start space-x-3.5 p-3.5 rounded-xl bg-slate-950/60 border border-slate-800/80">
            <div class="w-9 h-9 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-emerald-400 shrink-0 mt-0.5">
              <i class="fas fa-location-dot text-sm"></i>
            </div>
            <div>
              <div class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Development Center</div>
              <div class="text-white text-sm font-semibold">
                <?= Security::e(setting('site_address') ?: 'Lucknow, Uttar Pradesh, India') ?>
              </div>
              <div class="text-[11px] text-slate-500 mt-0.5">Delivering projects worldwide (USA, UK, UAE, India)</div>
            </div>
          </div>
        </div>

        <!-- Card 3: 3-Step Engagement Process -->
        <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800">
          <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">How We Work With You</h3>
          <div class="space-y-4">
            <div class="flex items-start space-x-3">
              <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">1</div>
              <div>
                <div class="text-xs font-semibold text-white">Discovery &amp; Tech Feasibility</div>
                <div class="text-[11px] text-slate-400 mt-0.5">We analyze your requirements, goals, and technical feasibility in a 30-min call.</div>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">2</div>
              <div>
                <div class="text-xs font-semibold text-white">Architecture &amp; Fixed Scope Proposal</div>
                <div class="text-[11px] text-slate-400 mt-0.5">You receive a detailed technical breakdown, clear milestone roadmap, and pricing.</div>
              </div>
            </div>

            <div class="flex items-start space-x-3">
              <div class="w-6 h-6 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">3</div>
              <div>
                <div class="text-xs font-semibold text-white">Agile Sprints &amp; Production Launch</div>
                <div class="text-[11px] text-slate-400 mt-0.5">Weekly sprint demos, continuous CI/CD deployments, and post-launch SLA support.</div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- ── Right Column: Enterprise Project Inquiry Form (7 cols) ── -->
      <div class="lg:col-span-7">
        <div class="p-6 sm:p-10 rounded-3xl bg-slate-900/80 border border-slate-800 backdrop-blur-xl shadow-2xl relative">

          <!-- Subtle Top Gradient Highlight -->
          <div class="absolute top-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-emerald-500/50 to-transparent"></div>

          <div class="mb-6">
            <h2 class="text-2xl font-bold text-white tracking-tight">Project Inquiry &amp; Brief</h2>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Fill in your requirements below and an engineering lead will review your specifications.</p>
          </div>

          <form id="contactForm" action="<?= url('contact/send') ?>" method="POST" class="space-y-6">
            <?= Security::csrfField() ?>

            <!-- 1. Interactive Project Type Selector -->
            <div>
              <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2.5">
                Select Project Capability *
              </label>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" id="projectTypeGrid">
                <?php
                $projectTypes = [
                  'Web Application',
                  'Mobile App',
                  'Cloud & DevOps',
                  'Cybersecurity',
                  'AI & Automation',
                  'Custom Software',
                ];
                foreach ($projectTypes as $idx => $pt):
                ?>
                <button type="button"
                        onclick="selectProjectType('<?= $pt ?>', this)"
                        class="project-type-btn text-left px-3 py-2.5 rounded-xl border text-xs font-medium transition-all duration-200 <?= $idx === 0 ? 'bg-emerald-500/15 border-emerald-500/40 text-emerald-400 font-semibold shadow-sm' : 'bg-slate-950/60 border-slate-800 text-slate-300 hover:border-slate-700 hover:text-white' ?>">
                  <div class="flex items-center space-x-1.5">
                    <span class="w-1.5 h-1.5 rounded-full <?= $idx === 0 ? 'bg-emerald-400' : 'bg-slate-600' ?> indicator-dot"></span>
                    <span class="truncate"><?= $pt ?></span>
                  </div>
                </button>
                <?php endforeach; ?>
              </div>
              <input type="hidden" name="subject" id="subjectInput" value="Web Application">
            </div>

            <!-- 2. Personal Information Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                  Full Name <span class="text-emerald-400">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-xs">
                    <i class="fas fa-user"></i>
                  </div>
                  <input type="text" name="name" required placeholder="e.g. Alex Miller"
                         class="w-full pl-9 pr-3.5 py-2.5 bg-slate-950/70 border border-slate-800 rounded-xl text-white text-xs sm:text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                </div>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                  Work Email <span class="text-emerald-400">*</span>
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-xs">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <input type="email" name="email" required placeholder="alex@company.com"
                         class="w-full pl-9 pr-3.5 py-2.5 bg-slate-950/70 border border-slate-800 rounded-xl text-white text-xs sm:text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                </div>
              </div>
            </div>

            <!-- 3. Phone & Estimated Budget Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                  Phone / WhatsApp Number
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-xs">
                    <i class="fas fa-phone"></i>
                  </div>
                  <input type="tel" name="phone" placeholder="+1 (555) 000-0000"
                         class="w-full pl-9 pr-3.5 py-2.5 bg-slate-950/70 border border-slate-800 rounded-xl text-white text-xs sm:text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                </div>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                  Estimated Project Budget
                </label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500 text-xs">
                    <i class="fas fa-wallet"></i>
                  </div>
                  <select id="budgetSelect"
                          class="w-full pl-9 pr-8 py-2.5 bg-slate-950/70 border border-slate-800 rounded-xl text-white text-xs sm:text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition appearance-none">
                    <option value="Flexible / To be discussed">Flexible / To be discussed</option>
                    <option value="$1,000 - $3,000">&lt; $3,000 USD (Small Scale)</option>
                    <option value="$3,000 - $10,000">$3,000 – $10,000 USD (Standard Business)</option>
                    <option value="$10,000 - $25,000">$10,000 – $25,000 USD (Enterprise Project)</option>
                    <option value="$25,000+">$25,000+ USD (Custom Architecture)</option>
                  </select>
                  <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500 text-xs">
                    <i class="fas fa-chevron-down"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- 4. Project Details Textarea -->
            <div>
              <div class="flex items-center justify-between mb-1.5">
                <label class="block text-xs font-semibold text-slate-300">
                  Project Scope &amp; Key Requirements <span class="text-emerald-400">*</span>
                </label>
                <span class="text-[11px] text-slate-500">Min 10 characters</span>
              </div>
              <textarea name="message" id="messageTextarea" required rows="5"
                        placeholder="Please describe what you are looking to build (e.g. key functionalities, target users, desired timeline, or reference websites)..."
                        class="w-full p-3.5 bg-slate-950/70 border border-slate-800 rounded-xl text-white text-xs sm:text-sm placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition resize-none"></textarea>
            </div>

            <!-- 5. Submit Action & Confidentiality Note -->
            <div class="pt-2">
              <button type="submit"
                      class="w-full py-3.5 px-6 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm flex items-center justify-center space-x-2 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 transition-all duration-200">
                <span>Send Inquiry &amp; Request Proposal</span>
                <i class="fas fa-arrow-right text-xs"></i>
              </button>

              <div class="flex items-center justify-center space-x-2 mt-3 text-[11px] text-slate-400 text-center">
                <i class="fas fa-lock text-emerald-400"></i>
                <span>Strict confidentiality guaranteed. We never share your data or contact info.</span>
              </div>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ── CLIENT CONSULTATION FAQ ACCORDION ──────────────────────── -->
<section class="py-16 bg-slate-950 border-t border-slate-800/80">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <h2 class="text-2xl font-bold text-white tracking-tight">Frequently Asked Questions</h2>
      <p class="text-xs sm:text-sm text-slate-400 mt-1">What to expect when initiating a technology engagement with EcoTech Services.</p>
    </div>

    <div class="space-y-3">
      <?php
      $contactFaqs = [
        [
          'q' => 'What happens after I submit this inquiry form?',
          'a' => 'An engineering lead will review your specifications within 2 hours during business hours. We will follow up with an initial technical assessment and invite you to a short 20-minute video or phone discovery call.'
        ],
        [
          'q' => 'Can we sign a Non-Disclosure Agreement (NDA) before sharing details?',
          'a' => 'Yes. We routinely execute mutual NDAs prior to discussing proprietary algorithms, confidential business models, or codebases. Simply mention NDA in your message or request one via WhatsApp.'
        ],
        [
          'q' => 'Do you provide fixed-price quotes or hourly billing?',
          'a' => 'Both. For well-defined project scopes, we provide transparent fixed-price milestone milestones. For evolving SaaS platforms or dedicated developer augmentation, we offer weekly or monthly agile sprint billing.'
        ],
        [
          'q' => 'Can your team take over, audit, or refactor an existing software codebase?',
          'a' => 'Yes. We frequently conduct code security audits, database query optimizations, cloud migrations, and full feature modernizations for existing applications.'
        ],
      ];
      foreach ($contactFaqs as $fIdx => $faq):
      ?>
      <div class="border border-slate-800 rounded-2xl bg-slate-900/50 overflow-hidden transition-colors">
        <button type="button"
                onclick="toggleContactFaq(<?= $fIdx ?>)"
                class="w-full p-4 sm:p-5 text-left flex items-center justify-between text-slate-200 hover:text-white transition">
          <span class="text-sm font-semibold pr-4"><?= $faq['q'] ?></span>
          <i id="faqIcon-<?= $fIdx ?>" class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-200"></i>
        </button>
        <div id="faqAnswer-<?= $fIdx ?>" class="hidden px-4 pb-4 sm:px-5 sm:pb-5 text-xs sm:text-sm text-slate-400 leading-relaxed border-t border-slate-800/60 pt-3">
          <?= $faq['a'] ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── INTERACTIVE JAVASCRIPT LOGIC ──────────────────────────── -->
<script>
function selectProjectType(type, btn) {
  document.getElementById('subjectInput').value = type;
  
  // Reset all buttons
  document.querySelectorAll('.project-type-btn').forEach(b => {
    b.classList.remove('bg-emerald-500/15', 'border-emerald-500/40', 'text-emerald-400', 'font-semibold', 'shadow-sm');
    b.classList.add('bg-slate-950/60', 'border-slate-800', 'text-slate-300');
    const dot = b.querySelector('.indicator-dot');
    if (dot) {
      dot.classList.remove('bg-emerald-400');
      dot.classList.add('bg-slate-600');
    }
  });

  // Activate clicked button
  btn.classList.remove('bg-slate-950/60', 'border-slate-800', 'text-slate-300');
  btn.classList.add('bg-emerald-500/15', 'border-emerald-500/40', 'text-emerald-400', 'font-semibold', 'shadow-sm');
  const activeDot = btn.querySelector('.indicator-dot');
  if (activeDot) {
    activeDot.classList.remove('bg-slate-600');
    activeDot.classList.add('bg-emerald-400');
  }
}

function copyToClipboard(text, btn) {
  navigator.clipboard.writeText(text).then(() => {
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-check text-xs text-emerald-400"></i>';
    setTimeout(() => {
      btn.innerHTML = originalHtml;
    }, 2000);
  });
}

function toggleContactFaq(idx) {
  const answer = document.getElementById('faqAnswer-' + idx);
  const icon = document.getElementById('faqIcon-' + idx);
  if (answer && icon) {
    const isHidden = answer.classList.contains('hidden');
    // Close other faqs
    document.querySelectorAll('[id^="faqAnswer-"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id^="faqIcon-"]').forEach(el => el.classList.remove('rotate-180'));
    
    if (isHidden) {
      answer.classList.remove('hidden');
      icon.classList.add('rotate-180');
    }
  }
}

// Append budget selection into message upon submission
document.getElementById('contactForm')?.addEventListener('submit', function() {
  const budget = document.getElementById('budgetSelect')?.value;
  const textarea = document.getElementById('messageTextarea');
  if (budget && textarea && !textarea.value.includes('[Budget:')) {
    textarea.value = textarea.value.trim() + '\n\n[Estimated Budget: ' + budget + ']';
  }
});
</script>

<?php
// ── CONTACT & CONSULTATION ──────────────────────────────────
$siteEmail = setting('site_email') ?: 'ecotech.servic@gmail.com';
$sitePhone = setting('site_phone') ?: '+91 7398301184';
$siteAddr  = setting('site_address') ?: 'Lucknow, Uttar Pradesh, India';
$waNumber  = setting('whatsapp_number');

$projectTypes = [
  'Web Application',
  'Mobile App',
  'Cloud & DevOps',
  'Cybersecurity',
  'AI & Automation',
  'Custom Software',
];

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
    'a' => 'Both. For well-defined project scopes, we provide transparent fixed-price milestones. For evolving SaaS platforms or dedicated developer augmentation, we offer weekly or monthly agile sprint billing.'
  ],
  [
    'q' => 'Can your team take over, audit, or refactor an existing software codebase?',
    'a' => 'Yes. We frequently conduct code security audits, database query optimizations, cloud migrations, and full feature modernizations for existing applications.'
  ],
];

$steps = [
  ['Discovery and feasibility', 'A 30-minute call to understand your requirements, goals and technical constraints.'],
  ['Architecture and fixed-scope proposal', 'A technical breakdown, milestone roadmap and pricing you can review before committing.'],
  ['Sprints and launch', 'Weekly demos, continuous deployment, and support after go-live.'],
];
?>

<!-- ── Hero ─────────────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 8" data-reveal>
        <p class="s-eyebrow">Contact</p>
        <h1 class="s-display">Tell us what you want to build.</h1>
      </div>
      <div style="grid-column:span 4" class="flex flex-col justify-end" data-reveal>
        <p class="s-lede">Talk directly with the engineers who will build it: web and mobile apps, cloud, automation. NDA available on request.</p>
      </div>
    </div>
  </div>
</section>

<!-- ── Direct channels ──────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 4">
        <p class="s-eyebrow">Direct channels</p>
        <h2 class="s-h2">Reach us now</h2>
      </div>
      <div style="grid-column:span 8">
        <dl class="s-kv">
          <?php if ($waNumber): ?>
          <div>
            <dt>WhatsApp</dt>
            <dd>
              <a href="https://wa.me/<?= Security::e($waNumber) ?>?text=Hello%20Ecotech%20Team%2C%20I%20want%20to%20discuss%20a%20new%20project%20inquiry."
                 target="_blank" rel="noopener noreferrer" class="s-link"><i class="fab fa-whatsapp mr-1" aria-hidden="true"></i>Start a chat with the tech lead</a>
            </dd>
          </div>
          <?php endif; ?>
          <div>
            <dt>Email</dt>
            <dd class="flex flex-wrap items-baseline gap-3">
              <a href="mailto:<?= Security::e($siteEmail) ?>" class="s-link break-all"><?= Security::e($siteEmail) ?></a>
              <button type="button" onclick="copyToClipboard('<?= Security::e($siteEmail) ?>', this)" title="Copy email" class="s-btn--line s-btn--sm">Copy</button>
            </dd>
          </div>
          <div>
            <dt>Phone</dt>
            <dd>
              <a href="tel:<?= Security::e($sitePhone) ?>" class="s-link"><?= Security::e($sitePhone) ?></a>
              <span class="s-mute s-small block mt-1">Mon &ndash; Sat, 9:00 AM &ndash; 7:30 PM IST</span>
            </dd>
          </div>
          <div>
            <dt>Studio</dt>
            <dd>
              <?= Security::e($siteAddr) ?>
              <span class="s-mute s-small block mt-1">Working with clients in India, the UK, the UAE and the USA</span>
            </dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</section>

<!-- ── How we work ──────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <p class="s-eyebrow">How we work</p>
    <h2 class="s-h2 mb-10">Three steps from first message to launch</h2>
    <ol class="s-list">
      <?php foreach ($steps as $sIdx => $step): ?>
      <li data-reveal>
        <span class="s-num"><?= str_pad((string)($sIdx + 1), 2, '0', STR_PAD_LEFT) ?></span>
        <h3 class="s-h3"><?= Security::e($step[0]) ?></h3>
        <p><?= Security::e($step[1]) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ── Inquiry form ─────────────────────────────────────────── -->
<section class="s-sec" id="inquiry">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 4">
        <p class="s-eyebrow">Project brief</p>
        <h2 class="s-h2">Send an inquiry</h2>
        <p class="s-mute mt-4">An engineering lead reads every brief. We never share your details.</p>
      </div>

      <div style="grid-column:span 8">
        <form id="contactForm" action="<?= url('contact/send') ?>" method="POST">
          <?= Security::csrfField() ?>

          <div class="s-field">
            <span class="s-label" id="projectTypeLabel">Project type <span class="s-req">*</span></span>
            <div class="s-choices" id="projectTypeGrid" role="group" aria-labelledby="projectTypeLabel">
              <?php foreach ($projectTypes as $idx => $pt): ?>
              <button type="button"
                      onclick="selectProjectType('<?= Security::e($pt) ?>', this)"
                      class="project-type-btn s-choice<?= $idx === 0 ? ' is-active' : '' ?>"
                      aria-pressed="<?= $idx === 0 ? 'true' : 'false' ?>">
                <?= Security::e($pt) ?>
              </button>
              <?php endforeach; ?>
            </div>
            <input type="hidden" name="subject" id="subjectInput" value="Web Application">
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
            <div class="s-field">
              <label class="s-label" for="cName">Full name <span class="s-req">*</span></label>
              <input type="text" id="cName" name="name" required placeholder="e.g. Alex Miller" class="s-input" autocomplete="name">
            </div>
            <div class="s-field">
              <label class="s-label" for="cEmail">Work email <span class="s-req">*</span></label>
              <input type="email" id="cEmail" name="email" required placeholder="alex@company.com" class="s-input" autocomplete="email">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
            <div class="s-field">
              <label class="s-label" for="cPhone">Phone / WhatsApp</label>
              <input type="tel" id="cPhone" name="phone" placeholder="+1 (555) 000-0000" class="s-input" autocomplete="tel">
            </div>
            <div class="s-field">
              <label class="s-label" for="budgetSelect">Estimated budget</label>
              <select id="budgetSelect" class="s-select">
                <option value="Flexible / To be discussed">Flexible / To be discussed</option>
                <option value="$1,000 - $3,000">&lt; $3,000 USD (Small scale)</option>
                <option value="$3,000 - $10,000">$3,000 &ndash; $10,000 USD (Standard business)</option>
                <option value="$10,000 - $25,000">$10,000 &ndash; $25,000 USD (Enterprise project)</option>
                <option value="$25,000+">$25,000+ USD (Custom architecture)</option>
              </select>
            </div>
          </div>

          <div class="s-field">
            <label class="s-label" for="messageTextarea">Scope and key requirements <span class="s-req">*</span></label>
            <textarea name="message" id="messageTextarea" required rows="6" class="s-textarea"
                      placeholder="What are you building? Key features, target users, timeline, reference sites."></textarea>
            <p class="s-help">Minimum 10 characters.</p>
          </div>

          <div class="s-actions">
            <button type="submit" class="s-btn">Send inquiry</button>
            <span class="s-small s-mute"><i class="fas fa-lock mr-1" aria-hidden="true"></i>Kept confidential.</span>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ── FAQ ──────────────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 4">
        <p class="s-eyebrow">FAQ</p>
        <h2 class="s-h2">Before you write</h2>
      </div>
      <div style="grid-column:span 8">
        <div class="s-acc">
          <?php foreach ($contactFaqs as $fIdx => $faq): ?>
          <div class="s-acc-item">
            <button class="s-acc-btn" type="button" data-acc aria-expanded="false" aria-controls="faqAnswer-<?= $fIdx ?>">
              <?= Security::e($faq['q']) ?> <span class="s-acc-sign" id="faqIcon-<?= $fIdx ?>" aria-hidden="true">+</span>
            </button>
            <div class="s-acc-panel" id="faqAnswer-<?= $fIdx ?>" hidden><?= Security::e($faq['a']) ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Closing band ─────────────────────────────────────────── -->
<section class="s-band s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <h2 class="s-h1">Prefer to talk first?</h2>
      </div>
      <div style="grid-column:span 5" class="flex flex-col justify-end">
        <p class="s-lede">Call or email and we'll set up a short discovery call.</p>
        <div class="s-actions mt-6">
          <a href="tel:<?= Security::e($sitePhone) ?>" class="s-btn--light">Call <?= Security::e($sitePhone) ?></a>
          <a href="mailto:<?= Security::e($siteEmail) ?>" class="s-btn--line">Email us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
function selectProjectType(type, btn) {
  document.getElementById('subjectInput').value = type;
  document.querySelectorAll('.project-type-btn').forEach(b => {
    b.classList.remove('is-active');
    b.setAttribute('aria-pressed', 'false');
  });
  btn.classList.add('is-active');
  btn.setAttribute('aria-pressed', 'true');
}

function copyToClipboard(text, btn) {
  navigator.clipboard.writeText(text).then(() => {
    const original = btn.textContent;
    btn.textContent = 'Copied';
    setTimeout(() => { btn.textContent = original; }, 2000);
  });
}

// Append budget selection into message upon submission
document.getElementById('contactForm')?.addEventListener('submit', function() {
  const budget = document.getElementById('budgetSelect')?.value;
  const textarea = document.getElementById('messageTextarea');
  if (budget && textarea && !textarea.value.includes('[Estimated Budget:')) {
    textarea.value = textarea.value.trim() + '\n\n[Estimated Budget: ' + budget + ']';
  }
});
</script>

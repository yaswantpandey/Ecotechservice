<?php
// ------------------------------------------------------------
// PromptWars × Sudarshan — Official Event Page
// Synchronized from Hack2Skill: https://hack2skill.com/event/promptwars-x-sudarshan
// ------------------------------------------------------------
$startLabel = date('j M Y', strtotime($event['starts']));
$endLabel   = date('j M Y', strtotime($event['ends']));
$dateRange  = date('j', strtotime($event['starts'])) . ' – ' . $endLabel;
?>

<!-- ── HERO ─────────────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb">
      <a href="<?= url('') ?>">Home</a><span>/</span>
      <a href="<?= url('events') ?>">Events</a><span>/</span>
      <span aria-current="page"><?= Security::e($event['name']) ?></span>
    </nav>

    <div class="s-grid mt-8">
      <div style="grid-column:span 8" data-reveal>
        <p class="s-eyebrow">National AI Hackathon &middot; <?= Security::e($dateRange) ?></p>
        <h1 class="s-display mt-4"><?= Security::e($event['name']) ?></h1>
        <p class="s-lede mt-6"><?= Security::e($event['tagline']) ?></p>

        <div class="s-actions mt-8">
          <a href="<?= Security::e($event['registration_cta'] ?? $event['register_url']) ?>" class="s-btn" target="_blank" rel="noopener noreferrer">
            Register on <?= Security::e($event['partner']) ?> &rarr;
          </a>
          <?php if (!empty($event['whatsapp_url'])): ?>
          <a href="<?= Security::e($event['whatsapp_url']) ?>" class="s-btn--line" target="_blank" rel="noopener noreferrer" style="border-color:#25D366;color:#25D366">
            💬 Join WhatsApp Group
          </a>
          <?php endif; ?>
          <a href="#tracks" class="s-btn--line">Explore Challenges</a>
        </div>
        
        <div class="flex items-center gap-3 flex-wrap mt-5">
          <span class="s-tag" style="background:rgba(239,68,68,0.12);color:#ef4444;border-color:rgba(239,68,68,0.3)">
            ● <?= Security::e($event['registration_note']) ?>
          </span>
          <span class="s-tag" style="background:rgba(110,231,183,0.12);color:#6ee7b7;border-color:rgba(110,231,183,0.3)">
            <?= Security::e($event['fee']) ?>
          </span>
          <span class="s-mono s-mute" style="font-size:0.875rem">
            <?= Security::e($event['submission_note'] ?? '') ?>
          </span>
        </div>
      </div>

      <aside style="grid-column:span 4" class="mt-8 lg:mt-0" data-reveal>
        <div class="s-panel s-panel--deep">
          <p class="s-eyebrow">Event Specifications</p>
          <dl class="s-kv mt-4">
            <div>
              <dt>Format</dt>
              <dd><strong><?= Security::e($event['mode']) ?></strong></dd>
            </div>
            <div>
              <dt>Venue</dt>
              <dd><?= Security::e($event['venue']) ?></dd>
            </div>
            <div>
              <dt>Team Size</dt>
              <dd><?= Security::e($event['team_size']) ?></dd>
            </div>
            <div>
              <dt>Eligibility</dt>
              <dd><?= Security::e($event['eligibility']) ?></dd>
            </div>
            <div>
              <dt>Total Rewards</dt>
              <dd><strong><?= Security::e($event['prize_pool']) ?></strong></dd>
            </div>
            <div>
              <dt>Entry Fee</dt>
              <dd><?= Security::e($event['fee']) ?></dd>
            </div>
            <div>
              <dt>Direct Desk</dt>
              <dd><a href="mailto:<?= Security::e($event['email']) ?>" class="s-link"><?= Security::e($event['email']) ?></a></dd>
            </div>
          </dl>
        </div>
      </aside>
    </div>

    <div class="s-figs mt-14 lg:grid-cols-4" data-reveal>
      <div class="s-fig">
        <b>04</b>
        <span>Real-world AI challenge tracks</span>
      </div>
      <div class="s-fig">
        <b>₹20,000</b>
        <span>Cash prize pool for winning solutions</span>
      </div>
      <div class="s-fig">
        <b>$400</b>
        <span>In generative AI &amp; cloud credits</span>
      </div>
      <div class="s-fig">
        <b>Internships</b>
        <span>Fast-track engineering roles at Ecotech</span>
      </div>
    </div>
  </div>
</section>

<!-- ── PARTNERS & ECOSYSTEM ─────────────────────────────────── -->
<?php if (!empty($partners)): ?>
<section class="s-sec" style="padding-top:2rem;padding-bottom:2rem;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
  <div class="s-shell">
    <p class="s-eyebrow text-center mb-6">Organizers, Ecosystem &amp; Platform Partners</p>
    <div class="flex items-center justify-center gap-8 lg:gap-14 flex-wrap">
      <?php foreach ($partners as $partner): ?>
      <a href="<?= Security::e($partner['url']) ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3" style="text-decoration:none;opacity:0.85;transition:opacity 0.2s" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
        <?php if (!empty($partner['image'])): ?>
        <img src="<?= Security::e($partner['image']) ?>" alt="<?= Security::e($partner['name']) ?>" style="height:36px;width:auto;object-fit:contain;border-radius:4px" loading="lazy">
        <?php endif; ?>
        <div>
          <span style="font-weight:600;font-size:0.95rem;color:var(--fg);display:block"><?= Security::e($partner['name']) ?></span>
          <span class="s-mono s-mute" style="font-size:0.75rem"><?= Security::e($partner['role']) ?></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── ABOUT & MENTORSHIP ───────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5" data-reveal>
        <p class="s-eyebrow">About PromptWars</p>
        <h2 class="s-h2 mt-4">Vibe coding &amp; rapid prototyping under real constraints.</h2>
        <p class="s-mute mt-4" style="line-height:1.65">
          In an era driven by generative AI and autonomous workflows, the rules of software development have evolved. PromptWars isn't just about writing code from scratch — it's about sharp thinking, prompt engineering, multi-agent reasoning, and building deployable prototypes in hours.
        </p>
      </div>

      <div style="grid-column:span 7" data-reveal>
        <div class="s-prose">
          <p><?= Security::e($event['summary']) ?></p>
        </div>

        <div class="s-grid lg:grid-cols-2 gap-4 mt-8">
          <div class="s-panel">
            <h3 class="s-h3" style="font-size:1.1rem">Surprise Problem Statements</h3>
            <p class="s-mute mt-2" style="font-size:0.9rem;line-height:1.55">
              Tackle pressing real-world challenges in disaster intelligence, adaptive tutoring, and synthetic media verification.
            </p>
          </div>
          <div class="s-panel">
            <h3 class="s-h3" style="font-size:1.1rem">Ecotech Engineering Mentorship</h3>
            <p class="s-mute mt-2" style="font-size:0.9rem;line-height:1.55">
              Direct guidance from Ecotech Services engineering leads on system architecture, prompt resilience, and model pipelines.
            </p>
          </div>
          <div class="s-panel">
            <h3 class="s-h3" style="font-size:1.1rem">Fast-Track Internship Tracks</h3>
            <p class="s-mute mt-2" style="font-size:0.9rem;line-height:1.55">
              Standout solo builders receive direct interview priority and internship offers to build production systems at Ecotech Services.
            </p>
          </div>
          <div class="s-panel">
            <h3 class="s-h3" style="font-size:1.1rem">Verified Digital Credentials</h3>
            <p class="s-mute mt-2" style="font-size:0.9rem;line-height:1.55">
              Every verified participant receives official Hack2Skill achievement badges and certificates of completion for their portfolio.
            </p>
          </div>
        </div>

        <dl class="s-kv mt-8">
          <div><dt>Organized by</dt><dd><?= Security::e($event['host']) ?></dd></div>
          <div><dt>Mentorship &amp; Co-Host</dt><dd><?= Security::e($event['co_host']) ?></dd></div>
          <div><dt>Ecosystem &amp; Platform</dt><dd><?= Security::e($event['partner']) ?> &amp; Google for Developers</dd></div>
          <div><dt>Who can enter</dt><dd><?= Security::e($event['eligibility']) ?></dd></div>
        </dl>
      </div>
    </div>
  </div>
</section>

<!-- ── CHALLENGE TRACKS ─────────────────────────────────────── -->
<section class="s-sec" id="tracks">
  <div class="s-shell">
    <div class="s-grid mb-10">
      <div style="grid-column:span 6" data-reveal>
        <p class="s-eyebrow">Challenge Tracks</p>
        <h2 class="s-h2 mt-3">Choose your problem. Build your solution.</h2>
      </div>
      <div style="grid-column:span 6" class="flex items-end justify-start lg:justify-end" data-reveal>
        <p class="s-mute" style="max-width:45ch">
          Select one of the 4 challenge statements. A focused, running solution with deep AI integration scores far higher than a generic chatbot wrapper.
        </p>
      </div>
    </div>

    <div class="s-grid lg:grid-cols-2 gap-8" data-reveal>
      <?php foreach ($tracks as $ti => $track): ?>
      <article class="s-panel s-panel--deep flex flex-col justify-between" style="padding:2rem">
        <div>
          <?php if (!empty($track['image'])): ?>
          <div class="mb-5 overflow-hidden rounded" style="border:1px solid var(--line);background:#000">
            <img src="<?= Security::e($track['image']) ?>" alt="<?= Security::e($track['name']) ?>" style="width:100%;height:180px;object-fit:cover" loading="lazy">
          </div>
          <?php endif; ?>

          <div class="flex items-center justify-between gap-3 flex-wrap">
            <span class="s-tag" style="background:rgba(110,231,183,0.1);color:#6ee7b7;border-color:rgba(110,231,183,0.25)">
              Track <?= str_pad((string)($ti + 1), 2, '0', STR_PAD_LEFT) ?> &middot; <?= Security::e($track['category']) ?>
            </span>
          </div>

          <h3 class="s-h3 mt-3"><?= Security::e($track['name']) ?></h3>

          <div class="mt-4">
            <p class="s-mono s-mute" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.05em">Context</p>
            <p class="mt-1" style="font-size:0.925rem;line-height:1.55;color:var(--mute)">
              <?= Security::e($track['context']) ?>
            </p>
          </div>

          <div class="mt-4">
            <p class="s-mono s-mute" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.05em">What to build</p>
            <p class="mt-1" style="font-size:0.95rem;line-height:1.6">
              <?= Security::e($track['brief']) ?>
            </p>
          </div>
        </div>

        <div class="mt-6 pt-4" style="border-top:1px solid var(--line)">
          <div class="s-tags">
            <?php foreach ($track['tags'] as $tag): ?>
            <span class="s-tag" style="font-size:0.75rem"><?= Security::e($tag) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── TIMELINE ─────────────────────────────────────────────── -->
<section class="s-sec" id="timeline">
  <div class="s-shell">
    <div class="s-grid" style="align-items:end">
      <div style="grid-column:span 6" data-reveal>
        <p class="s-eyebrow">Hackathon Schedule</p>
        <h2 class="s-h2 mt-4">Key dates from registration to finale.</h2>
      </div>
      <div style="grid-column:span 6" class="flex items-end justify-start lg:justify-end" data-reveal>
        <p class="s-mono s-mute">All dates and times in Indian Standard Time (IST)</p>
      </div>
    </div>

    <div class="mt-10" data-reveal>
      <ol class="s-list">
        <?php foreach ($timeline as $step): ?>
        <li>
          <span class="s-num"><?= Security::e(date('d M', strtotime($step['date']))) ?></span>
          <div>
            <span class="s-mono s-mute" style="font-size:0.8rem"><?= Security::e($step['time']) ?></span>
            <h3 class="s-h3 mt-1"><?= Security::e($step['label']) ?></h3>
            <p class="mt-2"><?= Security::e($step['detail']) ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- ── PRIZES & REWARDS ─────────────────────────────────────── -->
<section class="s-sec" id="prizes">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5" data-reveal>
        <p class="s-eyebrow">Prizes &amp; Opportunities</p>
        <h2 class="s-h2 mt-4">Rewarding exceptional execution.</h2>
        <p class="s-mute mt-4" style="line-height:1.65">
          Top performers take home cash prizes, cloud AI credits, and career opportunities. Standout solo builders will be invited for direct fast-track internship evaluations with the Ecotech Services engineering team.
        </p>
        <div class="mt-6">
          <a href="<?= Security::e($event['registration_cta'] ?? $event['register_url']) ?>" class="s-btn" target="_blank" rel="noopener noreferrer">
            Register to compete &rarr;
          </a>
        </div>
      </div>

      <div style="grid-column:span 7" data-reveal>
        <div class="s-table-wrap">
          <table class="s-table" style="min-width:520px">
            <thead>
              <tr>
                <th style="width:28%">Award Tier</th>
                <th style="width:26%">Reward</th>
                <th>Benefit Details</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rewards as $reward): ?>
              <tr>
                <td><strong><?= Security::e($reward['place']) ?></strong></td>
                <td><span class="s-mono" style="color:#6ee7b7;font-weight:600"><?= Security::e($reward['value']) ?></span></td>
                <td><?= Security::e($reward['note']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── JURY & MENTORS ───────────────────────────────────────── -->
<section class="s-sec" id="jury">
  <div class="s-shell">
    <div class="s-grid mb-10">
      <div style="grid-column:span 6" data-reveal>
        <p class="s-eyebrow">Jury &amp; Mentorship Panel</p>
        <h2 class="s-h2 mt-3">Evaluated by active practitioners</h2>
      </div>
      <div style="grid-column:span 6" class="flex items-end justify-start lg:justify-end" data-reveal>
        <p class="s-mute" style="max-width:45ch">
          Experienced engineers and founders who review your real code, prompt strategies, and architectural decisions.
        </p>
      </div>
    </div>

    <!-- Jury Cards -->
    <h3 class="s-eyebrow mb-4">Official Jury Panel</h3>
    <div class="s-grid lg:grid-cols-3 gap-6 mb-12" data-reveal>
      <?php foreach ($jury as $member): ?>
      <div class="s-panel flex flex-col justify-between" style="padding:1.75rem">
        <div>
          <div class="flex items-center gap-4">
            <?php if (!empty($member['image'])): ?>
            <img src="<?= Security::e($member['image']) ?>" alt="<?= Security::e($member['name']) ?>" style="width:54px;height:54px;border-radius:50%;object-fit:cover;border:2px solid var(--line)" loading="lazy">
            <?php else: ?>
            <div style="width:54px;height:54px;border-radius:50%;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--fg)">
              <?= Security::e(substr($member['name'], 0, 2)) ?>
            </div>
            <?php endif; ?>
            <div>
              <h4 class="s-h3" style="font-size:1.1rem"><?= Security::e($member['name']) ?></h4>
              <p class="s-mono s-mute" style="font-size:0.8rem"><?= Security::e($member['role']) ?></p>
            </div>
          </div>
          <p class="mt-3 s-mute" style="font-size:0.875rem"><?= Security::e($member['organization']) ?></p>
        </div>

        <div class="mt-4 pt-3 flex gap-3" style="border-top:1px solid var(--line)">
          <?php if (!empty($member['linkedin'])): ?>
          <a href="<?= Security::e($member['linkedin']) ?>" target="_blank" rel="noopener noreferrer" class="s-link" style="font-size:0.85rem">LinkedIn &rarr;</a>
          <?php endif; ?>
          <?php if (!empty($member['github'])): ?>
          <a href="<?= Security::e($member['github']) ?>" target="_blank" rel="noopener noreferrer" class="s-link" style="font-size:0.85rem">GitHub &rarr;</a>
          <?php endif; ?>
          <?php if (!empty($member['instagram'])): ?>
          <a href="<?= Security::e($member['instagram']) ?>" target="_blank" rel="noopener noreferrer" class="s-link" style="font-size:0.85rem">Instagram &rarr;</a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Mentors Cards -->
    <h3 class="s-eyebrow mb-4">Technical Mentors</h3>
    <div class="s-grid lg:grid-cols-2 gap-6" data-reveal>
      <?php foreach ($mentors as $mentor): ?>
      <div class="s-panel flex flex-col justify-between" style="padding:1.75rem">
        <div>
          <div class="flex items-center gap-4">
            <?php if (!empty($mentor['image'])): ?>
            <img src="<?= Security::e($mentor['image']) ?>" alt="<?= Security::e($mentor['name']) ?>" style="width:54px;height:54px;border-radius:50%;object-fit:cover;border:2px solid var(--line)" loading="lazy">
            <?php else: ?>
            <div style="width:54px;height:54px;border-radius:50%;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--fg)">
              <?= Security::e(substr($mentor['name'], 0, 2)) ?>
            </div>
            <?php endif; ?>
            <div>
              <h4 class="s-h3" style="font-size:1.1rem"><?= Security::e($mentor['name']) ?></h4>
              <p class="s-mono s-mute" style="font-size:0.8rem"><?= Security::e($mentor['role']) ?></p>
            </div>
          </div>
          <p class="mt-3 s-mute" style="font-size:0.875rem"><?= Security::e($mentor['organization']) ?></p>
        </div>

        <div class="mt-4 pt-3 flex gap-3" style="border-top:1px solid var(--line)">
          <?php if (!empty($mentor['linkedin'])): ?>
          <a href="<?= Security::e($mentor['linkedin']) ?>" target="_blank" rel="noopener noreferrer" class="s-link" style="font-size:0.85rem">LinkedIn &rarr;</a>
          <?php endif; ?>
          <?php if (!empty($mentor['github'])): ?>
          <a href="<?= Security::e($mentor['github']) ?>" target="_blank" rel="noopener noreferrer" class="s-link" style="font-size:0.85rem">GitHub &rarr;</a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── JUDGING CRITERIA ─────────────────────────────────────── -->
<section class="s-sec" id="judging">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5" data-reveal>
        <p class="s-eyebrow">Scoring Rubric</p>
        <h2 class="s-h2 mt-4">How your project is evaluated.</h2>
        <p class="s-mute mt-4" style="line-height:1.65">
          Judges evaluate code repositories, system design, prompt craftsmanship, and interactive demos. Working software carries the single heaviest weight.
        </p>
      </div>

      <div style="grid-column:span 7" data-reveal>
        <div class="s-table-wrap">
          <table class="s-table" style="min-width:520px">
            <thead>
              <tr>
                <th style="width:28%">Criterion</th>
                <th style="width:14%">Weight</th>
                <th>What the panel evaluates</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($judging as $criterion): ?>
              <tr>
                <td><strong><?= Security::e($criterion[0]) ?></strong></td>
                <td><span class="s-mono" style="color:#6ee7b7"><?= Security::e($criterion[1]) ?></span></td>
                <td><?= Security::e($criterion[2]) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="s-small s-mute mt-4">
          All evaluations are conducted transparently in accordance with official Hack2Skill hackathon scoring guidelines.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ── GUIDELINES & SUBMISSION RULES ────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" data-reveal>
      <div style="grid-column:span 6">
        <p class="s-eyebrow">Submission Requirements</p>
        <h2 class="s-h2 mt-4">Essential checklist before you submit.</h2>
      </div>
      <div style="grid-column:span 6">
        <ol class="s-list">
          <li>
            <span class="s-num">01</span>
            <div>
              <h3 class="s-h3">Solo Builder Format</h3>
              <p>PromptWars × Sudarshan is an individual challenge (1 member per registration). Build, prompt, and deploy your project individually.</p>
            </div>
          </li>
          <li>
            <span class="s-num">02</span>
            <div>
              <h3 class="s-h3">Working Demo &amp; Code Repository</h3>
              <p>Submissions must include a link to a public GitHub repository, architectural explanation of how AI/prompts are utilized, and a live demo link or video walkthrough.</p>
            </div>
          </li>
          <li>
            <span class="s-num">03</span>
            <div>
              <h3 class="s-h3">Prompt &amp; Model Authenticity</h3>
              <p>Pure UI mockups or cosmetic wrappers without authentic AI/LLM integration will be disqualified during technical screening.</p>
            </div>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ── FAQS ─────────────────────────────────────────────────── -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5" data-reveal>
        <p class="s-eyebrow">Frequently Asked Questions</p>
        <h2 class="s-h2 mt-4">Everything you need to know before registering.</h2>
        <p class="s-mute mt-4" style="line-height:1.65">
          Have more questions? Join the official builder WhatsApp group or reach out to our team directly.
        </p>
        <div class="s-actions mt-6">
          <a href="mailto:<?= Security::e($event['email']) ?>" class="s-btn--line s-btn--sm">Email Organizers</a>
          <?php if (!empty($event['whatsapp_url'])): ?>
          <a href="<?= Security::e($event['whatsapp_url']) ?>" target="_blank" rel="noopener noreferrer" class="s-btn--line s-btn--sm" style="border-color:#25D366;color:#25D366">WhatsApp Group</a>
          <?php endif; ?>
        </div>
      </div>

      <div style="grid-column:span 7" data-reveal>
        <div class="s-acc">
          <?php foreach ($faqs as $qi => $qa): ?>
          <div class="s-acc-item">
            <button class="s-acc-btn" data-acc aria-expanded="false" aria-controls="event-faq-<?= $qi ?>">
              <?= Security::e($qa[0]) ?>
              <span class="s-acc-sign" aria-hidden="true">+</span>
            </button>
            <div class="s-acc-panel" id="event-faq-<?= $qi ?>" hidden>
              <p><?= Security::e($qa[1]) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA BANNER ───────────────────────────────────────────── -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid items-center">
      <div style="grid-column:span 7" data-reveal>
        <p class="s-eyebrow" style="color:var(--band-mute)">Ready to Build?</p>
        <h2 class="s-h2 mt-3">Ship your AI prototype at PromptWars × Sudarshan.</h2>
        <p class="mt-4" style="color:var(--band-mute);max-width:55ch">
          Join hundreds of engineers, student builders, and AI enthusiasts across India. Registration is 100% free.
        </p>
      </div>
      <div style="grid-column:span 5" class="flex flex-col lg:items-end justify-center mt-6 lg:mt-0" data-reveal>
        <div class="s-actions">
          <a href="<?= Security::e($event['registration_cta'] ?? $event['register_url']) ?>" class="s-btn--light" target="_blank" rel="noopener noreferrer">
            Register on Hack2Skill &rarr;
          </a>
          <?php if (!empty($event['whatsapp_url'])): ?>
          <a href="<?= Security::e($event['whatsapp_url']) ?>" class="s-btn--line" style="color:var(--band-fg);border-color:var(--band-fg)" target="_blank" rel="noopener noreferrer">
            Join WhatsApp
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── SCHEMA.ORG EVENT STRUCTURED DATA ─────────────────────── -->
<script type="application/ld+json">
<?= json_encode([
    '@context'            => 'https://schema.org',
    '@type'               => 'Event',
    'name'                => $event['name'],
    'description'         => $event['tagline'] . ' - ' . $event['summary'],
    'startDate'           => $event['starts'],
    'endDate'             => $event['ends'],
    'eventStatus'         => 'https://schema.org/EventScheduled',
    'eventAttendanceMode' => 'https://schema.org/OnlineEventAttendanceMode',
    'url'                 => url('events/' . $event['slug']),
    'image'               => [
        $event['banner_image'],
        url('assets/img/logo.png'),
    ],
    'location'            => [
        '@type' => 'VirtualLocation',
        'url'   => $event['register_url'],
    ],
    'organizer'           => [
        [
            '@type' => 'Organization',
            'name'  => $event['host'],
        ],
        [
            '@type' => 'Organization',
            'name'  => $event['co_host'],
            'url'   => url(''),
        ],
        [
            '@type' => 'Organization',
            'name'  => $event['partner'],
            'url'   => 'https://hack2skill.com',
        ],
    ],
    'offers'              => [
        '@type'         => 'Offer',
        'price'         => 0,
        'priceCurrency' => 'INR',
        'availability'  => 'https://schema.org/InStock',
        'url'           => $event['register_url'],
        'validFrom'     => '2026-11-04T00:00:00+05:30',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

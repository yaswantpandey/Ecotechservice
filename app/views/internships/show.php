<!-- ── INTERNSHIP TRACK DETAIL ──────────────────────────────── -->
<?php
$skills = array_filter(array_map('trim', explode(',', (string) $track['skills'])));
$applyUrl = url('internships/apply?slug=' . urlencode((string) $track['slug']));
?>

<section class="s-sec s-sec--tight">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb" style="margin-bottom:2rem">
      <a href="<?= url('internships') ?>">Internships</a>
      <span>/</span>
      <span aria-current="page"><?= Security::e($track['title']) ?></span>
    </nav>

    <div class="s-grid">
      <div style="grid-column:span 8">
        <span class="s-eyebrow">Internship track</span>
        <h1 class="s-h1"><?= Security::e($track['title']) ?> <span class="s-it">internship</span></h1>
        <p class="s-lede" style="margin-top:1.25rem"><?= Security::e($track['short_desc']) ?></p>
      </div>
      <div style="grid-column:span 4;align-self:end">
        <div class="s-actions">
          <?php if ($alreadyApplied): ?>
            <span class="s-tag s-tag--signal">You have applied for this track</span>
            <a href="<?= url('internships/dashboard') ?>" class="s-btn--line">View status</a>
          <?php else: ?>
            <a href="<?= Security::e($applyUrl) ?>" class="s-btn">Apply for this track</a>
            <a href="<?= url('internships') ?>" class="s-btn--line">All tracks</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <dl class="s-figs" style="margin:3rem 0 0">
      <?php foreach ([
        ['label' => 'Duration',  'value' => ((int) $track['duration_weeks']) . ' weeks'],
        ['label' => 'Work mode', 'value' => (string) $track['mode']],
        ['label' => 'Stipend',   'value' => (string) $track['stipend_text']],
        ['label' => 'Seats',     'value' => (string) ((int) $track['seats'])],
      ] as $fact): ?>
        <div class="s-fig">
          <dt class="s-eyebrow" style="margin-bottom:.5rem"><?= Security::e($fact['label']) ?></dt>
          <dd class="s-h3" style="margin:0"><?= Security::e($fact['value']) ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>

<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" style="gap:3rem 1.5rem">

      <!-- Main column -->
      <div style="grid-column:span 8">
        <div style="margin-bottom:3.5rem">
          <span class="s-eyebrow">01 &mdash; About</span>
          <h2 class="s-h2" style="margin-bottom:1.25rem">About this track</h2>
          <div class="s-prose"><p><?= Security::e($track['description']) ?></p></div>
        </div>

        <div style="margin-bottom:3.5rem">
          <span class="s-eyebrow">02 &mdash; Stack</span>
          <h2 class="s-h2" style="margin-bottom:1.25rem">What you will work with</h2>
          <?php if ($skills): ?>
            <div class="s-tags">
              <?php foreach ($skills as $skill): ?>
                <span class="s-tag"><?= Security::e($skill) ?></span>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="s-mute">Details will be shared during onboarding.</p>
          <?php endif; ?>
        </div>

        <div style="margin-bottom:3.5rem">
          <span class="s-eyebrow">03 &mdash; Fit</span>
          <h2 class="s-h2" style="margin-bottom:1.25rem">Who should apply</h2>
          <div class="s-prose">
            <ul>
              <?php foreach ([
                'Students and recent graduates who can commit to the full ' . ((int) $track['duration_weeks']) . '-week term.',
                'Anyone with working fundamentals in the areas listed above — you do not need professional experience.',
                'Candidates comfortable receiving code review and iterating on feedback.',
                'Applicants who can dedicate consistent weekly hours alongside their studies.',
              ] as $who): ?>
                <li><?= Security::e($who) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <div>
          <span class="s-eyebrow">04 &mdash; Outcomes</span>
          <h2 class="s-h2" style="margin-bottom:1.25rem">What you receive</h2>
          <dl class="s-kv">
            <?php foreach ([
              ['title' => 'Formal offer letter',    'desc' => 'Generated automatically on selection.'],
              ['title' => 'Completion certificate', 'desc' => 'Issued on finishing the full term.'],
              ['title' => 'Mentor reviews',         'desc' => 'Direct feedback on the work you produce.'],
              ['title' => 'Portfolio project',      'desc' => 'Real work you can show an employer.'],
            ] as $perk): ?>
              <div>
                <dt><?= Security::e($perk['title']) ?></dt>
                <dd><?= Security::e($perk['desc']) ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
        </div>
      </div>

      <!-- Sidebar -->
      <aside style="grid-column:span 4">
        <div class="s-panel s-panel--deep lg:sticky" style="top:calc(var(--nav-h) + 1.5rem)">
          <h3 class="s-h3" style="margin-bottom:.75rem">
            <?= $alreadyApplied ? 'Application submitted' : 'Apply for this track' ?>
          </h3>

          <?php if ($alreadyApplied): ?>
            <p class="s-small" style="color:var(--ink-2);margin:0 0 1.25rem">
              Your application is on file. You can follow its progress from your dashboard.
            </p>
            <a href="<?= url('internships/dashboard') ?>" class="s-btn s-btn--block">Go to dashboard</a>
          <?php else: ?>
            <p class="s-small" style="color:var(--ink-2);margin:0 0 1.25rem">
              <?php if (isIntern()): ?>
                You are signed in. Attach your resume and tell us why this track suits you.
              <?php else: ?>
                Create an account or sign in, then submit your resume for this track.
              <?php endif; ?>
            </p>

            <a href="<?= Security::e($applyUrl) ?>" class="s-btn s-btn--block">Start application</a>

            <?php if (!isIntern()): ?>
              <p class="s-small s-mute" style="margin:1rem 0 0">
                Already registered?
                <a href="<?= url('internships/login') ?>" class="s-link">Sign in</a>
              </p>
            <?php endif; ?>
          <?php endif; ?>

          <dl class="s-kv" style="margin-top:1.5rem">
            <div><dt>Resume</dt><dd>PDF, DOC or DOCX</dd></div>
            <div><dt>Privacy</dt><dd>Your resume stays private</dd></div>
            <div><dt>Updates</dt><dd>Email on every change</dd></div>
          </dl>
        </div>

        <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--rule)">
          <h3 class="s-h3" style="font-size:1.1rem;margin-bottom:.5rem">Need help?</h3>
          <p class="s-small s-mute" style="margin:0 0 .75rem">
            If you are unsure which track fits you best, get in touch and we will point you in the right direction.
          </p>
          <a href="<?= url('contact') ?>" class="s-link s-small">Contact our team</a>
        </div>
      </aside>
    </div>
  </div>
</section>

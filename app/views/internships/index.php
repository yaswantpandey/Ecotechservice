<!-- ── INTERNSHIPS — TRACK LISTING ──────────────────────────── -->

<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 8">
        <span class="s-eyebrow">Internship programme <?= date('Y') ?></span>
        <h1 class="s-display">Build real software. <span class="s-it">Get mentored.</span></h1>
      </div>
      <div style="grid-column:span 4" class="flex flex-col justify-end">
        <p class="s-lede">
          Eleven engineering tracks, each built around production-style work rather than tutorials.
          Apply online, track your application, and receive a formal offer letter on selection.
        </p>
        <div class="s-actions" style="margin-top:1.75rem">
          <?php if (isIntern()): ?>
            <a href="<?= url('internships/dashboard') ?>" class="s-btn">My dashboard</a>
          <?php else: ?>
            <a href="<?= url('internships/register') ?>" class="s-btn">Create an account</a>
            <a href="<?= url('internships/login') ?>" class="s-btn--line">Sign in</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="s-figs" style="margin-top:4rem">
      <?php foreach ([
        ['value' => count($tracks), 'label' => 'Engineering tracks'],
        ['value' => 'Remote',       'label' => 'Remote and hybrid'],
        ['value' => '1:1',          'label' => 'Mentor guidance'],
        ['value' => 'Certificate',  'label' => 'On completion'],
      ] as $fact): ?>
        <div class="s-fig">
          <b><?= Security::e((string) $fact['value']) ?></b>
          <span><?= Security::e($fact['label']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Tracks -->
<section class="s-sec" id="tracks">
  <div class="s-shell">
    <div class="s-grid" style="margin-bottom:2.5rem">
      <div style="grid-column:span 5">
        <span class="s-eyebrow">Choose your track</span>
        <h2 class="s-h2">Available internships</h2>
      </div>
      <p class="s-lede" style="grid-column:7 / span 6;align-self:end;margin:0">
        Every track runs on real deliverables with code review. Pick the one closest to the work you want to do.
      </p>
    </div>

    <?php if (!empty($tracks)): ?>
      <ol class="s-list">
        <?php $n = 0; foreach ($tracks as $t):
            $n++;
            $applied = in_array((int) $t['id'], $appliedIds, true);
            $skills  = array_filter(array_map('trim', explode(',', (string) $t['skills'])));
        ?>
          <li>
            <span class="s-num"><?= str_pad((string) $n, 2, '0', STR_PAD_LEFT) ?></span>
            <div>
              <h3 class="s-h3">
                <a href="<?= url('internships/track?slug=' . urlencode((string) $t['slug'])) ?>" style="text-decoration:none"><?= Security::e($t['title']) ?></a>
              </h3>
              <p class="s-small s-mute" style="margin-top:.4rem">
                <?= (int) $t['duration_weeks'] ?> weeks &middot; <?= Security::e($t['mode']) ?>
                &middot;
                <?php if ($applied): ?>
                  <span class="s-tag s-tag--signal">Applied</span>
                <?php else: ?>
                  <?= (int) $t['seats'] ?> seats
                <?php endif; ?>
              </p>
            </div>
            <div>
              <p><?= Security::e($t['short_desc']) ?></p>
              <?php if ($skills): ?>
                <div class="s-tags" style="margin-top:.9rem">
                  <?php foreach (array_slice($skills, 0, 4) as $skill): ?>
                    <span class="s-tag"><?= Security::e($skill) ?></span>
                  <?php endforeach; ?>
                  <?php if (count($skills) > 4): ?>
                    <span class="s-tag">+<?= count($skills) - 4 ?></span>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="s-actions s-small" style="margin-top:1rem;gap:1.25rem">
                <a href="<?= url('internships/track?slug=' . urlencode((string) $t['slug'])) ?>" class="s-link">View details</a>
                <?php if ($applied): ?>
                  <a href="<?= url('internships/dashboard') ?>" class="s-link">Track status</a>
                <?php else: ?>
                  <a href="<?= url('internships/apply?slug=' . urlencode((string) $t['slug'])) ?>" class="s-link">Apply</a>
                <?php endif; ?>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php else: ?>
      <div class="s-notice">No internship tracks are open at the moment. Please check back soon.</div>
    <?php endif; ?>
  </div>
</section>

<!-- How it works -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 4">
        <span class="s-eyebrow">Application process</span>
        <h2 class="s-h2">How it works</h2>
      </div>
      <div style="grid-column:span 8">
        <ol class="s-list">
          <?php foreach ([
            ['num' => '01', 'title' => 'Register',       'desc' => 'Create your account with your academic details. It takes under a minute.'],
            ['num' => '02', 'title' => 'Apply & upload', 'desc' => 'Pick a track, tell us why you fit, and attach your resume as a PDF or DOC.'],
            ['num' => '03', 'title' => 'Review',         'desc' => 'Our engineering team reviews your profile and updates your status.'],
            ['num' => '04', 'title' => 'Offer letter',   'desc' => 'On approval your formal offer letter is generated for you to download.'],
          ] as $step): ?>
            <li>
              <span class="s-num"><?= $step['num'] ?></span>
              <h3 class="s-h3"><?= Security::e($step['title']) ?></h3>
              <p><?= Security::e($step['desc']) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <h2 class="s-h2">
          <?= isIntern() ? 'Ready for your next application?' : 'Ready to start your internship?' ?>
        </h2>
        <p class="s-lede" style="margin-top:1rem">
          <?= isIntern()
              ? 'You can apply to more than one track. Each application is reviewed on its own merit.'
              : 'Create your account once, then apply to any track that fits your goals.' ?>
        </p>
      </div>
      <div style="grid-column:9 / span 4;align-self:end">
        <a href="<?= isIntern() ? url('internships') . '#tracks' : url('internships/register') ?>" class="s-btn--light">
          <?= isIntern() ? 'Browse tracks' : 'Create your account' ?>
        </a>
        <p class="s-small s-mute" style="margin-top:1rem">
          Questions? Email <a href="mailto:<?= Security::e(COMPANY_EMAIL) ?>" class="s-link"><?= Security::e(COMPANY_EMAIL) ?></a>
        </p>
      </div>
    </div>
  </div>
</section>

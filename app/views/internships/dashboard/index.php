<!-- ── INTERN DASHBOARD ─────────────────────────────────────── -->

<section class="s-sec s-sec--tight">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 8">
        <span class="s-eyebrow">My dashboard</span>
        <h1 class="s-h1">Hello, <span class="s-it"><?= Security::e(internName()) ?></span></h1>
        <p class="s-lede" style="margin-top:1rem">
          <?php if ($summary['total'] === 0): ?>
            You have not applied for a track yet.
          <?php else: ?>
            You have <?= (int) $summary['total'] ?> application<?= $summary['total'] === 1 ? '' : 's' ?> on file.
          <?php endif; ?>
        </p>
      </div>
      <div style="grid-column:span 4;align-self:end">
        <div class="s-actions lg:justify-end">
          <a href="<?= url('internships') ?>" class="s-btn">New application</a>
          <a href="<?= url('internships/logout') ?>" class="s-btn--line">Sign out</a>
        </div>
      </div>
    </div>

    <div class="s-figs" style="margin-top:2.5rem">
      <?php foreach ([
        ['label' => 'Total applications', 'value' => $summary['total']],
        ['label' => 'In progress',        'value' => $summary['active']],
        ['label' => 'Approved',           'value' => $summary['approved']],
        ['label' => 'Closed',             'value' => $summary['closed']],
      ] as $card): ?>
        <div class="s-fig">
          <b><?= (int) $card['value'] ?></b>
          <span><?= Security::e($card['label']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" style="gap:3rem 1.5rem">

      <!-- Applications -->
      <div style="grid-column:span 8">
        <h2 class="s-h2" style="margin-bottom:1.5rem">My applications</h2>

        <?php if (empty($applications)): ?>
          <div class="s-panel s-panel--deep">
            <h3 class="s-h3" style="margin-bottom:.5rem">No applications yet</h3>
            <p class="s-mute" style="margin:0 0 1.25rem;max-width:48ch">
              Browse the eleven internship tracks and submit your first application. You can apply to more than one.
            </p>
            <a href="<?= url('internships') ?>" class="s-btn s-btn--sm">Browse internships</a>
          </div>
        <?php else: ?>
          <div class="s-table-wrap">
            <table class="s-table">
              <thead>
                <tr>
                  <th scope="col">Track</th>
                  <th scope="col">Reference</th>
                  <th scope="col">Applied</th>
                  <th scope="col">Status</th>
                  <th scope="col">Documents</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($applications as $a): ?>
                  <tr>
                    <td>
                      <a href="<?= url('internships/dashboard/application?id=' . (int) $a['id']) ?>" class="s-link"><?= Security::e($a['track_title']) ?></a>
                      <div class="s-num" style="margin-top:.2rem"><?= (int) $a['duration_weeks'] ?> weeks</div>
                    </td>
                    <td class="s-num" style="white-space:nowrap"><?= Security::e($a['ref_no']) ?></td>
                    <td class="s-num" style="white-space:nowrap"><?= formatDate((string) $a['created_at']) ?></td>
                    <td><?php $__st = (string) $a['status']; ?><span class="s-tag<?= $__st === 'approved' ? ' s-tag--solid' : ($__st === 'shortlisted' ? ' s-tag--signal' : '') ?>"<?= in_array($__st, ['rejected', 'withdrawn'], true) ? ' style="color:var(--ink-3)"' : '' ?>><?= Security::e(statusLabel($__st)) ?></span></td>
                    <td class="s-small" style="white-space:nowrap">
                      <a href="<?= url('internships/dashboard/application?id=' . (int) $a['id']) ?>" class="s-link">Details</a>
                      <span class="s-mute">&middot;</span>
                      <a href="<?= url('internships/dashboard/resume?id=' . (int) $a['id']) ?>" class="s-link">Resume</a>
                      <?php if ($a['status'] === 'approved'): ?>
                        <span class="s-mute">&middot;</span>
                        <a href="<?= url('internships/dashboard/offer-letter?id=' . (int) $a['id']) ?>" class="s-link">Offer letter (PDF)</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php if ($a['status'] === 'approved'): ?>
                    <tr>
                      <td colspan="5" class="s-small" style="color:var(--signal)">
                        Congratulations &mdash; this application has been approved. Your offer letter is ready to download.
                      </td>
                    </tr>
                  <?php endif; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <!-- Profile -->
      <aside style="grid-column:span 4">
        <h2 class="s-h3" style="margin-bottom:1rem">My profile</h2>
        <dl class="s-kv">
          <?php
          $fields = [
            'Name'       => $profile['name'] ?? '',
            'Email'      => $profile['email'] ?? '',
            'Phone'      => $profile['phone'] ?? '',
            'College'    => $profile['college'] ?? '',
            'Course'     => $profile['course'] ?? '',
            'Graduation' => $profile['graduation_year'] ?? '',
          ];
          foreach ($fields as $label => $value):
              if ((string) $value === '') { continue; }
          ?>
            <div>
              <dt><?= Security::e($label) ?></dt>
              <dd class="break-words"><?= Security::e((string) $value) ?></dd>
            </div>
          <?php endforeach; ?>

          <?php if (!empty($profile['created_at'])): ?>
            <div>
              <dt>Member since</dt>
              <dd><?= formatDate((string) $profile['created_at'], 'd M Y') ?></dd>
            </div>
          <?php endif; ?>
        </dl>

        <h3 class="s-h3" style="font-size:1.1rem;margin:2.5rem 0 1rem">What the statuses mean</h3>
        <dl class="s-kv">
          <?php foreach ([
            'pending'      => 'Received and queued for review.',
            'under_review' => 'Our team is actively assessing it.',
            'shortlisted'  => 'You are through to the next stage.',
            'approved'     => 'Selected — offer letter available.',
            'rejected'     => 'Not taken forward this time.',
          ] as $key => $meaning): ?>
            <div>
              <dt><?= Security::e(statusLabel($key)) ?></dt>
              <dd class="s-small"><?= Security::e($meaning) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
      </aside>
    </div>
  </div>
</section>

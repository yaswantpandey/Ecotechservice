<?php
// ------------------------------------------------------------
// Hack2Skill × Sudarshan — event page
// All facts come from EventController::hack2skillXSudarshan().
// ------------------------------------------------------------
$startLabel = date('j M Y', strtotime($event['starts']));
$endLabel   = date('j M Y', strtotime($event['ends']));
$dateRange  = date('j', strtotime($event['starts'])) . ' – ' . $endLabel;
?>

<!-- HERO -->
<section class="s-sec">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb">
      <a href="<?= url('') ?>">Home</a><span>/</span>
      <a href="<?= url('events') ?>">Events</a><span>/</span>
      <span aria-current="page"><?= Security::e($event['name']) ?></span>
    </nav>

    <div class="s-grid mt-8">
      <div style="grid-column:span 8">
        <p class="s-eyebrow">Hackathon &middot; <?= Security::e($dateRange) ?></p>
        <h1 class="s-h1 mt-4"><?= Security::e($event['name']) ?></h1>
        <p class="s-lede mt-6"><?= Security::e($event['tagline']) ?></p>

        <div class="s-actions mt-8">
          <a href="<?= Security::e($event['register_url']) ?>" class="s-btn" target="_blank" rel="noopener">Register on <?= Security::e($event['partner']) ?></a>
          <a href="#tracks" class="s-btn--line">See the tracks</a>
        </div>
        <p class="s-mono s-mute mt-4"><?= Security::e($event['registration_note']) ?></p>
      </div>

      <aside style="grid-column:span 4">
        <p class="s-eyebrow">Event details</p>
        <dl class="s-kv mt-3">
          <div><dt>Dates</dt><dd><?= Security::e($startLabel) ?> &ndash; <?= Security::e($endLabel) ?></dd></div>
          <div><dt>Format</dt><dd><?= Security::e($event['mode']) ?></dd></div>
          <div><dt>Venue</dt><dd><?= Security::e($event['venue']) ?></dd></div>
          <div><dt>Team size</dt><dd><?= Security::e($event['team_size']) ?></dd></div>
          <div><dt>Entry</dt><dd><?= Security::e($event['fee']) ?></dd></div>
        </dl>
      </aside>
    </div>

    <div class="s-figs mt-14 lg:grid-cols-4" data-reveal>
      <div class="s-fig"><b>36</b><span>Hours in the build window, start to code freeze</span></div>
      <div class="s-fig"><b><?= str_pad((string) count($tracks), 2, '0', STR_PAD_LEFT) ?></b><span>Tracks — enter one, judged on fit to it</span></div>
      <div class="s-fig"><b>05</b><span>Judging criteria, weighted and published below</span></div>
      <div class="s-fig"><b><?= Security::e($event['fee']) ?></b><span>For every team selected to the finale</span></div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">What it is</p>
        <h2 class="s-h2 mt-4">Built for problems that survive contact with a factory.</h2>
      </div>
      <div style="grid-column:span 7" data-reveal>
        <div class="s-prose">
          <p><?= Security::e($event['tagline']) ?> <?= Security::e($event['summary']) ?></p>
        </div>
        <dl class="s-kv mt-8">
          <div><dt>Hosted by</dt><dd><?= Security::e($event['host']) ?></dd></div>
          <div><dt>Platform partner</dt><dd><?= Security::e($event['partner']) ?></dd></div>
          <div><dt>Mentoring</dt><dd><?= Security::e($event['mentor_note']) ?></dd></div>
          <div><dt>Who can enter</dt><dd><?= Security::e($event['eligibility']) ?></dd></div>
        </dl>
      </div>
    </div>
  </div>
</section>

<!-- TRACKS -->
<section class="s-sec" id="tracks">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Tracks</p>
        <h2 class="s-h2 mt-4">Pick one problem. Go deep on it.</h2>
        <p class="s-mute mt-5" style="font-size:.9375rem;line-height:1.65">Teams enter a single track. A narrow, finished build scores higher than four half-built ideas, and judges score fit to the track you chose.</p>
      </div>
      <div style="grid-column:span 7" data-reveal>
        <ol class="s-list">
          <?php foreach ($tracks as $ti => $track): ?>
          <li>
            <span class="s-num"><?= str_pad((string) ($ti + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="s-h3"><?= Security::e($track['name']) ?></h3>
            <p><?= Security::e($track['brief']) ?></p>
          </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- TIMELINE -->
<section class="s-sec" id="timeline">
  <div class="s-shell">
    <div class="s-grid" style="align-items:end">
      <div style="grid-column:span 6">
        <p class="s-eyebrow">Schedule</p>
        <h2 class="s-h2 mt-4">From registration to pitch.</h2>
      </div>
      <div style="grid-column:span 6">
        <p class="s-mono s-mute">All times IST</p>
      </div>
    </div>

    <div class="mt-10" data-reveal>
      <ol class="s-list">
        <?php foreach ($timeline as $ti => $step): ?>
        <li>
          <span class="s-num"><?= Security::e(date('d M', strtotime($step['date']))) ?></span>
          <h3 class="s-h3"><?= Security::e($step['label']) ?></h3>
          <p><?= Security::e($step['detail']) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- PRIZES -->
<section class="s-sec" id="prizes">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Prizes</p>
        <h2 class="s-h2 mt-4">What the top teams take home.</h2>
        <p class="s-mute mt-5" style="font-size:.9375rem;line-height:1.65">Cash prizes are paid to the team, not split per member. Track awards are judged separately from the overall podium, so a focused single-track build can win twice.</p>
      </div>
      <div style="grid-column:span 7" data-reveal>
        <div class="s-table-wrap">
          <table class="s-table" style="min-width:520px">
            <thead>
              <tr>
                <th style="width:30%">Award</th>
                <th style="width:20%">Prize</th>
                <th>Includes</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rewards as $reward): ?>
              <tr>
                <td><?= Security::e($reward['place']) ?></td>
                <td><span class="s-mono"><?= Security::e($reward['value']) ?></span></td>
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

<!-- JUDGING -->
<section class="s-sec" id="judging">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Judging</p>
        <h2 class="s-h2 mt-4">How a build gets scored.</h2>
        <p class="s-mute mt-5" style="font-size:.9375rem;line-height:1.65">Two judges score every team independently, then reconcile within five points. Working software carries the largest single weight.</p>
      </div>
      <div style="grid-column:span 7" data-reveal>
        <div class="s-table-wrap">
          <table class="s-table" style="min-width:520px">
            <thead>
              <tr>
                <th style="width:26%">Criterion</th>
                <th style="width:14%">Weight</th>
                <th>What judges look for</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($judging as $criterion): ?>
              <tr>
                <td><?= Security::e($criterion[0]) ?></td>
                <td><span class="s-mono"><?= Security::e($criterion[1]) ?></span></td>
                <td><?= Security::e($criterion[2]) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="s-small s-mute mt-4">Final scores are published to participating teams on request after the results are announced.</p>
      </div>
    </div>
  </div>
</section>

<!-- RULES -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid" data-reveal>
      <div style="grid-column:span 6">
        <p class="s-eyebrow">Before you register</p>
        <h2 class="s-h2 mt-4">Two rules that decide most disputes.</h2>
      </div>
      <div style="grid-column:span 6">
        <ol class="s-list">
          <li><span class="s-num">01</span><h3 class="s-h3">The code is written on site</h3><p>You may arrive with a design, a data set and libraries you already use. Committing a pre-built application does not qualify — the build window is when the product gets written.</p></li>
          <li><span class="s-num">02</span><h3 class="s-h3">Every team presents</h3><p>Pitching is not optional and cannot be delegated to one absent member. Five minutes per team, then questions from the panel.</p></li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="s-sec">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 5">
        <p class="s-eyebrow">Questions</p>
        <h2 class="s-h2 mt-4">Answers, before you commit a weekend.</h2>
        <p class="s-mute mt-5" style="font-size:.9375rem;line-height:1.65">Anything not covered here goes to the organiser inbox, or to us directly if it is about mentoring and the technical side.</p>
        <div class="s-actions mt-6">
          <a href="mailto:<?= Security::e($event['email']) ?>" class="s-btn--line s-btn--sm">Email the team</a>
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

<!-- CTA -->
<section class="s-sec s-band">
  <div class="s-shell">
    <div class="s-grid">
      <div style="grid-column:span 7">
        <p class="s-eyebrow">Still deciding</p>
        <h2 class="s-h2 mt-4">Bring the idea. We will help with the architecture.</h2>
      </div>
      <div style="grid-column:span 5">
        <p>If you are building for the hackathon and want a second pair of eyes on scope, data model or deployment, ask before the build window opens.</p>
        <div class="s-actions mt-6">
          <a href="<?= url('contact') ?>" class="s-btn--light">Talk to us</a>
          <a href="<?= Security::e($event['register_url']) ?>" class="s-btn--line" style="color:var(--band-fg);border-color:var(--band-fg)" target="_blank" rel="noopener">Register</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Event structured data -->
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'Event',
    'name'     => $event['name'],
    'description' => $event['tagline'],
    'startDate' => $event['starts'],
    'endDate'   => $event['ends'],
    'eventStatus' => 'https://schema.org/EventScheduled',
    'eventAttendanceMode' => 'https://schema.org/MixedEventAttendanceMode',
    'url'      => url('events/' . $event['slug']),
    'image'    => url('assets/img/logo.png'),
    'location' => [
        '@type'   => 'Place',
        'name'    => $event['venue'],
        'address' => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Pune',
            'addressRegion'   => 'Maharashtra',
            'addressCountry'  => 'IN',
        ],
    ],
    'organizer' => [
        [
            '@type' => 'Organization',
            'name'  => $event['host'],
        ],
        [
            '@type' => 'Organization',
            'name'  => $event['partner'],
            'url'   => 'https://hack2skill.com',
        ],
    ],
    'offers' => [
        '@type'         => 'Offer',
        'price'         => 0,
        'priceCurrency' => 'INR',
        'availability'  => 'https://schema.org/InStock',
        'url'           => $event['register_url'],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

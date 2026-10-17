<!-- ── ADMIN DASHBOARD ────────────────────────────────────── -->
<div class="space-y-6">

  <!-- Key figures -->
  <div class="a-stats">
    <?php foreach ([
      ['label' => 'Applications',       'value' => $internship['applications'], 'href' => 'admin/applications'],
      ['label' => 'Awaiting review',    'value' => $internship['pending'],      'href' => 'admin/applications?status=pending'],
      ['label' => 'Registered interns', 'value' => $internship['interns'],      'href' => 'admin/interns'],
      ['label' => 'Unread messages',    'value' => $stats['unread'],            'href' => 'admin/contacts'],
    ] as $card): ?>
      <div class="a-stat">
        <a href="<?= url($card['href']) ?>">
          <b><?= (int) $card['value'] ?></b>
          <span><?= Security::e($card['label']) ?></span>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Secondary figures -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="a-card">
      <div class="a-card-head">
        <h2>Internship portal</h2>
        <a href="<?= url('admin/applications') ?>" class="s-link">Manage applications</a>
      </div>
      <div class="a-card-pad">
        <dl class="s-kv">
          <div><dt>Approved</dt><dd><a class="s-link" href="<?= url('admin/applications?status=approved') ?>"><?= (int) $internship['approved'] ?></a></dd></div>
          <div><dt>Active tracks</dt><dd><a class="s-link" href="<?= url('admin/tracks') ?>"><?= (int) $internship['tracks'] ?></a></dd></div>
        </dl>
      </div>
    </div>

    <div class="a-card">
      <div class="a-card-head">
        <h2>Site content</h2>
      </div>
      <div class="a-card-pad">
        <dl class="s-kv">
          <div><dt>Projects</dt><dd><?= (int) $stats['projects'] ?></dd></div>
          <div><dt>Services</dt><dd><?= (int) $stats['services'] ?></dd></div>
          <div><dt>Blog posts</dt><dd><?= (int) $stats['blog_posts'] ?></dd></div>
          <div><dt>Total messages</dt><dd><?= (int) $stats['contacts'] ?></dd></div>
        </dl>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <?php if ($internship['applications'] > 0): ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="a-card">
        <div class="a-card-head"><h2>By status</h2><span class="s-mute text-xs">All applications</span></div>
        <div class="a-card-pad"><div class="h-64"><canvas id="statusChart"></canvas></div></div>
      </div>

      <div class="a-card lg:col-span-2">
        <div class="a-card-head"><h2>Applications per track</h2></div>
        <div class="a-card-pad"><div class="h-64"><canvas id="trackChart"></canvas></div></div>
      </div>

      <div class="a-card lg:col-span-3">
        <div class="a-card-head"><h2>Last 14 days</h2><span class="s-mute text-xs">Daily application volume</span></div>
        <div class="a-card-pad"><div class="h-64"><canvas id="trendChart"></canvas></div></div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Recent activity -->
  <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <?php if (!empty($recentApplications)): ?>
      <div class="a-card">
        <div class="a-card-head">
          <h2>Recent applications</h2>
          <a href="<?= url('admin/applications') ?>" class="s-link">View all</a>
        </div>
        <div class="a-table-wrap">
          <table class="a-table">
            <thead><tr>
              <th>Reference</th>
              <th>Candidate</th>
              <th class="hidden md:table-cell">Track</th>
              <th>Status</th>
              <th class="hidden lg:table-cell">Applied</th>
              <th class="a-right"></th>
            </tr></thead>
            <tbody>
              <?php foreach ($recentApplications as $ra): ?>
                <tr>
                  <td class="s-num"><?= Security::e($ra['ref_no']) ?></td>
                  <td><?= Security::e($ra['intern_name']) ?></td>
                  <td class="s-mute hidden md:table-cell"><?= Security::e($ra['track_title']) ?></td>
                  <td><?= statusBadge((string) $ra['status']) ?></td>
                  <td class="s-num hidden lg:table-cell"><?= formatDate((string) $ra['created_at']) ?></td>
                  <td class="a-right">
                    <a href="<?= url('admin/applications/view?id=' . (int) $ra['id']) ?>" class="s-link">Review</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($recentContacts): ?>
      <div class="a-card">
        <div class="a-card-head">
          <h2>Recent messages</h2>
          <a href="<?= url('admin/contacts') ?>" class="s-link">View all</a>
        </div>
        <div class="a-table-wrap">
          <table class="a-table">
            <thead><tr>
              <th>Name</th>
              <th class="hidden md:table-cell">Subject</th>
              <th class="hidden lg:table-cell">Date</th>
              <th>Status</th>
              <th class="a-right"></th>
            </tr></thead>
            <tbody>
              <?php foreach ($recentContacts as $c): ?>
                <tr>
                  <td><?= Security::e($c['name']) ?></td>
                  <td class="s-mute hidden md:table-cell"><?= Security::e(truncate($c['subject'], 40)) ?></td>
                  <td class="s-num hidden lg:table-cell"><?= formatDate($c['created_at']) ?></td>
                  <td>
                    <span class="s-tag <?= $c['is_read'] ? 's-tag--mute' : 's-tag--signal' ?>"><?= $c['is_read'] ? 'Read' : 'New' ?></span>
                  </td>
                  <td class="a-right">
                    <a href="<?= url('admin/contacts/view?id=' . $c['id']) ?>" class="s-link">View</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Quick actions -->
  <div class="a-card">
    <div class="a-card-head"><h2>Quick actions</h2></div>
    <div class="a-card-pad flex flex-wrap gap-3">
      <?php foreach ([
        ['label' => 'Review Applications', 'icon' => 'fa-file-lines',  'href' => 'admin/applications'],
        ['label' => 'Manage Tracks',       'icon' => 'fa-layer-group', 'href' => 'admin/tracks'],
        ['label' => 'Add Project',         'icon' => 'fa-plus',        'href' => 'admin/projects/add'],
        ['label' => 'View Messages',       'icon' => 'fa-envelope',    'href' => 'admin/contacts'],
      ] as $qa): ?>
        <a href="<?= url($qa['href']) ?>" class="s-btn--line s-btn--sm">
          <i class="fas <?= $qa['icon'] ?>"></i><?= $qa['label'] ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php if ($internship['applications'] > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"
        integrity="sha256-0q+JdOlScWOHcunpUk21uab1jW7C1deBQARHtKMcaB4="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
(function () {
  if (typeof Chart === 'undefined') { return; }

  // Data is JSON-encoded server side; no user HTML reaches this scope.
  var statusData = <?= json_encode($charts['status'], JSON_THROW_ON_ERROR) ?>;
  var trackData  = <?= json_encode($charts['track'],  JSON_THROW_ON_ERROR) ?>;
  var trendData  = <?= json_encode($charts['trend'],  JSON_THROW_ON_ERROR) ?>;

  var INK = '#191A17', SIGNAL = '#2C5F42', RULE = '#C9C4B6', PAPER = '#ffffff';

  Chart.defaults.color       = INK;
  Chart.defaults.borderColor = RULE;
  Chart.defaults.font.family = "'IBM Plex Sans', system-ui, sans-serif";

  var grid = { color: RULE };

  // Status order: pending, review, shortlisted, approved, rejected, withdrawn.
  // Approved carries the signal colour; the rest step through ink / rule.
  var statusColors = [RULE, '#8F8B80', '#5A5B55', SIGNAL, INK, '#E4E0D5'];

  new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
      labels: statusData.labels,
      datasets: [{
        data: statusData.values,
        backgroundColor: statusColors,
        borderColor: PAPER,
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      cutout: '58%',
      plugins: {
        legend: { position: 'bottom', labels: { boxWidth: 10, padding: 12, font: { size: 11 } } }
      }
    }
  });

  new Chart(document.getElementById('trackChart'), {
    type: 'bar',
    data: {
      labels: trackData.labels,
      datasets: [{
        label: 'Applications',
        data: trackData.values,
        backgroundColor: SIGNAL,
        borderColor: SIGNAL,
        borderWidth: 1,
        borderRadius: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      indexAxis: 'y',
      plugins: { legend: { display: false } },
      scales: {
        x: { beginAtZero: true, ticks: { precision: 0 }, grid: grid },
        y: { grid: { display: false }, ticks: { font: { size: 10 } } }
      }
    }
  });

  new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
      labels: trendData.labels,
      datasets: [{
        label: 'Applications',
        data: trendData.values,
        borderColor: INK,
        backgroundColor: INK,
        borderWidth: 1.5,
        fill: false,
        tension: 0,
        pointRadius: 2,
        pointBackgroundColor: INK
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 }, grid: grid },
        x: { grid: { display: false } }
      }
    }
  });
})();
</script>
<?php endif; ?>

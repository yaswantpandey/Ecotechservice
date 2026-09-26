<!-- ── ADMIN DASHBOARD ────────────────────────────────────── -->
<div class="pt-6 space-y-8">

  <!-- Stats Grid -->
  <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    <?php
    $statCards = [
      ['label'=>'Total Projects',  'value'=>$stats['projects'],     'icon'=>'fa-briefcase',  'color'=>'eco'],
      ['label'=>'Services',        'value'=>$stats['services'],     'icon'=>'fa-cogs',       'color'=>'blue'],
      ['label'=>'Blog Posts',      'value'=>$stats['blog_posts'],   'icon'=>'fa-pen-nib',    'color'=>'indigo'],
      ['label'=>'Total Messages',  'value'=>$stats['contacts'],     'icon'=>'fa-envelope',   'color'=>'purple'],
      ['label'=>'Unread Messages', 'value'=>$stats['unread'],       'icon'=>'fa-bell',       'color'=>'red'],
    ];
    $colors = ['eco'=>'eco-500','blue'=>'blue-500','indigo'=>'indigo-500','yellow'=>'yellow-500','purple'=>'purple-500','red'=>'red-500'];
    foreach ($statCards as $sc):
      $c = $colors[$sc['color']];
    ?>
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
      <div class="flex items-center justify-between mb-3">
        <div class="text-gray-400 text-xs font-medium"><?= $sc['label'] ?></div>
        <div class="w-8 h-8 rounded-lg bg-<?= $c ?>/10 flex items-center justify-center">
          <i class="fas <?= $sc['icon'] ?> text-<?= $c ?> text-sm"></i>
        </div>
      </div>
      <div class="font-display font-bold text-3xl text-white"><?= $sc['value'] ?></div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Internship Portal -->
  <div>
    <div class="flex items-center justify-between mb-4">
      <h2 class="font-display font-semibold text-white text-lg">Internship Portal</h2>
      <a href="<?= url('admin/applications') ?>" class="text-eco-400 hover:text-eco-300 text-sm transition">
        Manage applications &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
      <?php foreach ([
        ['label' => 'Applications',  'value' => $internship['applications'], 'icon' => 'fa-file-lines',   'c' => 'eco-500',   'href' => 'admin/applications'],
        ['label' => 'Awaiting Review','value' => $internship['pending'],     'icon' => 'fa-hourglass-half','c' => 'yellow-500','href' => 'admin/applications?status=pending'],
        ['label' => 'Approved',      'value' => $internship['approved'],     'icon' => 'fa-circle-check', 'c' => 'eco-500',   'href' => 'admin/applications?status=approved'],
        ['label' => 'Registered Interns','value' => $internship['interns'],  'icon' => 'fa-users',        'c' => 'blue-500',  'href' => 'admin/interns'],
        ['label' => 'Active Tracks', 'value' => $internship['tracks'],       'icon' => 'fa-layer-group',  'c' => 'indigo-500','href' => 'admin/tracks'],
      ] as $card): ?>
        <a href="<?= url($card['href']) ?>"
           class="bg-gray-900 border border-gray-800 hover:border-eco-500/40 rounded-xl p-5 transition-colors">
          <div class="flex items-center justify-between mb-3">
            <div class="text-gray-400 text-xs font-medium"><?= $card['label'] ?></div>
            <div class="w-8 h-8 rounded-lg bg-<?= $card['c'] ?>/10 flex items-center justify-center">
              <i class="fas <?= $card['icon'] ?> text-<?= $card['c'] ?> text-sm"></i>
            </div>
          </div>
          <div class="font-display font-bold text-3xl text-white"><?= (int) $card['value'] ?></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Charts -->
  <?php if ($internship['applications'] > 0): ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
      <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
        <h3 class="text-white font-semibold text-sm mb-1">By Status</h3>
        <p class="text-gray-500 text-xs mb-4">Distribution of all applications</p>
        <div class="h-64"><canvas id="statusChart"></canvas></div>
      </div>

      <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 lg:col-span-2">
        <h3 class="text-white font-semibold text-sm mb-1">Applications per Track</h3>
        <p class="text-gray-500 text-xs mb-4">Which tracks are attracting interest</p>
        <div class="h-64"><canvas id="trackChart"></canvas></div>
      </div>

      <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 lg:col-span-3">
        <h3 class="text-white font-semibold text-sm mb-1">Last 14 Days</h3>
        <p class="text-gray-500 text-xs mb-4">Daily application volume</p>
        <div class="h-64"><canvas id="trendChart"></canvas></div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Recent Applications -->
  <?php if (!empty($recentApplications)): ?>
    <div>
      <div class="flex items-center justify-between mb-4">
        <h2 class="font-display font-semibold text-white text-lg">Recent Applications</h2>
        <a href="<?= url('admin/applications') ?>" class="text-eco-400 hover:text-eco-300 text-sm transition">View all &rarr;</a>
      </div>
      <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">
        <table class="w-full text-sm">
          <thead><tr class="border-b border-gray-800">
            <th class="text-left text-gray-400 font-medium px-5 py-3">Reference</th>
            <th class="text-left text-gray-400 font-medium px-5 py-3">Candidate</th>
            <th class="text-left text-gray-400 font-medium px-5 py-3 hidden md:table-cell">Track</th>
            <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
            <th class="text-left text-gray-400 font-medium px-5 py-3 hidden lg:table-cell">Applied</th>
            <th class="px-5 py-3"></th>
          </tr></thead>
          <tbody class="divide-y divide-gray-800">
            <?php foreach ($recentApplications as $ra): ?>
              <tr class="hover:bg-gray-800/50 transition">
                <td class="px-5 py-3 font-mono text-xs text-eco-400"><?= Security::e($ra['ref_no']) ?></td>
                <td class="px-5 py-3 text-white font-medium"><?= Security::e($ra['intern_name']) ?></td>
                <td class="px-5 py-3 text-gray-400 hidden md:table-cell"><?= Security::e($ra['track_title']) ?></td>
                <td class="px-5 py-3"><?= statusBadge((string) $ra['status']) ?></td>
                <td class="px-5 py-3 text-gray-500 hidden lg:table-cell"><?= formatDate((string) $ra['created_at']) ?></td>
                <td class="px-5 py-3">
                  <a href="<?= url('admin/applications/view?id=' . (int) $ra['id']) ?>"
                     class="text-eco-400 hover:text-eco-300 text-xs transition">Review</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>

  <!-- Quick Actions -->
  <div>
    <h2 class="font-display font-semibold text-white text-lg mb-4">Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <?php foreach ([
        ['label'=>'Review Applications','icon'=>'fa-file-lines',  'href'=>'admin/applications'],
        ['label'=>'Manage Tracks',      'icon'=>'fa-layer-group', 'href'=>'admin/tracks'],
        ['label'=>'Add Project',        'icon'=>'fa-plus-circle', 'href'=>'admin/projects/add'],
        ['label'=>'View Messages',      'icon'=>'fa-envelope',    'href'=>'admin/contacts'],
      ] as $qa): ?>
      <a href="<?= url($qa['href']) ?>"
         class="flex items-center space-x-3 bg-gray-900 border border-gray-800 hover:border-eco-500/50 rounded-xl px-4 py-4 transition-all duration-200 group">
        <div class="w-9 h-9 rounded-lg bg-eco-500/10 group-hover:bg-eco-500/20 flex items-center justify-center transition">
          <i class="fas <?= $qa['icon'] ?> text-eco-400 text-sm"></i>
        </div>
        <span class="text-gray-300 group-hover:text-white text-sm font-medium transition"><?= $qa['label'] ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Recent Contacts -->
  <?php if ($recentContacts): ?>
  <div>
    <div class="flex items-center justify-between mb-4">
      <h2 class="font-display font-semibold text-white text-lg">Recent Messages</h2>
      <a href="<?= url('admin/contacts') ?>" class="text-eco-400 hover:text-eco-300 text-sm transition">View all →</a>
    </div>
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
      <table class="w-full text-sm">
        <thead><tr class="border-b border-gray-800">
          <th class="text-left text-gray-400 font-medium px-5 py-3">Name</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3 hidden md:table-cell">Subject</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3 hidden lg:table-cell">Date</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
          <th class="px-5 py-3"></th>
        </tr></thead>
        <tbody class="divide-y divide-gray-800">
          <?php foreach ($recentContacts as $c): ?>
          <tr class="hover:bg-gray-800/50 transition">
            <td class="px-5 py-3 text-white font-medium"><?= Security::e($c['name']) ?></td>
            <td class="px-5 py-3 text-gray-400 hidden md:table-cell"><?= Security::e(truncate($c['subject'], 40)) ?></td>
            <td class="px-5 py-3 text-gray-500 hidden lg:table-cell"><?= formatDate($c['created_at']) ?></td>
            <td class="px-5 py-3">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                <?= $c['is_read'] ? 'bg-gray-700 text-gray-400' : 'bg-eco-500/20 text-eco-400' ?>">
                <?= $c['is_read'] ? 'Read' : 'New' ?>
              </span>
            </td>
            <td class="px-5 py-3">
              <a href="<?= url('admin/contacts/view?id=' . $c['id']) ?>" class="text-eco-400 hover:text-eco-300 text-xs transition">View</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
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

  // Match the panel palette rather than Chart.js defaults.
  Chart.defaults.color       = '#9ca3af';
  Chart.defaults.borderColor = 'rgba(255,255,255,0.06)';
  Chart.defaults.font.family = "Inter, system-ui, sans-serif";

  var grid = { color: 'rgba(255,255,255,0.06)' };

  // Fixed colours keyed to status order: pending, review, shortlisted,
  // approved, rejected, withdrawn.
  var statusColors = ['#6b7280', '#f59e0b', '#3b82f6', '#22c55e', '#ef4444', '#4b5563'];

  new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
      labels: statusData.labels,
      datasets: [{
        data: statusData.values,
        backgroundColor: statusColors,
        borderColor: '#111827',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
        backgroundColor: 'rgba(34,197,94,0.55)',
        borderColor: '#22c55e',
        borderWidth: 1,
        borderRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
        borderColor: '#22c55e',
        backgroundColor: 'rgba(34,197,94,0.12)',
        fill: true,
        tension: 0.3,
        pointRadius: 3,
        pointBackgroundColor: '#22c55e'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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

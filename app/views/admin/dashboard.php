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

  <!-- Quick Actions -->
  <div>
    <h2 class="font-display font-semibold text-white text-lg mb-4">Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <?php foreach ([
        ['label'=>'Add Project',     'icon'=>'fa-plus-circle', 'href'=>'admin/projects/add'],
        ['label'=>'Add Service',     'icon'=>'fa-cog',         'href'=>'admin/services/add'],
        ['label'=>'Write Blog Post', 'icon'=>'fa-pen-nib',     'href'=>'admin/blog/add'],
        ['label'=>'View Messages',   'icon'=>'fa-envelope',    'href'=>'admin/contacts'],
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

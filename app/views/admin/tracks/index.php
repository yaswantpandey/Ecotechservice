<?php // ── ADMIN — INTERNSHIP TRACKS ────────────────────────────── ?>

<div class="pt-6">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="font-display font-semibold text-white text-xl">Internship Tracks</h2>
      <p class="text-gray-500 text-xs mt-1"><?= count($tracks) ?> track<?= count($tracks) === 1 ? '' : 's' ?> configured</p>
    </div>
    <a href="<?= url('admin/tracks/add') ?>" class="btn-primary text-sm py-2">
      <i class="fas fa-plus mr-2"></i>Add Track
    </a>
  </div>

  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-800">
          <th class="text-left text-gray-400 font-medium px-5 py-3">#</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Track</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Duration</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Seats</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Applications</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
          <th class="text-right text-gray-400 font-medium px-5 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800">
        <?php if ($tracks): foreach ($tracks as $t): ?>
          <tr class="hover:bg-gray-800/50 transition">
            <td class="px-5 py-3.5 text-gray-500 text-xs"><?= (int) $t['sort_order'] ?></td>

            <td class="px-5 py-3.5">
              <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-eco-500/10 border border-eco-500/30 flex items-center justify-center text-eco-400 shrink-0">
                  <i class="fas <?= Security::e($t['icon']) ?> text-xs"></i>
                </span>
                <div class="min-w-0">
                  <div class="text-white font-medium"><?= Security::e($t['title']) ?></div>
                  <div class="text-gray-600 text-[11px] font-mono"><?= Security::e($t['slug']) ?></div>
                </div>
              </div>
            </td>

            <td class="px-5 py-3.5 text-gray-300 text-xs whitespace-nowrap"><?= (int) $t['duration_weeks'] ?> weeks</td>
            <td class="px-5 py-3.5 text-gray-300 text-xs"><?= (int) $t['seats'] ?></td>

            <td class="px-5 py-3.5">
              <?php if ((int) $t['application_count'] > 0): ?>
                <a href="<?= url('admin/applications?track=' . (int) $t['id']) ?>"
                   class="text-eco-400 hover:text-eco-300 text-xs transition">
                  <?= (int) $t['application_count'] ?> received
                </a>
              <?php else: ?>
                <span class="text-gray-600 text-xs">None</span>
              <?php endif; ?>
            </td>

            <td class="px-5 py-3.5">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                <?= (int) $t['is_active'] === 1 ? 'bg-eco-500/20 text-eco-400' : 'bg-gray-700 text-gray-400' ?>">
                <?= (int) $t['is_active'] === 1 ? 'Active' : 'Hidden' ?>
              </span>
            </td>

            <td class="px-5 py-3.5 text-right whitespace-nowrap">
              <a href="<?= url('internships/track?slug=' . urlencode((string) $t['slug'])) ?>"
                 target="_blank" rel="noopener"
                 class="text-gray-400 hover:text-white text-xs transition">
                <i class="fas fa-arrow-up-right-from-square mr-1"></i>View
              </a>
              <a href="<?= url('admin/tracks/edit?id=' . (int) $t['id']) ?>"
                 class="text-blue-400 hover:text-blue-300 text-xs transition ml-3">
                <i class="fas fa-edit mr-1"></i>Edit
              </a>

              <?php if ((int) $t['application_count'] === 0): ?>
                <form action="<?= url('admin/tracks/delete') ?>" method="POST" class="inline ml-3"
                      onsubmit="return confirm('Delete this track? This cannot be undone.');">
                  <?= Security::csrfField() ?>
                  <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">
                  <button type="submit" class="text-red-400 hover:text-red-300 text-xs transition">
                    <i class="fas fa-trash mr-1"></i>Delete
                  </button>
                </form>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; else: ?>
          <tr><td colspan="7" class="text-center py-10 text-gray-500">No tracks configured yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <p class="text-gray-600 text-xs mt-4">
    <i class="fas fa-circle-info mr-1"></i>
    A track with applications against it cannot be deleted. Set it to hidden instead to close it to new applicants.
  </p>
</div>

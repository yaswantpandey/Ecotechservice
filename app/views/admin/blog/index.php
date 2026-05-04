<!-- ── ADMIN BLOG POSTS LIST ──────────────────────────────── -->
<div class="pt-6 space-y-6">

  <!-- Header Row -->
  <div class="flex items-center justify-between">
    <div>
      <h2 class="font-display font-semibold text-white text-xl">Blog Posts</h2>
      <p class="text-gray-400 text-sm mt-1"><?= count($posts) ?> post<?= count($posts) !== 1 ? 's' : '' ?> total</p>
    </div>
    <a href="<?= url('admin/blog/add') ?>"
       class="inline-flex items-center gap-2 bg-eco-500 hover:bg-eco-400 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-all duration-200 shadow-lg shadow-eco-500/25">
      <i class="fas fa-plus"></i> New Post
    </a>
  </div>

  <!-- Posts Table -->
  <?php if (empty($posts)): ?>
  <div class="bg-gray-900 border border-gray-800 rounded-xl text-center py-20">
    <div class="text-5xl mb-4">✍️</div>
    <h3 class="text-white font-semibold text-lg mb-2">No blog posts yet</h3>
    <p class="text-gray-400 text-sm mb-6">Create your first post to get started.</p>
    <a href="<?= url('admin/blog/add') ?>" class="btn-primary inline-flex items-center gap-2">
      <i class="fas fa-plus"></i> Create First Post
    </a>
  </div>
  <?php else: ?>
  <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-800">
          <th class="text-left text-gray-400 font-medium px-5 py-3">Title</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3 hidden md:table-cell">Author</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3 hidden lg:table-cell">Date</th>
          <th class="text-left text-gray-400 font-medium px-5 py-3">Status</th>
          <th class="px-5 py-3 text-right text-gray-400 font-medium">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800">
        <?php foreach ($posts as $p): ?>
        <tr class="hover:bg-gray-800/50 transition group">
          <!-- Thumbnail + Title -->
          <td class="px-5 py-3">
            <div class="flex items-center gap-3">
              <?php if ($p['thumbnail']): ?>
              <img src="<?= uploadUrl($p['thumbnail']) ?>" alt=""
                   class="w-10 h-10 rounded-lg object-cover border border-gray-700 flex-shrink-0">
              <?php else: ?>
              <div class="w-10 h-10 rounded-lg bg-eco-500/10 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-newspaper text-eco-400 text-xs"></i>
              </div>
              <?php endif; ?>
              <div class="min-w-0">
                <p class="text-white font-medium truncate max-w-xs"><?= Security::e($p['title']) ?></p>
                <?php if ($p['excerpt']): ?>
                <p class="text-gray-500 text-xs truncate max-w-xs"><?= Security::e(truncate($p['excerpt'], 60)) ?></p>
                <?php endif; ?>
              </div>
            </div>
          </td>
          <td class="px-5 py-3 text-gray-400 hidden md:table-cell"><?= Security::e($p['author_name']) ?></td>
          <td class="px-5 py-3 text-gray-500 hidden lg:table-cell">
            <?= $p['published_at'] ? formatDate($p['published_at']) : formatDate($p['created_at']) ?>
          </td>
          <td class="px-5 py-3">
            <?php if ($p['is_published']): ?>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-eco-500/20 text-eco-400 border border-eco-500/30">
              <span class="w-1.5 h-1.5 rounded-full bg-eco-400 animate-pulse"></span> Published
            </span>
            <?php else: ?>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 text-gray-400">
              <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Draft
            </span>
            <?php endif; ?>
          </td>
          <td class="px-5 py-3">
            <div class="flex items-center justify-end gap-2">
              <?php if ($p['is_published']): ?>
              <a href="<?= url('blog/post?slug=' . urlencode($p['slug'])) ?>" target="_blank"
                 class="text-gray-500 hover:text-eco-400 transition text-xs" title="View Post">
                <i class="fas fa-external-link-alt"></i>
              </a>
              <?php endif; ?>
              <a href="<?= url('admin/blog/edit?id=' . $p['id']) ?>"
                 class="text-gray-400 hover:text-white transition text-xs px-2.5 py-1 rounded bg-gray-800 hover:bg-gray-700">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="<?= url('admin/blog/delete?id=' . $p['id']) ?>"
                 class="text-red-400 hover:text-red-300 transition text-xs px-2.5 py-1 rounded bg-red-500/10 hover:bg-red-500/20"
                 onclick="return confirm('Delete this post? This cannot be undone.')">
                <i class="fas fa-trash-alt"></i>
              </a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>

</div>

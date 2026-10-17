<!-- ── ADMIN BLOG POSTS LIST ──────────────────────────────── -->
<div class="a-card">
  <div class="a-card-head">
    <div>
      <h2>Blog posts</h2>
      <p class="s-num m-0"><?= count($posts) ?> post<?= count($posts) !== 1 ? 's' : '' ?> total</p>
    </div>
    <a href="<?= url('admin/blog/add') ?>" class="s-btn s-btn--sm">
      <i class="fas fa-plus text-xs" aria-hidden="true"></i> New post
    </a>
  </div>

  <?php if (empty($posts)): ?>
  <div class="a-empty">
    <p class="font-medium mb-1" style="color:var(--ink)">No blog posts yet</p>
    <p class="text-sm mb-5">Create your first post to get started.</p>
    <a href="<?= url('admin/blog/add') ?>" class="s-btn s-btn--sm">
      <i class="fas fa-plus text-xs" aria-hidden="true"></i> Create first post
    </a>
  </div>
  <?php else: ?>
  <div class="a-table-wrap">
    <table class="a-table">
      <thead>
        <tr>
          <th style="width:5rem">Image</th>
          <th>Title</th>
          <th class="hidden md:table-cell">Author</th>
          <th class="hidden lg:table-cell">Date</th>
          <th>Status</th>
          <th class="a-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($posts as $p): ?>
        <tr>
          <td>
            <?php if ($p['thumbnail']): ?>
            <img src="<?= uploadUrl($p['thumbnail']) ?>" alt="" class="a-thumb" loading="lazy">
            <?php else: ?>
            <span class="a-thumb flex items-center justify-center s-mute text-xs"><i class="fas fa-newspaper" aria-hidden="true"></i></span>
            <?php endif; ?>
          </td>
          <td>
            <div class="min-w-0">
              <p class="font-medium truncate max-w-xs m-0"><?= Security::e($p['title']) ?></p>
              <?php if ($p['excerpt']): ?>
              <p class="s-mute text-xs truncate max-w-xs m-0"><?= Security::e(truncate($p['excerpt'], 60)) ?></p>
              <?php endif; ?>
            </div>
          </td>
          <td class="hidden md:table-cell"><?= Security::e($p['author_name']) ?></td>
          <td class="s-num hidden lg:table-cell whitespace-nowrap">
            <?= $p['published_at'] ? formatDate($p['published_at']) : formatDate($p['created_at']) ?>
          </td>
          <td>
            <?php if ($p['is_published']): ?>
            <span class="s-tag s-tag--signal">Published</span>
            <?php else: ?>
            <span class="s-tag s-tag--mute">Draft</span>
            <?php endif; ?>
          </td>
          <td class="a-right">
            <div class="a-row-actions">
              <?php if ($p['is_published']): ?>
              <a href="<?= url('blog/post?slug=' . urlencode($p['slug'])) ?>" target="_blank"
                 class="a-icon-btn" title="View post" aria-label="View post on site">
                <i class="fas fa-external-link-alt" aria-hidden="true"></i>
              </a>
              <?php endif; ?>
              <a href="<?= url('admin/blog/edit?id=' . $p['id']) ?>"
                 class="a-icon-btn" title="Edit" aria-label="Edit post">
                <i class="fas fa-pen" aria-hidden="true"></i>
              </a>
              <a href="<?= url('admin/blog/delete?id=' . $p['id']) ?>"
                 class="a-icon-btn a-icon-btn--danger" title="Delete" aria-label="Delete post"
                 onclick="return confirm('Delete this post? This cannot be undone.')">
                <i class="fas fa-trash-alt" aria-hidden="true"></i>
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

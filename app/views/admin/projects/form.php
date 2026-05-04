<!-- ── ADMIN PROJECT FORM ─────────────────────────────────── -->
<div class="pt-6 max-w-3xl">
  <div class="flex items-center space-x-3 mb-6">
    <a href="<?= url('admin/projects') ?>" class="text-gray-400 hover:text-white text-sm transition"><i class="fas fa-arrow-left mr-1"></i>Back</a>
    <h2 class="font-display font-semibold text-white text-xl"><?= $project ? 'Edit Project' : 'Add New Project' ?></h2>
  </div>

  <form action="<?= url($project ? 'admin/projects/update' : 'admin/projects/store') ?>" method="POST" enctype="multipart/form-data"
        class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
    <?= Security::csrfField() ?>
    <?php if ($project): ?>
    <input type="hidden" name="id" value="<?= $project['id'] ?>">
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label class="form-label">Title *</label>
        <input type="text" name="title" required value="<?= Security::e($project['title'] ?? '') ?>" class="form-input" placeholder="Project Title">
      </div>
      <div>
        <label class="form-label">Category *</label>
        <select name="category" class="form-input">
          <?php foreach (['website','marketing','template','mobile','other'] as $cat): ?>
          <option value="<?= $cat ?>" <?= (($project['category'] ?? '') === $cat) ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div>
      <label class="form-label">Description *</label>
      <textarea name="description" required rows="4" class="form-input resize-none" placeholder="Describe the project..."><?= Security::e($project['description'] ?? '') ?></textarea>
    </div>
    <div>
      <label class="form-label">Tech Stack (comma-separated)</label>
      <input type="text" name="tech_stack" value="<?= Security::e($project['tech_stack'] ?? '') ?>" class="form-input" placeholder="PHP, MySQL, Tailwind CSS">
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <div>
        <label class="form-label">Live Demo URL</label>
        <input type="url" name="live_url" value="<?= Security::e($project['live_url'] ?? '') ?>" class="form-input" placeholder="https://example.com">
      </div>
      <div>
        <label class="form-label">GitHub URL</label>
        <input type="url" name="github_url" value="<?= Security::e($project['github_url'] ?? '') ?>" class="form-input" placeholder="https://github.com/...">
      </div>
    </div>
    <div>
      <label class="form-label">Thumbnail Image</label>
      <input type="file" name="thumbnail" accept="image/*" class="form-input py-2">
      <?php if (!empty($project['thumbnail'])): ?>
      <div class="mt-2 flex items-center space-x-2">
        <img src="<?= uploadUrl($project['thumbnail']) ?>" class="w-16 h-10 object-cover rounded border border-gray-700" alt="">
        <span class="text-gray-500 text-xs">Current thumbnail</span>
      </div>
      <?php endif; ?>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
      <div>
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" value="<?= (int)($project['sort_order'] ?? 0) ?>" class="form-input" min="0">
      </div>
      <div class="flex items-center space-x-3 pt-6">
        <input type="checkbox" name="is_featured" id="is_featured" class="w-4 h-4 accent-green-500" <?= ($project['is_featured'] ?? 0) ? 'checked' : '' ?>>
        <label for="is_featured" class="text-gray-300 text-sm">Featured Project</label>
      </div>
      <div class="flex items-center space-x-3 pt-6">
        <input type="checkbox" name="is_active" id="is_active" class="w-4 h-4 accent-green-500" <?= ($project['is_active'] ?? 1) ? 'checked' : '' ?>>
        <label for="is_active" class="text-gray-300 text-sm">Active (Visible)</label>
      </div>
    </div>
    <div class="flex gap-3 pt-2">
      <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i><?= $project ? 'Update Project' : 'Add Project' ?></button>
      <a href="<?= url('admin/projects') ?>" class="btn-outline">Cancel</a>
    </div>
  </form>
</div>

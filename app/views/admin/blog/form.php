<!-- ── ADMIN BLOG POST FORM ────────────────────────────────── -->
<div class="pt-6 max-w-4xl">

  <!-- Header -->
  <div class="flex items-center space-x-3 mb-6">
    <a href="<?= url('admin/blog') ?>" class="text-gray-400 hover:text-white text-sm transition">
      <i class="fas fa-arrow-left mr-1"></i>Back to Posts
    </a>
    <span class="text-gray-700">/</span>
    <h2 class="font-display font-semibold text-white text-xl">
      <?= $post ? 'Edit Post' : 'New Blog Post' ?>
    </h2>
  </div>

  <!-- TinyMCE CDN (Rich Text Editor) -->
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#body',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      skin: 'oxide-dark',
      content_css: 'dark',
      height: 420,
      promotion: false,
      branding: false,
      setup: function(editor) {
        editor.on('change', function() { editor.save(); });
      }
    });
  </script>

  <form action="<?= url($post ? 'admin/blog/update' : 'admin/blog/store') ?>"
        method="POST" enctype="multipart/form-data"
        class="space-y-6">
    <?= Security::csrfField() ?>
    <?php if ($post): ?>
    <input type="hidden" name="id" value="<?= $post['id'] ?>">
    <?php endif; ?>

    <!-- Title + Publish Status Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <div class="md:col-span-2 bg-gray-900 border border-gray-800 rounded-xl p-5">
        <label class="form-label">Post Title *</label>
        <input type="text" name="title" id="post-title" required
               value="<?= Security::e($post['title'] ?? '') ?>"
               class="form-input text-lg" placeholder="Write a compelling title…">
      </div>

      <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 space-y-4">
        <div>
          <label class="form-label">Publish Status</label>
          <label class="flex items-center gap-3 cursor-pointer mt-2">
            <div class="relative">
              <input type="checkbox" name="is_published" id="is_published" class="sr-only peer"
                     <?= ($post['is_published'] ?? 0) ? 'checked' : '' ?>>
              <div class="w-10 h-6 bg-gray-700 peer-checked:bg-eco-500 rounded-full transition-colors duration-200"></div>
              <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform duration-200 peer-checked:translate-x-4"></div>
            </div>
            <span class="text-gray-300 text-sm font-medium" id="publish-label">
              <?= ($post['is_published'] ?? 0) ? 'Published' : 'Draft' ?>
            </span>
          </label>
        </div>

        <div id="published-at-wrapper">
          <label class="form-label">Publish Date</label>
          <input type="datetime-local" name="published_at" class="form-input text-sm"
                 value="<?= $post['published_at'] ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : date('Y-m-d\TH:i') ?>">
        </div>
      </div>
    </div>

    <!-- Excerpt -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
      <label class="form-label">Excerpt <span class="text-gray-500 font-normal">(short summary shown on blog listing)</span></label>
      <textarea name="excerpt" rows="2" class="form-input resize-none"
                placeholder="Brief one-or-two sentence summary of this post…"><?= Security::e($post['excerpt'] ?? '') ?></textarea>
    </div>

    <!-- Body (Rich Text Editor) -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
      <label class="form-label mb-3 block">Content *</label>
      <textarea name="body" id="body" required
                class="w-full bg-gray-800 border border-gray-700 rounded-lg text-gray-200 text-sm p-3 min-h-[300px]"><?= htmlspecialchars($post['body'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>

    <!-- Thumbnail -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
      <label class="form-label">Featured Image</label>

      <?php if (!empty($post['thumbnail'])): ?>
      <div class="mb-4 flex items-center gap-3">
        <img src="<?= uploadUrl($post['thumbnail']) ?>"
             class="w-24 h-16 object-cover rounded-lg border border-gray-700" alt="Current thumbnail">
        <span class="text-gray-500 text-xs">Current thumbnail — upload a new one to replace it</span>
      </div>
      <?php endif; ?>

      <!-- Drop zone -->
      <label for="thumbnail"
             class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-700 hover:border-eco-500/60 rounded-xl cursor-pointer transition-colors duration-200 group bg-gray-800/40 hover:bg-eco-500/5">
        <i class="fas fa-cloud-upload-alt text-3xl text-gray-600 group-hover:text-eco-400 mb-2 transition-colors"></i>
        <span class="text-gray-400 text-sm group-hover:text-gray-300 transition-colors">Click or drag image here</span>
        <span class="text-gray-600 text-xs mt-1">JPEG · PNG · WebP — max 5 MB</span>
        <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="hidden" onchange="previewThumb(this)">
      </label>
      <img id="thumbPreview" src="" alt="" class="hidden mt-3 h-32 object-cover rounded-lg border border-gray-700">
    </div>

    <!-- SEO Settings -->
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 space-y-5">
      <h3 class="text-white font-semibold mb-2">SEO Settings</h3>
      
      <div>
        <label class="form-label">Meta Title <span class="text-gray-500 font-normal">(Leave blank to use post title)</span></label>
        <input type="text" name="meta_title" value="<?= Security::e($post['meta_title'] ?? '') ?>"
               class="form-input text-sm" placeholder="Custom SEO Title">
      </div>

      <div>
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" rows="2" class="form-input resize-none text-sm"
                  placeholder="Meta description for search engines…"><?= Security::e($post['meta_description'] ?? '') ?></textarea>
      </div>

      <div>
        <label class="form-label">Meta Keywords</label>
        <input type="text" name="meta_keywords" value="<?= Security::e($post['meta_keywords'] ?? '') ?>"
               class="form-input text-sm" placeholder="keyword1, keyword2, keyword3">
      </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-3 pb-8">
      <button type="submit" class="btn-primary inline-flex items-center gap-2">
        <i class="fas fa-save"></i>
        <?= $post ? 'Update Post' : 'Publish Post' ?>
      </button>
      <a href="<?= url('admin/blog') ?>" class="btn-outline">Cancel</a>
    </div>
  </form>
</div>

<script>
  // Toggle publish-date visibility
  const toggle = document.getElementById('is_published');
  const label  = document.getElementById('publish-label');
  toggle?.addEventListener('change', () => {
    label.textContent = toggle.checked ? 'Published' : 'Draft';
  });

  // Thumbnail preview
  function previewThumb(input) {
    const preview = document.getElementById('thumbPreview');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

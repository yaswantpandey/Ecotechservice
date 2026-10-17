<!-- ── ADMIN BLOG POST FORM ────────────────────────────────── -->
<div>

  <!-- Header -->
  <div class="mb-5">
    <a href="<?= url('admin/blog') ?>" class="s-link text-sm">
      <i class="fas fa-arrow-left text-xs" aria-hidden="true"></i> Back to posts
    </a>
    <h2 class="s-h3 mt-2 mb-0">
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
      skin: 'oxide',
      content_css: 'default',
      height: 420,
      promotion: false,
      branding: false,
      setup: function(editor) {
        editor.on('change', function() { editor.save(); });
      }
    });
  </script>

  <form action="<?= url($post ? 'admin/blog/update' : 'admin/blog/store') ?>"
        method="POST" enctype="multipart/form-data">
    <?= Security::csrfField() ?>
    <?php if ($post): ?>
    <input type="hidden" name="id" value="<?= $post['id'] ?>">
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

      <!-- ── Main fields ─────────────────────────────────────── -->
      <div class="lg:col-span-8 a-card a-card-pad">
        <div class="a-form-grid">
          <div class="s-field a-span-2">
            <label for="post-title" class="s-label">Post title <span class="s-req">*</span></label>
            <input type="text" name="title" id="post-title" required
                   value="<?= Security::e($post['title'] ?? '') ?>"
                   class="s-input" placeholder="Write a compelling title…">
          </div>

          <div class="s-field a-span-2">
            <label for="excerpt" class="s-label">Excerpt <span class="s-mute">(short summary shown on blog listing)</span></label>
            <textarea id="excerpt" name="excerpt" rows="2" class="s-textarea"
                      placeholder="Brief one-or-two sentence summary of this post…"><?= Security::e($post['excerpt'] ?? '') ?></textarea>
          </div>

          <div class="s-field a-span-2">
            <label for="body" class="s-label">Content <span class="s-req">*</span></label>
            <textarea name="body" id="body" required
                      class="s-textarea" style="min-height:300px"><?= htmlspecialchars($post['body'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
          </div>
        </div>

        <p class="s-eyebrow mb-4">SEO settings</p>
        <div class="a-form-grid">
          <div class="s-field a-span-2">
            <label for="meta_title" class="s-label">Meta title <span class="s-mute">(leave blank to use post title)</span></label>
            <input type="text" id="meta_title" name="meta_title" value="<?= Security::e($post['meta_title'] ?? '') ?>"
                   class="s-input" placeholder="Custom SEO Title">
          </div>

          <div class="s-field a-span-2">
            <label for="meta_description" class="s-label">Meta description</label>
            <textarea id="meta_description" name="meta_description" rows="2" class="s-textarea"
                      placeholder="Meta description for search engines…"><?= Security::e($post['meta_description'] ?? '') ?></textarea>
          </div>

          <div class="s-field a-span-2">
            <label for="meta_keywords" class="s-label">Meta keywords</label>
            <input type="text" id="meta_keywords" name="meta_keywords" value="<?= Security::e($post['meta_keywords'] ?? '') ?>"
                   class="s-input" placeholder="keyword1, keyword2, keyword3">
          </div>
        </div>

        <div class="a-form-actions">
          <button type="submit" class="s-btn s-btn--sm">
            <i class="fas fa-save text-xs" aria-hidden="true"></i>
            <?= $post ? 'Update Post' : 'Publish Post' ?>
          </button>
          <a href="<?= url('admin/blog') ?>" class="s-btn--line s-btn--sm">Cancel</a>
        </div>
      </div>

      <!-- ── Side column ─────────────────────────────────────── -->
      <div class="lg:col-span-4 space-y-5">
        <div class="a-card">
          <div class="a-card-head"><h2>Publish settings</h2></div>
          <div class="a-card-pad">
            <div class="s-field">
              <span class="s-label">Publish status</span>
              <label class="s-check" for="is_published">
                <input type="checkbox" name="is_published" id="is_published"
                       <?= ($post['is_published'] ?? 0) ? 'checked' : '' ?>>
                <span class="font-medium" id="publish-label">
                  <?= ($post['is_published'] ?? 0) ? 'Published' : 'Draft' ?>
                </span>
              </label>
            </div>

            <div id="published-at-wrapper" class="s-field" style="margin-bottom:0">
              <label for="published_at" class="s-label">Publish date</label>
              <input type="datetime-local" id="published_at" name="published_at" class="s-input"
                     value="<?= !empty($post['published_at']) ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : date('Y-m-d\TH:i') ?>">
            </div>
          </div>
        </div>

        <div class="a-card">
          <div class="a-card-head"><h2>Featured image</h2></div>
          <div class="a-card-pad">
            <?php if (!empty($post['thumbnail'])): ?>
            <div class="mb-4">
              <img src="<?= uploadUrl($post['thumbnail']) ?>"
                   class="a-preview" style="margin-top:0" alt="Current thumbnail">
              <p class="s-help">Current thumbnail — upload a new one to replace it</p>
            </div>
            <?php endif; ?>

            <label for="thumbnail" class="s-label">Upload image</label>
            <input id="thumbnail" type="file" name="thumbnail" accept="image/*" class="text-sm block w-full" onchange="previewThumb(this)"><img id="thumbPreview" src="" alt="" class="a-preview hidden">
            <p class="s-help">JPEG · PNG · WebP — max 5 MB</p>
          </div>
        </div>
      </div>
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

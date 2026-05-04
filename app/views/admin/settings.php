<!-- ── ADMIN SETTINGS ─────────────────────────────────────── -->
<div class="pt-6 max-w-3xl">
  <h2 class="font-display font-semibold text-white text-xl mb-6">Site Settings</h2>
  <form action="<?= url('admin/settings/update') ?>" method="POST"
        class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
    <?= Security::csrfField() ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
      <?php foreach ([
        ['key'=>'site_name',     'label'=>'Site Name',     'type'=>'text'],
        ['key'=>'site_tagline',  'label'=>'Tagline',       'type'=>'text'],
        ['key'=>'site_email',    'label'=>'Email Address', 'type'=>'email'],
        ['key'=>'site_phone',    'label'=>'Phone Number',  'type'=>'text'],
        ['key'=>'whatsapp_number','label'=>'WhatsApp Number (digits only)','type'=>'text'],
        ['key'=>'google_analytics_id','label'=>'Google Analytics ID','type'=>'text'],
      ] as $f): ?>
      <div>
        <label class="form-label"><?= $f['label'] ?></label>
        <input type="<?= $f['type'] ?>" name="<?= $f['key'] ?>"
               value="<?= Security::e($settings[$f['key']] ?? '') ?>"
               class="form-input">
      </div>
      <?php endforeach; ?>
    </div>

    <div>
      <label class="form-label">Address</label>
      <input type="text" name="site_address" value="<?= Security::e($settings['site_address'] ?? '') ?>" class="form-input">
    </div>
    <div>
      <label class="form-label">Meta Description</label>
      <textarea name="meta_description" rows="3" class="form-input resize-none"><?= Security::e($settings['meta_description'] ?? '') ?></textarea>
    </div>

    <div class="border-t border-gray-800 pt-5">
      <h3 class="text-white font-semibold mb-4 text-sm">Social Media Links</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <?php foreach (['facebook_url'=>'Facebook','twitter_url'=>'Twitter / X','linkedin_url'=>'LinkedIn','instagram_url'=>'Instagram'] as $key=>$label): ?>
        <div>
          <label class="form-label"><?= $label ?></label>
          <input type="url" name="<?= $key ?>" value="<?= Security::e($settings[$key] ?? '') ?>" class="form-input" placeholder="https://...">
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Save Settings</button>
  </form>
</div>

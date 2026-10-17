<!-- ── ADMIN SETTINGS ─────────────────────────────────────── -->
<div class="max-w-4xl">
  <form action="<?= url('admin/settings/update') ?>" method="POST" class="a-card">
    <?= Security::csrfField() ?>

    <div class="a-card-head"><h2>Site settings</h2></div>
    <div class="a-card-pad">
      <div class="a-form-grid">
        <?php foreach ([
          ['key'=>'site_name',     'label'=>'Site Name',     'type'=>'text'],
          ['key'=>'site_tagline',  'label'=>'Tagline',       'type'=>'text'],
          ['key'=>'site_email',    'label'=>'Email Address', 'type'=>'email'],
          ['key'=>'site_phone',    'label'=>'Phone Number',  'type'=>'text'],
          ['key'=>'whatsapp_number','label'=>'WhatsApp Number (digits only)','type'=>'text'],
          ['key'=>'google_analytics_id','label'=>'Google Analytics ID','type'=>'text'],
        ] as $f): ?>
        <div class="s-field">
          <label class="s-label" for="set_<?= $f['key'] ?>"><?= $f['label'] ?></label>
          <input type="<?= $f['type'] ?>" name="<?= $f['key'] ?>" id="set_<?= $f['key'] ?>"
                 value="<?= Security::e($settings[$f['key']] ?? '') ?>"
                 class="s-input">
        </div>
        <?php endforeach; ?>

        <div class="s-field a-span-2">
          <label class="s-label" for="set_site_address">Address</label>
          <input type="text" name="site_address" id="set_site_address" value="<?= Security::e($settings['site_address'] ?? '') ?>" class="s-input">
        </div>
        <div class="s-field a-span-2">
          <label class="s-label" for="set_meta_description">Meta Description</label>
          <textarea name="meta_description" id="set_meta_description" rows="3" class="s-textarea"><?= Security::e($settings['meta_description'] ?? '') ?></textarea>
        </div>
      </div>
    </div>

    <div class="a-card-head"><h2>Social media links</h2></div>
    <div class="a-card-pad">
      <div class="a-form-grid">
        <?php foreach (['facebook_url'=>'Facebook','twitter_url'=>'Twitter / X','linkedin_url'=>'LinkedIn','instagram_url'=>'Instagram'] as $key=>$label): ?>
        <div class="s-field">
          <label class="s-label" for="set_<?= $key ?>"><?= $label ?></label>
          <input type="url" name="<?= $key ?>" id="set_<?= $key ?>" value="<?= Security::e($settings[$key] ?? '') ?>" class="s-input" placeholder="https://...">
        </div>
        <?php endforeach; ?>
      </div>

      <div class="a-form-actions">
        <button type="submit" class="s-btn s-btn--sm"><i class="fas fa-save"></i>Save Settings</button>
      </div>
    </div>
  </form>
</div>

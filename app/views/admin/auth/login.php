<!-- ── ADMIN LOGIN ────────────────────────────────────────── -->
<div class="a-auth">
  <div class="a-auth-box">
    <p class="s-eyebrow">Ecotech Service &middot; Restricted area</p>
    <h1 class="s-h2 mt-2 mb-6">Admin sign in</h1>

    <?php if (hasFlash('error')): ?>
      <div class="a-flash a-flash--error" role="alert">
        <i class="fas fa-exclamation-circle mt-0.5"></i>
        <span><?= Security::e(getFlash('error')) ?></span>
      </div>
    <?php endif; ?>

    <form action="<?= url('admin/login/post') ?>" method="POST" class="a-card a-card-pad">
      <?= Security::csrfField() ?>
      <div class="s-field">
        <label class="s-label" for="email">Email address</label>
        <input type="email" name="email" id="email" required placeholder="admin@ecotech.com" class="s-input" autocomplete="username">
      </div>
      <div class="s-field">
        <label class="s-label" for="password">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" required placeholder="••••••••"
            class="s-input pr-10" autocomplete="current-password">
          <button type="button" onclick="togglePwd()" aria-label="Show or hide password"
            class="absolute inset-y-0 right-0 px-3 flex items-center s-mute">
            <i class="fas fa-eye text-sm" id="pwdIcon"></i>
          </button>
        </div>
      </div>
      <button type="submit" class="s-btn s-btn--block">Sign in</button>
    </form>

    <p class="mt-6 text-sm">
      <a href="<?= url() ?>" class="s-link"><i class="fas fa-arrow-left mr-1"></i>Back to website</a>
    </p>
  </div>
</div>
<script>
  function togglePwd() {
    const p = document.getElementById('password');
    const i = document.getElementById('pwdIcon');
    if (p.type === 'password') { p.type = 'text'; i.classList.replace('fa-eye', 'fa-eye-slash'); }
    else { p.type = 'password'; i.classList.replace('fa-eye-slash', 'fa-eye'); }
  }
</script>

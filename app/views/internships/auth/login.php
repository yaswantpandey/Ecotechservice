<!-- ── INTERN SIGN IN ───────────────────────────────────────── -->

<section class="s-sec">
  <div class="s-shell">
    <div style="max-width:460px;margin:0 auto">
      <span class="s-eyebrow">Internship portal</span>
      <h1 class="s-h1">Welcome back</h1>
      <p class="s-mute" style="margin:1rem 0 2.25rem">
        Sign in to apply for a track or check the status of an existing application.
      </p>

      <?php if (hasFlash('error')): ?>
        <div class="s-notice s-notice--error" role="alert" style="margin-bottom:1.5rem">
          <?= Security::e(getFlash('error')) ?>
        </div>
      <?php endif; ?>

      <form action="<?= url('internships/login/post') ?>" method="POST" novalidate>
        <?= Security::csrfField() ?>

        <div class="s-field">
          <label for="email" class="s-label">Email address</label>
          <input type="email" id="email" name="email" required
                 value="<?= Security::e($old['email'] ?? '') ?>"
                 class="s-input" placeholder="you@example.com" autocomplete="email">
        </div>

        <div class="s-field">
          <label for="password" class="s-label">Password</label>
          <div class="s-pw">
            <input type="password" id="password" name="password" required
                   class="s-input" placeholder="Your password" autocomplete="current-password">
            <button type="button" id="togglePw" aria-label="Show password">
              <i class="fas fa-eye" aria-hidden="true"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="s-btn s-btn--block">Sign in</button>

        <p class="s-small" style="margin:1.5rem 0 0;padding-top:1.25rem;border-top:1px solid var(--rule);color:var(--ink-2)">
          New here?
          <a href="<?= url('internships/register') ?>" class="s-link">Create an account</a>
        </p>
      </form>

      <p class="s-small s-mute" style="margin-top:1.5rem">
        Trouble signing in? Email
        <a href="mailto:<?= Security::e(COMPANY_EMAIL) ?>" class="s-link"><?= Security::e(COMPANY_EMAIL) ?></a>
      </p>
    </div>
  </div>
</section>

<script>
(function () {
  var btn = document.getElementById('togglePw');
  var pw  = document.getElementById('password');
  if (!btn || !pw) { return; }
  btn.addEventListener('click', function () {
    var show = pw.type === 'password';
    pw.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
  });
})();
</script>

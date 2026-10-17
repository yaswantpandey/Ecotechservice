<!-- ── INTERN REGISTRATION ──────────────────────────────────── -->

<section class="s-sec">
  <div class="s-shell">
    <div style="max-width:460px;margin:0 auto">
      <span class="s-eyebrow">Internship portal</span>
      <h1 class="s-h1">Create your account</h1>
      <p class="s-mute" style="margin:1rem 0 2.25rem">
        One account lets you apply to any of our internship tracks and follow every application in one place.
      </p>

      <?php if (hasFlash('error')): ?>
        <div class="s-notice s-notice--error" role="alert" style="margin-bottom:1.5rem">
          <?= Security::e(getFlash('error')) ?>
        </div>
      <?php endif; ?>

      <form action="<?= url('internships/register/post') ?>" method="POST" novalidate>
        <?= Security::csrfField() ?>

        <div class="s-field">
          <label for="name" class="s-label">Full name <span class="s-req">*</span></label>
          <input type="text" id="name" name="name" required maxlength="120"
                 value="<?= Security::e($old['name'] ?? '') ?>"
                 class="s-input" placeholder="Your full name" autocomplete="name">
        </div>

        <div class="s-field">
          <label for="email" class="s-label">Email address <span class="s-req">*</span></label>
          <input type="email" id="email" name="email" required maxlength="190"
                 value="<?= Security::e($old['email'] ?? '') ?>"
                 class="s-input" placeholder="you@example.com" autocomplete="email">
        </div>

        <div class="s-field">
          <label for="phone" class="s-label">Phone <span class="s-mute">(optional)</span></label>
          <input type="tel" id="phone" name="phone" maxlength="20"
                 value="<?= Security::e($old['phone'] ?? '') ?>"
                 class="s-input" placeholder="+91 00000 00000" autocomplete="tel">
        </div>

        <div class="s-field">
          <label for="college" class="s-label">College / university <span class="s-mute">(optional)</span></label>
          <input type="text" id="college" name="college" maxlength="190"
                 value="<?= Security::e($old['college'] ?? '') ?>"
                 class="s-input" placeholder="Institution name">
        </div>

        <div class="s-field">
          <label for="course" class="s-label">Course <span class="s-mute">(optional)</span></label>
          <input type="text" id="course" name="course" maxlength="120"
                 value="<?= Security::e($old['course'] ?? '') ?>"
                 class="s-input" placeholder="B.Tech CSE, BCA, MCA...">
        </div>

        <div class="s-field">
          <label for="graduation_year" class="s-label">Graduation year <span class="s-mute">(optional)</span></label>
          <input type="number" id="graduation_year" name="graduation_year" min="1980" max="2040"
                 value="<?= Security::e($old['gradYear'] ?? '') ?>"
                 class="s-input" placeholder="<?= date('Y') ?>">
        </div>

        <div class="s-field">
          <label for="password" class="s-label">Password <span class="s-req">*</span></label>
          <div class="s-pw">
            <input type="password" id="password" name="password" required minlength="8"
                   class="s-input" placeholder="At least 8 characters" autocomplete="new-password">
            <button type="button" data-toggle="password" aria-label="Show password">
              <i class="fas fa-eye" aria-hidden="true"></i>
            </button>
          </div>
        </div>

        <div class="s-field">
          <label for="password_confirm" class="s-label">Confirm password <span class="s-req">*</span></label>
          <div class="s-pw">
            <input type="password" id="password_confirm" name="password_confirm" required minlength="8"
                   class="s-input" placeholder="Re-enter your password" autocomplete="new-password">
            <button type="button" data-toggle="password_confirm" aria-label="Show password">
              <i class="fas fa-eye" aria-hidden="true"></i>
            </button>
          </div>
          <p class="s-help">Your password must be at least 8 characters and include a letter and a number.</p>
        </div>

        <button type="submit" class="s-btn s-btn--block">Create account</button>

        <p class="s-small" style="margin:1.5rem 0 0;padding-top:1.25rem;border-top:1px solid var(--rule);color:var(--ink-2)">
          Already have an account?
          <a href="<?= url('internships/login') ?>" class="s-link">Sign in</a>
        </p>
      </form>
    </div>
  </div>
</section>

<script>
// Password visibility toggles.
document.querySelectorAll('[data-toggle]').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var field = document.getElementById(btn.getAttribute('data-toggle'));
    if (!field) { return; }
    var show = field.type === 'password';
    field.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
  });
});
</script>

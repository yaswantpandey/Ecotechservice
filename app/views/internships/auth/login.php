<!-- ── INTERN SIGN IN ───────────────────────────────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-12 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-3">
    <div class="inline-flex items-center space-x-2 bg-slate-900/90 border border-eco-500/30 px-4 py-1.5 rounded-md text-eco-300 text-xs font-semibold badge-glow">
      <span class="material-icons text-sm text-eco-400">login</span>
      <span>Internship Portal</span>
    </div>
    <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
      Welcome <span class="text-gradient">Back</span>
    </h1>
    <p class="text-slate-400 text-sm">
      Sign in to apply for a track or check the status of an existing application.
    </p>
  </div>
</div>

<section class="section-padding">
  <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">

    <?php if (hasFlash('error')): ?>
      <div class="flex items-start gap-3 bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        <i class="fas fa-circle-exclamation mt-0.5"></i>
        <span><?= Security::e(getFlash('error')) ?></span>
      </div>
    <?php endif; ?>

    <form action="<?= url('internships/login/post') ?>" method="POST" novalidate
          class="glass-card p-7 border-slate-800 space-y-5">
      <?= Security::csrfField() ?>

      <div>
        <label for="email" class="form-label">Email Address</label>
        <div class="relative">
          <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
          <input type="email" id="email" name="email" required
                 value="<?= Security::e($old['email'] ?? '') ?>"
                 class="form-input pl-10" placeholder="you@example.com" autocomplete="email">
        </div>
      </div>

      <div>
        <label for="password" class="form-label">Password</label>
        <div class="relative">
          <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
          <input type="password" id="password" name="password" required
                 class="form-input pl-10 pr-10" placeholder="Your password" autocomplete="current-password">
          <button type="button" id="togglePw"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300"
                  aria-label="Show password">
            <i class="fas fa-eye text-xs"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-primary w-full justify-center py-3">
        <i class="fas fa-right-to-bracket mr-2"></i>Sign In
      </button>

      <p class="text-center text-slate-400 text-sm pt-2 border-t border-slate-800">
        New here?
        <a href="<?= url('internships/register') ?>" class="text-eco-400 hover:underline font-semibold">Create an account</a>
      </p>
    </form>

    <p class="text-center text-slate-500 text-xs mt-6">
      Trouble signing in? Email
      <a href="mailto:<?= Security::e(COMPANY_EMAIL) ?>" class="text-eco-400 hover:underline"><?= Security::e(COMPANY_EMAIL) ?></a>
    </p>
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
    btn.querySelector('i').className = show ? 'fas fa-eye-slash text-xs' : 'fas fa-eye text-xs';
    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
  });
})();
</script>

<!-- ── INTERN REGISTRATION ──────────────────────────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-12 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-3">
    <div class="inline-flex items-center space-x-2 bg-slate-900/90 border border-eco-500/30 px-4 py-1.5 rounded-md text-eco-300 text-xs font-semibold badge-glow">
      <span class="material-icons text-sm text-eco-400">person_add</span>
      <span>Internship Portal</span>
    </div>
    <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
      Create Your <span class="text-gradient">Account</span>
    </h1>
    <p class="text-slate-400 text-sm max-w-md mx-auto">
      One account lets you apply to any of our internship tracks and follow every application in one place.
    </p>
  </div>
</div>

<section class="section-padding">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

    <?php if (hasFlash('error')): ?>
      <div class="flex items-start gap-3 bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        <i class="fas fa-circle-exclamation mt-0.5"></i>
        <span><?= Security::e(getFlash('error')) ?></span>
      </div>
    <?php endif; ?>

    <form action="<?= url('internships/register/post') ?>" method="POST" novalidate
          class="glass-card p-7 border-slate-800 space-y-6">
      <?= Security::csrfField() ?>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="sm:col-span-2">
          <label for="name" class="form-label">Full Name <span class="text-eco-400">*</span></label>
          <input type="text" id="name" name="name" required maxlength="120"
                 value="<?= Security::e($old['name'] ?? '') ?>"
                 class="form-input" placeholder="Your full name" autocomplete="name">
        </div>

        <div>
          <label for="email" class="form-label">Email Address <span class="text-eco-400">*</span></label>
          <input type="email" id="email" name="email" required maxlength="190"
                 value="<?= Security::e($old['email'] ?? '') ?>"
                 class="form-input" placeholder="you@example.com" autocomplete="email">
        </div>

        <div>
          <label for="phone" class="form-label">Phone <span class="text-slate-500">(optional)</span></label>
          <input type="tel" id="phone" name="phone" maxlength="20"
                 value="<?= Security::e($old['phone'] ?? '') ?>"
                 class="form-input" placeholder="+91 00000 00000" autocomplete="tel">
        </div>

        <div>
          <label for="college" class="form-label">College / University <span class="text-slate-500">(optional)</span></label>
          <input type="text" id="college" name="college" maxlength="190"
                 value="<?= Security::e($old['college'] ?? '') ?>"
                 class="form-input" placeholder="Institution name">
        </div>

        <div>
          <label for="course" class="form-label">Course <span class="text-slate-500">(optional)</span></label>
          <input type="text" id="course" name="course" maxlength="120"
                 value="<?= Security::e($old['course'] ?? '') ?>"
                 class="form-input" placeholder="B.Tech CSE, BCA, MCA...">
        </div>

        <div>
          <label for="graduation_year" class="form-label">Graduation Year <span class="text-slate-500">(optional)</span></label>
          <input type="number" id="graduation_year" name="graduation_year" min="1980" max="2040"
                 value="<?= Security::e($old['gradYear'] ?? '') ?>"
                 class="form-input" placeholder="<?= date('Y') ?>">
        </div>

        <div>
          <label for="password" class="form-label">Password <span class="text-eco-400">*</span></label>
          <div class="relative">
            <input type="password" id="password" name="password" required minlength="8"
                   class="form-input pr-10" placeholder="At least 8 characters" autocomplete="new-password">
            <button type="button" data-toggle="password"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300"
                    aria-label="Show password">
              <i class="fas fa-eye text-xs"></i>
            </button>
          </div>
        </div>

        <div>
          <label for="password_confirm" class="form-label">Confirm Password <span class="text-eco-400">*</span></label>
          <div class="relative">
            <input type="password" id="password_confirm" name="password_confirm" required minlength="8"
                   class="form-input pr-10" placeholder="Re-enter your password" autocomplete="new-password">
            <button type="button" data-toggle="password_confirm"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300"
                    aria-label="Show password">
              <i class="fas fa-eye text-xs"></i>
            </button>
          </div>
        </div>
      </div>

      <p class="text-slate-500 text-xs">
        Your password must be at least 8 characters and include a letter and a number.
      </p>

      <button type="submit" class="btn-primary w-full justify-center py-3">
        <i class="fas fa-user-plus mr-2"></i>Create Account
      </button>

      <p class="text-center text-slate-400 text-sm pt-2 border-t border-slate-800">
        Already have an account?
        <a href="<?= url('internships/login') ?>" class="text-eco-400 hover:underline font-semibold">Sign in</a>
      </p>
    </form>
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
    btn.querySelector('i').className = show ? 'fas fa-eye-slash text-xs' : 'fas fa-eye text-xs';
    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
  });
});
</script>

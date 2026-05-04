<!-- ── ADMIN LOGIN ────────────────────────────────────────── -->
<div class="min-h-screen flex items-center justify-center px-4">
  <!-- Background orbs -->
  <div class="absolute top-1/4 left-1/3 w-80 h-80 bg-eco-500/10 rounded-full blur-[100px]"></div>
  <div class="absolute bottom-1/4 right-1/3 w-64 h-64 bg-eco-700/10 rounded-full blur-[80px]"></div>

  <div class="relative w-full max-w-md">
    <!-- Card -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 shadow-2xl">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-eco-400 to-eco-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-eco-500/30">
          <i class="fas fa-leaf text-white text-2xl"></i>
        </div>
        <h1 class="font-display font-bold text-2xl text-white">Admin Login</h1>
        <p class="text-gray-500 text-sm mt-1">Ecotech Service — Restricted Area</p>
      </div>

      <!-- Flash -->
      <?php if (hasFlash('error')): ?>
      <div class="flex items-center space-x-2 bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= Security::e(getFlash('error')) ?></span>
      </div>
      <?php endif; ?>

      <!-- Form -->
      <form action="<?= url('admin/login/post') ?>" method="POST" class="space-y-5">
        <?= Security::csrfField() ?>
        <div>
          <label class="form-label">Email Address</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-envelope text-gray-500 text-sm"></i>
            </div>
            <input type="email" name="email" required placeholder="admin@ecotech.com"
                   class="form-input pl-10">
          </div>
        </div>
        <div>
          <label class="form-label">Password</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-lock text-gray-500 text-sm"></i>
            </div>
            <input type="password" name="password" id="password" required placeholder="••••••••"
                   class="form-input pl-10 pr-10">
            <button type="button" onclick="togglePwd()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300">
              <i class="fas fa-eye text-sm" id="pwdIcon"></i>
            </button>
          </div>
        </div>
        <button type="submit" class="btn-primary w-full justify-center">
          <i class="fas fa-sign-in-alt mr-2"></i>Sign In
        </button>
      </form>

      <div class="mt-6 text-center">
        <a href="<?= url() ?>" class="text-gray-500 hover:text-gray-300 text-xs transition">
          <i class="fas fa-arrow-left mr-1"></i>Back to Website
        </a>
      </div>
    </div>
  </div>
</div>
<script>
function togglePwd() {
  const p = document.getElementById('password');
  const i = document.getElementById('pwdIcon');
  if (p.type === 'password') { p.type = 'text'; i.classList.replace('fa-eye','fa-eye-slash'); }
  else { p.type = 'password'; i.classList.replace('fa-eye-slash','fa-eye'); }
}
</script>

<!-- ── INTERNSHIP APPLICATION FORM ──────────────────────────── -->

<div class="relative overflow-hidden hero-mesh-bg pt-28 pb-12 border-b border-slate-800/80">
  <div class="absolute inset-0 hero-grid opacity-15 pointer-events-none"></div>
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <nav class="text-xs text-slate-500 mb-5" aria-label="Breadcrumb">
      <a href="<?= url('internships') ?>" class="hover:text-eco-400 transition">Internships</a>
      <span class="mx-2">/</span>
      <a href="<?= url('internships/track?slug=' . urlencode((string) $track['slug'])) ?>" class="hover:text-eco-400 transition">
        <?= Security::e($track['title']) ?>
      </a>
      <span class="mx-2">/</span>
      <span class="text-slate-300">Apply</span>
    </nav>

    <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
      Apply — <span class="text-gradient"><?= Security::e($track['title']) ?></span>
    </h1>
    <p class="text-slate-400 text-sm mt-3">
      <?= (int) $track['duration_weeks'] ?> weeks &middot; <?= Security::e($track['mode']) ?>
      &middot; <?= Security::e($track['stipend_text']) ?>
    </p>
  </div>
</div>

<section class="section-padding">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    <?php if (hasFlash('error')): ?>
      <div class="flex items-start gap-3 bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
        <i class="fas fa-circle-exclamation mt-0.5"></i>
        <span><?= Security::e(getFlash('error')) ?></span>
      </div>
    <?php endif; ?>

    <form action="<?= url('internships/apply/store') ?>"
          method="POST"
          enctype="multipart/form-data"
          novalidate
          class="glass-card p-7 border-slate-800 space-y-7">

      <?= Security::csrfField() ?>
      <input type="hidden" name="track_id" value="<?= (int) $track['id'] ?>">

      <!-- Applicant summary (read-only, from the account) -->
      <div class="bg-slate-900/60 border border-slate-800 rounded-xl p-5">
        <div class="flex items-center justify-between mb-3">
          <h2 class="text-white font-semibold text-sm">Applying as</h2>
          <span class="text-[11px] text-slate-500">From your account</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
          <div>
            <div class="text-slate-500 text-xs">Name</div>
            <div class="text-slate-200 font-medium mt-0.5"><?= Security::e(internName()) ?></div>
          </div>
          <div>
            <div class="text-slate-500 text-xs">Email</div>
            <div class="text-slate-200 font-medium mt-0.5 break-all">
              <?= Security::e((string) ($_SESSION['intern_email'] ?? '')) ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Cover note -->
      <div>
        <label for="cover_note" class="form-label">
          Why are you a good fit for this track? <span class="text-eco-400">*</span>
        </label>
        <textarea id="cover_note"
                  name="cover_note"
                  rows="7"
                  required
                  minlength="40"
                  maxlength="4000"
                  class="form-input resize-y"
                  placeholder="Tell us what you have built or studied that relates to this track, the tools you are comfortable with, and what you want to get out of the internship."><?= Security::e($old['cover_note'] ?? '') ?></textarea>
        <p class="text-slate-500 text-xs mt-2">
          Minimum 40 characters. Specific examples of your own work count for far more than generic enthusiasm.
        </p>
      </div>

      <!-- Portfolio -->
      <div>
        <label for="portfolio_url" class="form-label">Portfolio, GitHub or LinkedIn <span class="text-slate-500">(optional)</span></label>
        <input type="url"
               id="portfolio_url"
               name="portfolio_url"
               value="<?= Security::e($old['portfolio_url'] ?? '') ?>"
               maxlength="255"
               class="form-input"
               placeholder="https://github.com/your-username">
      </div>

      <!-- Resume -->
      <div>
        <label for="resume" class="form-label">Resume <span class="text-eco-400">*</span></label>

        <label for="resume"
               class="block border border-dashed border-slate-700 hover:border-eco-500/50 rounded-xl p-6 text-center cursor-pointer transition-colors bg-slate-900/40">
          <i class="fas fa-file-arrow-up text-2xl text-eco-400 mb-3 block"></i>
          <span id="resumeLabel" class="text-slate-200 text-sm font-medium block">Choose your resume file</span>
          <span class="text-slate-500 text-xs mt-1.5 block">
            PDF, DOC or DOCX &middot; up to <?= Security::e($maxResume) ?>
          </span>
        </label>

        <input type="file"
               id="resume"
               name="resume"
               required
               accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
               class="sr-only">

        <p class="text-slate-500 text-xs mt-2">
          Your resume is stored privately and is only visible to you and our hiring team.
        </p>
      </div>

      <!-- Declaration -->
      <div class="flex items-start gap-3">
        <input type="checkbox"
               id="agree"
               name="agree"
               value="1"
               required
               class="mt-1 w-4 h-4 rounded border-slate-600 bg-slate-900 text-eco-500 focus:ring-eco-500/40">
        <label for="agree" class="text-slate-300 text-sm leading-relaxed">
          I confirm the information provided is accurate, and I agree to the
          <a href="<?= url('terms') ?>" class="text-eco-400 hover:underline">terms</a> and
          <a href="<?= url('privacy') ?>" class="text-eco-400 hover:underline">privacy policy</a>.
          <span class="text-eco-400">*</span>
        </label>
      </div>

      <div class="flex flex-col sm:flex-row gap-3 pt-2 border-t border-slate-800">
        <button type="submit" class="btn-primary py-3 px-7 justify-center">
          <i class="fas fa-paper-plane mr-2"></i>Submit Application
        </button>
        <a href="<?= url('internships/track?slug=' . urlencode((string) $track['slug'])) ?>"
           class="btn-outline py-3 px-6 justify-center">Cancel</a>
      </div>
    </form>
  </div>
</section>

<script>
// Reflect the chosen filename, and reject oversized files before the upload
// starts so the user is not left waiting for a server-side rejection.
(function () {
  var input = document.getElementById('resume');
  var label = document.getElementById('resumeLabel');
  var max   = <?= (int) Security::maxResumeBytes() ?>;
  if (!input || !label) { return; }

  input.addEventListener('change', function () {
    var file = input.files && input.files[0];
    if (!file) {
      label.textContent = 'Choose your resume file';
      return;
    }
    if (file.size > max) {
      label.textContent = 'That file is too large. Please choose a smaller one.';
      input.value = '';
      return;
    }
    label.textContent = file.name;
  });
})();
</script>

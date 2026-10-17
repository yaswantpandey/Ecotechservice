<!-- ── INTERNSHIP APPLICATION FORM ──────────────────────────── -->

<section class="s-sec">
  <div class="s-shell">
    <nav class="s-crumbs" aria-label="Breadcrumb" style="margin-bottom:2rem">
      <a href="<?= url('internships') ?>">Internships</a>
      <span>/</span>
      <a href="<?= url('internships/track?slug=' . urlencode((string) $track['slug'])) ?>"><?= Security::e($track['title']) ?></a>
      <span>/</span>
      <span aria-current="page">Apply</span>
    </nav>

    <div class="s-grid" style="gap:3rem 1.5rem">
      <!-- Explanation -->
      <div style="grid-column:span 5">
        <span class="s-eyebrow">Application</span>
        <h1 class="s-h1">Apply &mdash; <span class="s-it"><?= Security::e($track['title']) ?></span></h1>
        <p class="s-num" style="margin-top:1rem">
          <?= (int) $track['duration_weeks'] ?> weeks &middot; <?= Security::e($track['mode']) ?>
          &middot; <?= Security::e($track['stipend_text']) ?>
        </p>
        <p class="s-lede" style="margin-top:1.5rem">
          A short, specific note and a current resume are all we need. Our team reviews every application by hand.
        </p>

        <!-- Applicant summary (read-only, from the account) -->
        <div style="margin-top:2.5rem">
          <span class="s-eyebrow">Applying as &middot; from your account</span>
          <dl class="s-kv">
            <div>
              <dt>Name</dt>
              <dd><?= Security::e(internName()) ?></dd>
            </div>
            <div>
              <dt>Email</dt>
              <dd class="break-all"><?= Security::e((string) ($_SESSION['intern_email'] ?? '')) ?></dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Form -->
      <div style="grid-column:7 / span 6">
        <?php if (hasFlash('error')): ?>
          <div class="s-notice s-notice--error" role="alert" style="margin-bottom:1.75rem">
            <?= Security::e(getFlash('error')) ?>
          </div>
        <?php endif; ?>

        <form action="<?= url('internships/apply/store') ?>"
              method="POST"
              enctype="multipart/form-data"
              novalidate
              style="max-width:640px">

          <?= Security::csrfField() ?>
          <input type="hidden" name="track_id" value="<?= (int) $track['id'] ?>">

          <!-- Cover note -->
          <div class="s-field">
            <label for="cover_note" class="s-label">
              Why are you a good fit for this track? <span class="s-req">*</span>
            </label>
            <textarea id="cover_note"
                      name="cover_note"
                      rows="7"
                      required
                      minlength="40"
                      maxlength="4000"
                      class="s-textarea"
                      placeholder="Tell us what you have built or studied that relates to this track, the tools you are comfortable with, and what you want to get out of the internship."><?= Security::e($old['cover_note'] ?? '') ?></textarea>
            <p class="s-help">
              Minimum 40 characters. Specific examples of your own work count for far more than generic enthusiasm.
            </p>
          </div>

          <!-- Portfolio -->
          <div class="s-field">
            <label for="portfolio_url" class="s-label">Portfolio, GitHub or LinkedIn <span class="s-mute">(optional)</span></label>
            <input type="url"
                   id="portfolio_url"
                   name="portfolio_url"
                   value="<?= Security::e($old['portfolio_url'] ?? '') ?>"
                   maxlength="255"
                   class="s-input"
                   placeholder="https://github.com/your-username">
          </div>

          <!-- Resume -->
          <div class="s-field">
            <span class="s-label">Resume <span class="s-req">*</span></span>

            <label for="resume" class="s-file">
              <span>
                <span id="resumeLabel" style="display:block;color:var(--ink);font-weight:500">Choose your resume file</span>
                <span class="s-help" style="display:block;margin-top:.2rem">
                  PDF, DOC or DOCX &middot; up to <?= Security::e($maxResume) ?>
                </span>
              </span>
              <span class="s-btn--line s-btn--sm" aria-hidden="true">Browse</span>
            </label>

            <input type="file"
                   id="resume"
                   name="resume"
                   required
                   accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                   class="s-sr">

            <p class="s-help">
              Your resume is stored privately and is only visible to you and our hiring team.
            </p>
          </div>

          <!-- Declaration -->
          <div class="s-field">
            <label for="agree" class="s-check">
              <input type="checkbox" id="agree" name="agree" value="1" required>
              <span>
                I confirm the information provided is accurate, and I agree to the
                <a href="<?= url('terms') ?>" class="s-link">terms</a> and
                <a href="<?= url('privacy') ?>" class="s-link">privacy policy</a>.
                <span style="color:var(--danger)">*</span>
              </span>
            </label>
          </div>

          <div class="s-actions" style="padding-top:1.5rem;border-top:1px solid var(--rule)">
            <button type="submit" class="s-btn">Submit application</button>
            <a href="<?= url('internships/track?slug=' . urlencode((string) $track['slug'])) ?>" class="s-btn--line">Cancel</a>
          </div>
        </form>
      </div>
    </div>
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

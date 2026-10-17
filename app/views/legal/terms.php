<?php
/* Terms of Service — real, substantive document. Footer-linked sitewide. */
$company = setting('site_name') ?: 'EcoTech Services';
$email   = setting('site_email') ?: 'ecotech.internships@gmail.com';
$addr    = setting('site_address') ?: 'Lucknow, Uttar Pradesh, India';

$sections = [
    'agreement'    => 'The agreement',
    'engagements'  => 'Engagement models',
    'scope'        => 'Scope and change control',
    'client'       => 'What we need from you',
    'ip'           => 'Intellectual property',
    'thirdparty'   => 'Third-party components',
    'fees'         => 'Fees and payment',
    'maintenance'  => 'Maintenance and response',
    'confidential' => 'Confidentiality',
    'security'     => 'Security and data protection',
    'warranty'     => 'Warranty and disclaimers',
    'liability'    => 'Limitation of liability',
    'termination'  => 'Termination and handover',
    'compliance'   => 'Compliance and acceptable use',
    'website'      => 'Use of this website',
    'law'          => 'Governing law',
    'contact'      => 'Contact',
];
require __DIR__ . '/_style.php';
?>

<div class="doc">
  <div class="doc-shell pt-12 lg:pt-20 pb-12 lg:pb-16">
    <p class="doc-spec mb-5"><?= Security::e($company) ?> — legal</p>
    <h1 class="doc-display text-[2.4rem] sm:text-[3.2rem] lg:text-[3.8rem] max-w-[20ch] mb-6">Terms of Service</h1>
    <p class="text-[1.0625rem] max-w-[68ch]" style="color:var(--ink-2)">
      These terms govern engineering engagements with <?= Security::e($company) ?> and use of
      this website. They are written in plain language on purpose — if a clause here would
      surprise you in a dispute, it has been written badly.
    </p>
    <div class="flex flex-wrap gap-x-8 gap-y-2 mt-7">
      <span class="doc-spec">Last revised: <?= Security::e($revised ?? date('Y-m-d')) ?></span>
      <span class="doc-spec">Entity: <?= Security::e($company) ?></span>
      <span class="doc-spec">Jurisdiction: Lucknow, India</span>
    </div>
  </div>

  <div class="doc-band">
    <div class="doc-shell py-12 lg:py-16">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16">

        <nav class="lg:col-span-3 hidden lg:block" aria-label="Sections">
          <div class="doc-index">
            <p class="doc-spec mb-3">Contents</p>
            <ol>
              <?php foreach ($sections as $id => $label): ?>
              <li><a href="#<?= $id ?>" data-doc-link><?= Security::e($label) ?></a></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </nav>

        <div class="lg:col-span-9 doc-body" id="docBody">

          <section id="agreement">
            <h2>1. The agreement</h2>
            <p>
              An engagement begins when you accept a written proposal or statement of work
              from <?= Security::e($company) ?>. That document sets the scope, deliverables,
              schedule and fees. These terms apply to it and fill in everything the proposal
              does not say.
            </p>
            <p>
              Where the two conflict, the signed proposal or statement of work wins. Nothing
              said in a call, chat thread or email varies these terms unless it is confirmed
              in writing by both parties.
            </p>
          </section>

          <section id="engagements">
            <h2>2. Engagement models</h2>
            <table class="doc-table">
              <thead><tr><th>Model</th><th>Commitment</th><th>Billing</th></tr></thead>
              <tbody>
                <tr>
                  <th>Project-based</th>
                  <td>Fixed scope agreed after technical discovery, delivered in stages</td>
                  <td>Per delivery stage against an agreed schedule</td>
                </tr>
                <tr>
                  <th>Retainer</th>
                  <td>Ongoing ownership of a live system, fixed monthly hours, named engineer</td>
                  <td>Monthly in advance; hours reported, not assumed</td>
                </tr>
                <tr>
                  <th>Dedicated team</th>
                  <td>Engineers embedded in your process, minimum one quarter</td>
                  <td>Per engineer, monthly</td>
                </tr>
              </tbody>
            </table>
            <p>
              We do not sell subscription seats or licence fees for software we build for you.
              You are paying for engineering time and the artifacts it produces.
            </p>
          </section>

          <section id="scope">
            <h2>3. Scope and change control</h2>
            <p>
              Scope is defined in writing after technical discovery, because a scope written
              before anyone has read the existing system is a guess. Anything not listed in
              the statement of work is out of scope.
            </p>
            <h3>Changes</h3>
            <p>
              Change requests are normal and we do not penalise them. Each one is assessed for
              effort and impact on the schedule, then confirmed in writing before work starts.
              We will not absorb scope silently and then present a surprise at the end, and we
              will not perform requested work without a written record of it.
            </p>
            <h3>Delays</h3>
            <p>
              Where a dependency we do not control — an approval, a third-party API, access to
              an environment, content from your team — is late, the schedule moves by that
              delay. We flag the blocker when we hit it rather than at the deadline.
            </p>
          </section>

          <section id="client">
            <h2>4. What we need from you</h2>
            <ul>
              <li>A named decision-maker who can approve architecture and scope choices.</li>
              <li>Timely access to the environments, repositories and third-party accounts the work requires.</li>
              <li>Accurate information about the existing system, including known problems.</li>
              <li>Feedback on delivered stages within the review window in the statement of work.</li>
              <li>Confirmation that you have the right to give us the data and systems you give us access to.</li>
            </ul>
            <p>
              If review feedback does not arrive within the agreed window, the stage is treated
              as accepted so the project does not stall indefinitely.
            </p>
          </section>

          <section id="ip">
            <h2>5. Intellectual property</h2>
            <p>
              On full payment for a stage, all custom source code, configuration, schema,
              pipeline definitions and documentation produced for you in that stage are owned
              by you outright. There is no residual licence you must maintain to keep running
              what we built.
            </p>
            <h3>What stays ours</h3>
            <p>
              Pre-existing internal tooling, project scaffolding, and general engineering
              know-how remain ours. Where any of it is embedded in your deliverable, you get a
              perpetual, irrevocable, royalty-free licence to use, modify and redistribute it
              as part of that deliverable — including if you later hire someone else to
              maintain it.
            </p>
            <h3>Infrastructure accounts</h3>
            <p>
              Cloud, domain, repository and third-party service accounts are registered in
              your name wherever possible. We work inside your accounts rather than holding
              your production environment inside ours.
            </p>
            <h3>Portfolio</h3>
            <p>
              We may describe the engagement and show publicly visible interfaces in our
              portfolio unless you ask us not to. We will never publish your internal data,
              credentials, private screens or unannounced features.
            </p>
          </section>

          <section id="thirdparty">
            <h2>6. Third-party components</h2>
            <p>
              We keep dependencies minimal, and every one we do use carries its own licence
              which is not ours to grant. We tell you which third-party components a
              deliverable depends on and under what licence, and we avoid components whose
              terms would restrict how you run your own system.
            </p>
            <p>
              Paid third-party services — hosting, APIs, certificates, app-store fees — are
              billed to your accounts directly and are not included in our fees unless the
              statement of work says so.
            </p>
          </section>

          <section id="fees">
            <h2>7. Fees and payment</h2>
            <ul>
              <li>Fees, currency and payment schedule are set in the statement of work.</li>
              <li>Invoices are payable within 15 days of issue unless agreed otherwise.</li>
              <li>Applicable taxes are charged in addition where required by law.</li>
              <li>Estimates provided before discovery are indicative; the fee in the statement of work is the committed figure.</li>
              <li>Work on a stage may be paused where an invoice is more than 30 days overdue. We give notice before pausing.</li>
            </ul>
            <p>
              Ownership of deliverables transfers on payment for the stage that produced them,
              as set out in section 5.
            </p>
          </section>

          <section id="maintenance">
            <h2>8. Maintenance and response</h2>
            <p>
              Maintenance is part of the lifecycle we offer, not an afterthought, but it is a
              separate commitment from a build. Under a retainer we cover dependency and
              security patching, monitoring of logs and errors, backup restore drills,
              performance budget checks, and incremental changes within the agreed hours.
            </p>
            <p>
              Response targets, covered hours and escalation contacts are stated in the
              retainer document. We do not publish blanket uptime or response guarantees on
              this page, because a number that is not attached to a specific system and a
              specific contract is not worth anything.
            </p>
            <p>
              Without a retainer or a maintenance clause, we have no ongoing obligation to
              monitor or patch a delivered system. Environments we do not maintain drift, and
              we will say so rather than implying indefinite cover.
            </p>
          </section>

          <section id="confidential">
            <h2>9. Confidentiality</h2>
            <p>
              Each party will keep the other's non-public information confidential, use it
              only for the engagement, and disclose it only to people who need it for the
              work and are under equivalent obligations. This survives the end of the
              engagement.
            </p>
            <p>
              It does not apply to information that is already public, independently
              developed, or required to be disclosed by law — in which case we tell you before
              disclosing, where we are legally permitted to.
            </p>
          </section>

          <section id="security">
            <h2>10. Security and data protection</h2>
            <p>
              Where we process personal data on your behalf, you are the controller and we are
              the processor. We act on your documented instructions, restrict access to the
              engineers who need it, and delete or return the data at the end of the
              engagement.
            </p>
            <p>
              Our controls — least-privilege database users, secrets held outside the
              repository, reviewed changes only, encrypted transport, verified backups — are
              described in detail in the <a href="<?= url('privacy') ?>">Privacy Policy</a>.
              For engagements involving personal data at volume, a separate data-processing
              agreement is signed and takes precedence.
            </p>
            <div class="doc-callout">
              <p>
                We will notify you without undue delay of any security incident affecting your
                data or systems in our care, with the facts as we know them at the time rather
                than after an internal narrative has been prepared.
              </p>
            </div>
          </section>

          <section id="warranty">
            <h2>11. Warranty and disclaimers</h2>
            <p>
              We warrant that the work is performed with reasonable skill and care by
              competent engineers, and that deliverables will materially conform to the agreed
              specification. Defects reported within 30 days of a stage being accepted are
              corrected at no charge where they are genuine defects against that
              specification.
            </p>
            <p>
              That warranty does not cover changes made by you or a third party after
              handover, failures in third-party services, environments we do not maintain, or
              behaviour that follows from a requirement you asked for against our written
              advice.
            </p>
            <p>
              Beyond the above, deliverables are provided without further warranties, express
              or implied. We do not warrant that any software is free of all defects — no
              honest engineering firm can.
            </p>
          </section>

          <section id="liability">
            <h2>12. Limitation of liability</h2>
            <p>
              Neither party is liable for indirect, incidental, special or consequential loss,
              including lost profit, lost revenue, lost data beyond our restore obligations,
              or business interruption.
            </p>
            <p>
              Our total aggregate liability arising from an engagement is limited to the fees
              you paid us for that engagement in the 12 months before the claim.
            </p>
            <p>
              Nothing here limits liability that cannot be limited by law, including liability
              for fraud, wilful misconduct, or death or personal injury caused by negligence.
            </p>
          </section>

          <section id="termination">
            <h2>13. Termination and handover</h2>
            <p>
              Either party may terminate a project engagement with 30 days' written notice, or
              a retainer at the end of a billing month with 30 days' notice. Either party may
              terminate immediately for a material breach that is not cured within 15 days of
              written notice.
            </p>
            <h3>On termination</h3>
            <ul>
              <li>You pay for work performed and accepted up to the termination date.</li>
              <li>Ownership of everything paid for transfers to you, per section 5.</li>
              <li>We hand over source, credentials, pipeline definitions, deployment instructions and current documentation.</li>
              <li>We revoke our access to your systems and confirm that in writing.</li>
            </ul>
            <p>
              We do not withhold access, credentials or code as leverage in a commercial
              dispute. Disputed invoices are resolved as invoices, not by holding a production
              system hostage.
            </p>
          </section>

          <section id="compliance">
            <h2>14. Compliance and acceptable use</h2>
            <p>
              You are responsible for the legality of the system you ask us to build and the
              data you put into it, including any sector-specific regulation that applies to
              your industry. We will raise compliance risks we notice, but we are engineers
              and not your legal advisers.
            </p>
            <p>
              We will decline or stop work that is unlawful, that involves unauthorised access
              to systems you do not own or have written permission to test, that is designed
              to deceive users about what is being collected, or that exists to circumvent
              regulation. Security testing is performed only under a written authorisation
              naming the in-scope systems.
            </p>
          </section>

          <section id="website">
            <h2>15. Use of this website</h2>
            <p>
              The content of this site — text, structure, diagrams and code — belongs to
              <?= Security::e($company) ?> unless stated otherwise. You may read, quote and
              link to it with attribution. You may not scrape it for resale, republish it as
              your own, or use it to train a commercial model without written permission.
            </p>
            <p>
              Project descriptions on this site are published with client permission. Where
              outcome figures are not shown, that is because the client has not authorised
              publishing them — not because they are unavailable to us.
            </p>
            <p>
              We do not guarantee uninterrupted availability of this website and may change
              its content at any time.
            </p>
          </section>

          <section id="law">
            <h2>16. Governing law</h2>
            <p>
              These terms are governed by the laws of India. The courts at Lucknow, Uttar
              Pradesh have exclusive jurisdiction. Before filing, both parties agree to
              attempt resolution through a direct discussion between the named
              decision-makers.
            </p>
            <p>
              If any clause is held unenforceable, the rest continues to apply.
            </p>
          </section>

          <section id="contact">
            <h2>17. Contact</h2>
            <table class="doc-table">
              <tbody>
                <tr><th>Entity</th><td><?= Security::e($company) ?></td></tr>
                <tr><th>Address</th><td><?= Security::e($addr) ?></td></tr>
                <tr><th>Email</th><td><a href="mailto:<?= Security::e($email) ?>"><?= Security::e($email) ?></a></td></tr>
                <tr><th>Hours</th><td><?= Security::e(setting('business_hours') ?: 'Mon – Sat, 09:00 – 18:00 IST') ?></td></tr>
              </tbody>
            </table>
            <p style="margin-top:1.4rem">
              <a href="<?= url('privacy') ?>" class="doc-cta">Read the Privacy Policy <span class="doc-cta-mark" aria-hidden="true">&rarr;</span></a>
            </p>
          </section>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
/* Section index reflects the section currently being read. */
(function () {
  'use strict';
  var links = document.querySelectorAll('[data-doc-link]');
  var sections = document.querySelectorAll('#docBody section');
  if (!links.length || !sections.length || !('IntersectionObserver' in window)) return;

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      links.forEach(function (a) {
        a.classList.toggle('is-current', a.getAttribute('href') === '#' + entry.target.id);
      });
    });
  }, { rootMargin: '-120px 0px -65% 0px' });

  sections.forEach(function (s) { io.observe(s); });
})();
</script>

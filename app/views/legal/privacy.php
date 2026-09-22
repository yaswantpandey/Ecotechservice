<?php
/* Privacy Policy — real, substantive document. Footer-linked sitewide. */
$company = setting('site_name') ?: 'EcoTech Services';
$email   = setting('site_email') ?: 'ecotech.internships@gmail.com';
$addr    = setting('site_address') ?: 'Lucknow, Uttar Pradesh, India';
$phone   = setting('site_phone') ?: '+91 7398301184';

$sections = [
    'scope'         => 'Scope of this policy',
    'what'          => 'What we collect',
    'client-data'   => 'Client production data',
    'why'           => 'Why we process it',
    'security'      => 'Security measures',
    'subprocessors' => 'Sub-processors',
    'cookies'       => 'Cookies and analytics',
    'retention'     => 'Retention and deletion',
    'transfers'     => 'International transfers',
    'rights'        => 'Your rights',
    'children'      => 'Children',
    'changes'       => 'Changes to this policy',
    'contact'       => 'Contact',
];
require __DIR__ . '/_style.php';
?>

<div class="doc">
  <div class="doc-shell pt-[104px] md:pt-[124px] lg:pt-[140px] pb-12 lg:pb-16">
    <p class="doc-spec mb-5"><?= Security::e($company) ?> — legal</p>
    <h1 class="doc-display text-[2.4rem] sm:text-[3.2rem] lg:text-[3.8rem] max-w-[20ch] mb-6">Privacy Policy</h1>
    <p class="text-[1.0625rem] max-w-[68ch]" style="color:var(--ink-2)">
      This policy explains what data <?= Security::e($company) ?> collects through this
      website, what happens to client data we are given access to during an engineering
      engagement, and how long any of it is kept. It is written to be read, not to be
      skimmed past.
    </p>
    <div class="flex flex-wrap gap-x-8 gap-y-2 mt-7">
      <span class="doc-spec">Last revised: <?= Security::e($revised ?? date('Y-m-d')) ?></span>
      <span class="doc-spec">Controller: <?= Security::e($company) ?></span>
      <span class="doc-spec">Jurisdiction: India</span>
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

          <section id="scope">
            <h2>1. Scope of this policy</h2>
            <p>
              <?= Security::e($company) ?> is a software engineering company registered and
              operating from <?= Security::e($addr) ?>. This policy covers two distinct
              relationships, and they are governed differently:
            </p>
            <ul>
              <li><strong>Website visitors and enquirers.</strong> We are the data controller. We decide what is collected and why.</li>
              <li><strong>Client systems we are engaged to build or maintain.</strong> The client is the controller and we act as a data processor, handling data only under their instruction and only as far as the work requires.</li>
            </ul>
            <p>
              Where an engagement involves personal data at any meaningful volume, a separate
              written data-processing agreement governs it and takes precedence over this
              page for that engagement.
            </p>
          </section>

          <section id="what">
            <h2>2. What we collect</h2>
            <table class="doc-table">
              <thead>
                <tr><th>Data</th><th>Source</th><th>Basis</th></tr>
              </thead>
              <tbody>
                <tr>
                  <th>Name, email, phone, company, message body</th>
                  <td>Submitted by you in the contact form or by email</td>
                  <td>Your request — we need it to reply</td>
                </tr>
                <tr>
                  <th>Technical context you send us</th>
                  <td>Repository links, staging URLs, screenshots, logs you attach</td>
                  <td>Necessary to assess the work you are asking about</td>
                </tr>
                <tr>
                  <th>IP address, user agent, timestamp of a form submission</th>
                  <td>Captured by the server when the form is posted</td>
                  <td>Legitimate interest — abuse prevention and spam filtering</td>
                </tr>
                <tr>
                  <th>Aggregate page analytics</th>
                  <td>Google Analytics / Google Tag Manager</td>
                  <td>Consent-based; see section 7</td>
                </tr>
              </tbody>
            </table>
            <p>
              We do not buy contact lists, we do not enrich your record from third-party data
              brokers, and we do not build behavioural profiles for advertising. There is no
              marketing automation sequence behind the contact form.
            </p>
          </section>

          <section id="client-data">
            <h2>3. Client production data</h2>
            <p>
              Building and maintaining enterprise applications, microservices and serverless
              workflows sometimes requires access to real systems. Because that is the
              highest-risk category of data we touch, we constrain it explicitly:
            </p>
            <ul>
              <li>Access is requested per environment and per person, never as a shared team credential.</li>
              <li>We prefer anonymised or masked datasets for development and testing, and ask for production access only when a fault cannot be reproduced otherwise.</li>
              <li>Production database users we operate under are least-privilege: read-only unless a write is part of the task.</li>
              <li>Client data is not copied to engineer workstations except where required to diagnose a specific fault, and is deleted when that fault is closed.</li>
              <li>Credentials are held in a secret manager, injected at deploy time, and never committed to a repository or pasted into a ticket.</li>
              <li>Access is revoked at the end of the engagement, and we provide written confirmation of revocation on request.</li>
            </ul>
            <div class="doc-callout">
              <p>
                We do not use client production data to train models, to build internal
                datasets, or as demonstration material. Client work appears in our Project
                only with permission, and only using publicly visible interfaces.
              </p>
            </div>
          </section>

          <section id="why">
            <h2>4. Why we process it</h2>
            <ul>
              <li>To answer an enquiry and scope potential work.</li>
              <li>To deliver a contracted engagement — discovery, architecture, implementation, deployment automation and maintenance.</li>
              <li>To operate and secure this website, including blocking automated abuse.</li>
              <li>To meet statutory record-keeping and tax obligations for invoiced work.</li>
            </ul>
            <p>
              We do not make automated decisions about you that have legal or similarly
              significant effects.
            </p>
          </section>

          <section id="security">
            <h2>5. Security measures</h2>
            <p>
              The same controls we build for clients apply to our own systems. Concretely:
            </p>
            <table class="doc-table">
              <tbody>
                <tr><th>Transport</th><td>HTTPS enforced on this site; encrypted connections to all databases and cloud APIs.</td></tr>
                <tr><th>Application layer</th><td>Parameterised queries throughout, CSRF tokens on every state-changing request, server-side validation of all input, output escaped on render.</td></tr>
                <tr><th>Access control</th><td>Least-privilege accounts, multi-factor authentication on cloud consoles, source-control and deployment access reviewed when team composition changes.</td></tr>
                <tr><th>Secrets</th><td>Held outside the repository, injected at deploy time, rotated after any suspected exposure or personnel change.</td></tr>
                <tr><th>Review</th><td>Changes reach production through a reviewed pull request and an automated pipeline. Direct production edits are not permitted.</td></tr>
                <tr><th>Backups</th><td>Scheduled backups with restore drills, so a backup is verified rather than assumed.</td></tr>
                <tr><th>Incidents</th><td>Where a breach affects personal data we control, we notify affected parties and the relevant authority without undue delay, with the facts we have at the time.</td></tr>
              </tbody>
            </table>
            <p>
              No system is absolutely secure, and we will not claim otherwise. What we commit
              to is that the controls above are in place and that we will tell you plainly if
              something fails.
            </p>
          </section>

          <section id="subprocessors">
            <h2>6. Sub-processors</h2>
            <p>
              We keep this list deliberately short, because every additional processor is
              additional exposure.
            </p>
            <table class="doc-table">
              <thead><tr><th>Processor</th><th>Purpose</th><th>Data reached</th></tr></thead>
              <tbody>
                <tr><th>Hosting and email provider</th><td>Serving this website and delivering enquiry email</td><td>Contact form submissions, server logs</td></tr>
                <tr><th>Google Analytics / Tag Manager</th><td>Aggregate traffic measurement</td><td>Pseudonymous usage events, truncated IP</td></tr>
                <tr><th>Cloud infrastructure providers</th><td>Running client systems we build or operate</td><td>Whatever the client system stores, under the client's instruction</td></tr>
              </tbody>
            </table>
            <p>
              A current, named list of processors for a specific engagement is available to
              that client on request.
            </p>
          </section>

          <section id="cookies">
            <h2>7. Cookies and analytics</h2>
            <p>
              This site sets a first-party session cookie which is strictly necessary — it
              maintains your session and carries the CSRF token that protects form
              submissions. It contains no tracking identifier and expires with the session.
            </p>
            <p>
              Analytics cookies are set by Google Analytics and Google Tag Manager to measure
              aggregate traffic, such as which pages are read and which are not. We use this
              to remove pages nobody reads, not to identify individuals. You can block these
              in your browser settings or with any standard content blocker; the site
              functions identically without them.
            </p>
            <p>
              We do not run advertising pixels, remarketing tags, or cross-site behavioural
              trackers.
            </p>
          </section>

          <section id="retention">
            <h2>8. Retention and deletion</h2>
            <table class="doc-table">
              <tbody>
                <tr><th>Enquiries that did not become engagements</th><td>Deleted within 12 months of the last message</td></tr>
                <tr><th>Active client correspondence</th><td>Retained for the life of the engagement</td></tr>
                <tr><th>Invoices and contractual records</th><td>Retained as long as statutory accounting rules require</td></tr>
                <tr><th>Server and application logs</th><td>Rotated, typically retained under 90 days</td></tr>
                <tr><th>Credentials and access to client systems</th><td>Revoked at the end of the engagement</td></tr>
              </tbody>
            </table>
            <p>
              You can ask us to delete your enquiry earlier than the schedule above, and we
              will, except where a specific record must be retained by law.
            </p>
          </section>

          <section id="transfers">
            <h2>9. International transfers</h2>
            <p>
              We operate from India. Some processors — analytics and cloud infrastructure in
              particular — process data outside India. Where that happens we rely on the
              provider's contractual transfer safeguards, and for client engagements we will
              deploy into a specified region on request if data residency is a requirement.
              Ask during discovery, not after launch; region is an architectural decision.
            </p>
          </section>

          <section id="rights">
            <h2>10. Your rights</h2>
            <p>
              For data where we are the controller, you may ask us to:
            </p>
            <ul>
              <li>confirm what we hold about you and provide a copy;</li>
              <li>correct anything inaccurate;</li>
              <li>delete it, subject to statutory retention;</li>
              <li>restrict or object to a particular use;</li>
              <li>withdraw consent for analytics at any time.</li>
            </ul>
            <p>
              Write to <a href="mailto:<?= Security::e($email) ?>"><?= Security::e($email) ?></a>.
              We respond within 30 days. We will not charge you for a reasonable request, and
              we will not require you to justify it. Where we act as a processor for a client
              system, direct the request to that client and we will support them in answering it.
            </p>
          </section>

          <section id="children">
            <h2>11. Children</h2>
            <p>
              Our services are sold to organisations, and this site is not directed at
              children. We do not knowingly collect personal data from anyone under 18. If you
              believe a child has submitted information through this site, contact us and we
              will remove it.
            </p>
          </section>

          <section id="changes">
            <h2>12. Changes to this policy</h2>
            <p>
              When this policy changes substantively we update the revision date at the top of
              the page. For material changes affecting an active engagement, we notify the
              client contact directly rather than relying on you noticing a new date.
            </p>
          </section>

          <section id="contact">
            <h2>13. Contact</h2>
            <table class="doc-table">
              <tbody>
                <tr><th>Entity</th><td><?= Security::e($company) ?></td></tr>
                <tr><th>Address</th><td><?= Security::e($addr) ?></td></tr>
                <tr><th>Email</th><td><a href="mailto:<?= Security::e($email) ?>"><?= Security::e($email) ?></a></td></tr>
                <tr><th>Phone</th><td><?= Security::e($phone) ?></td></tr>
                <tr><th>Hours</th><td><?= Security::e(setting('business_hours') ?: 'Mon – Sat, 09:00 – 18:00 IST') ?></td></tr>
              </tbody>
            </table>
            <p style="margin-top:1.4rem">
              <a href="<?= url('terms') ?>" class="doc-cta">Read the Terms of Service <span style="font-family:'IBM Plex Mono',monospace;font-size:.75rem;opacity:.75">&rarr;</span></a>
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
  }, { rootMargin: '-130px 0px -65% 0px' });

  sections.forEach(function (s) { io.observe(s); });
})();
</script>

<?php
/* Shared presentation layer for the legal documents. Follows site.css:
   warm paper, graphite ink, Fraunces / IBM Plex, 1px rules, 2px radius. */
?>
<style>
.doc {
  background: var(--paper, #EDEAE2); color: var(--ink, #191A17);
  font-family: var(--f-body, 'IBM Plex Sans', system-ui, sans-serif); font-size: 16px; line-height: 1.65;
}
.doc ::selection { background: var(--signal, #2C5F42); color: var(--paper, #EDEAE2); }
.doc-shell { max-width: var(--shell, 1180px); margin: 0 auto; padding: 0 1.25rem; }
@media (min-width: 1024px) { .doc-shell { padding: 0 2.5rem; } }
.doc-display {
  font-family: var(--f-display, 'Fraunces', Georgia, serif); font-weight: 500;
  line-height: 1.02; letter-spacing: -0.025em; color: var(--ink, #191A17);
}
.doc-spec {
  font-family: var(--f-mono, 'IBM Plex Mono', ui-monospace, monospace); font-size: .6875rem;
  letter-spacing: .08em; text-transform: uppercase; color: var(--ink-3, #6E7066);
}
.doc-band { border-top: 1px solid var(--rule, #C7C2B4); }

/* Sticky section index, highlights the section in view */
.doc-index { position: sticky; top: calc(var(--nav-h, 72px) + 2rem); }
.doc-index ol { list-style: none; margin: 0; padding: 0; counter-reset: idx; border-top: 1px solid var(--ink, #191A17); }
.doc-index li { counter-increment: idx; border-bottom: 1px solid var(--rule, #C7C2B4); }
.doc-index a {
  display: flex; gap: .7rem; padding: .55rem 0; font-size: .8125rem;
  color: var(--ink-2, #43453E); text-decoration: none;
}
.doc-index a::before {
  content: counter(idx, decimal-leading-zero);
  font-family: var(--f-mono, 'IBM Plex Mono', monospace); font-size: .6875rem;
  color: var(--ink-3, #6E7066); padding-top: .15rem;
}
.doc-index a:hover { color: var(--ink, #191A17); text-decoration: underline; text-underline-offset: .2em; }
.doc-index a.is-current, .doc-index a.is-current::before { color: var(--signal, #2C5F42); }

/* Body copy */
.doc-body { max-width: 72ch; }
.doc-body section { padding: 2.5rem 0; border-top: 1px solid var(--rule, #C7C2B4); scroll-margin-top: calc(var(--nav-h, 72px) + 1.5rem); }
.doc-body section:first-of-type { border-top: 0; padding-top: 0; }
.doc-body h2 {
  font-family: var(--f-display, 'Fraunces', Georgia, serif); font-weight: 500;
  font-size: 1.75rem; line-height: 1.15; letter-spacing: -0.015em; margin: 0 0 1rem; color: var(--ink, #191A17);
}
.doc-body h3 { font-size: .9375rem; font-weight: 600; margin: 1.6rem 0 .5rem; color: var(--ink, #191A17); }
.doc-body p { color: var(--ink-2, #43453E); margin: 0 0 .9rem; }
.doc-body p:last-child { margin-bottom: 0; }
.doc-body a { color: var(--signal, #2C5F42); text-decoration: underline; text-decoration-thickness: 1px; text-underline-offset: .2em; }
.doc-body a:hover { color: var(--ink, #191A17); }
.doc-body ul { list-style: none; margin: 0 0 .9rem; padding: 0; border-top: 1px solid var(--rule, #C7C2B4); }
.doc-body ul li { position: relative; padding: .45rem 0 .45rem 1.5rem; color: var(--ink-2, #43453E); font-size: .9375rem; border-bottom: 1px solid var(--rule, #C7C2B4); }
.doc-body ul li::before { content: '\2014'; position: absolute; left: 0; color: var(--ink-3, #6E7066); }

.doc-table { width: 100%; border-collapse: collapse; font-size: .875rem; margin-bottom: .9rem; }
.doc-table th, .doc-table td { text-align: left; vertical-align: top; padding: .7rem .8rem .7rem 0; border-bottom: 1px solid var(--rule, #C7C2B4); color: var(--ink-2, #43453E); }
.doc-table thead th {
  font-family: var(--f-mono, 'IBM Plex Mono', monospace); font-weight: 400; font-size: .6875rem;
  letter-spacing: .06em; text-transform: uppercase; color: var(--ink-3, #6E7066); border-bottom-color: var(--ink, #191A17);
}
.doc-table tbody th { font-weight: 600; color: var(--ink, #191A17); width: 34%; }

.doc-callout { border: 1px solid var(--rule, #C7C2B4); border-left: 3px solid var(--signal, #2C5F42); background: var(--paper-deep, #E5E1D7); padding: 1.1rem 1.25rem; margin: 1.2rem 0; border-radius: var(--r, 2px); }
.doc-callout p { margin-bottom: 0; font-size: .9375rem; }

.doc-body a.doc-cta, .doc-cta {
  display: inline-flex; align-items: baseline; gap: .6rem;
  background: var(--signal, #2C5F42); color: var(--paper, #EDEAE2);
  padding: .8rem 1.3rem; font-weight: 500; font-size: .9375rem;
  border: 1px solid var(--signal, #2C5F42); border-radius: var(--r, 2px); text-decoration: none;
}
.doc-body a.doc-cta:hover, .doc-cta:hover { background: var(--ink, #191A17); border-color: var(--ink, #191A17); color: var(--paper, #EDEAE2); }
.doc-cta-mark { font-family: var(--f-mono, 'IBM Plex Mono', monospace); font-size: .75rem; }
</style>

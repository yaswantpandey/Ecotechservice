-- ============================================================
-- Template migration: add thumbnails, prices, new templates
-- Run after the base ecotech.sql seed.
-- ============================================================

-- Update existing templates with thumbnails, prices, and richer descriptions
UPDATE `templates` SET
  `description` = 'A clean, modern business template with responsive grid layout, service sections, stats bar and dark/light mode toggle. Ideal for consultancies, agencies and professional service firms.',
  `thumbnail`   = 'img/templates/business_pro.svg',
  `price`       = 0.00
WHERE `slug` = 'business-pro';

UPDATE `templates` SET
  `description` = 'Everything a SaaS startup needs — hero with product mockup, feature grid, pricing tiers, FAQ accordion and testimonial section. Dark mode variant included.',
  `thumbnail`   = 'img/templates/saas_launch_kit.svg',
  `price`       = 1499.00
WHERE `slug` = 'saas-launch-kit';

UPDATE `templates` SET
  `description` = 'Nature-inspired landing page with full-bleed hero, animated stats counters, mission section and image gallery. Optimised for conversion and fast loading.',
  `thumbnail`   = 'img/templates/eco_landing.svg',
  `price`       = 0.00
WHERE `slug` = 'eco-landing';

-- Insert new templates
INSERT INTO `templates` (`title`,`slug`,`description`,`thumbnail`,`price`,`is_free`,`is_active`) VALUES
('Startup Folio','startup-folio',
 'A startup portfolio template with hero split layout, product mockup, key metrics, and investor showcase section. Perfect for pitch-ready landing pages.',
 'img/templates/startup_folio.svg', 0.00, 1, 1),

('Minimal Blog','minimal-blog',
 'A distraction-free blog template with featured post hero, sidebar recent posts, newsletter signup and category-filtered essay grid.',
 'img/templates/minimal_blog.svg', 0.00, 1, 1),

('Agency Studio','agency-studio',
 'A dark-mode creative agency template with bold typographic hero, alternating work rows and studio journal. Built for design studios and creative collectives.',
 'img/templates/agency_studio.svg', 1999.00, 0, 1),

('E-commerce Lite','ecommerce-lite',
 'A lightweight online store template with product grid, category navigation, search bar, cart badge and promotional banner. Clean, fast and conversion-focused.',
 'img/templates/ecommerce_lite.svg', 2499.00, 0, 1),

('Portfolio Pro','portfolio-pro',
 'A designer portfolio template with numbered case studies, capabilities section, client testimonial band and resume download. Tailored for product designers and developers.',
 'img/templates/portfolio_pro.svg', 1799.00, 0, 1);

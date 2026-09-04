-- ============================================================
-- Ecotech Service - Full Database Schema
-- Compatible with MySQL 5.7+ / MariaDB 10.3+
-- ============================================================
-- -----------------------------------------------------------
-- Table: users (Admin authentication)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100)    NOT NULL,
  `email`      VARCHAR(150)    NOT NULL UNIQUE,
  `password`   VARCHAR(255)    NOT NULL COMMENT 'bcrypt hash',
  `role`       ENUM('admin','editor') NOT NULL DEFAULT 'editor',
  `is_active`  TINYINT(1)      NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin: admin@ecotech.com / Admin@123
INSERT INTO `users` (`name`,`email`,`password`,`role`) VALUES
('Super Admin','admin@ecotech.com','$2y$12$A1GhTxqJ3rXs2yWkP9DlCeH5nM7vQbZ8uFj4iKwN6oR0sTcVpXgDm','admin');

-- -----------------------------------------------------------
-- Table: services
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `services` (
  `id`          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(150)    NOT NULL,
  `slug`        VARCHAR(160)    NOT NULL UNIQUE,
  `description` TEXT            NOT NULL,
  `icon`        VARCHAR(60)     NOT NULL DEFAULT 'fa-cog' COMMENT 'FontAwesome class',
  `image`       VARCHAR(255)    DEFAULT NULL,
  `is_active`   TINYINT(1)      NOT NULL DEFAULT 1,
  `sort_order`  SMALLINT        NOT NULL DEFAULT 0,
  `created_at`  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_services_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `services` (`title`,`slug`,`description`,`icon`,`sort_order`) VALUES
('Web Development','web-development','We craft blazing-fast, SEO-optimised websites and web applications using the latest modern stack.','fa-code',1),
('Digital Marketing','digital-marketing','Data-driven SEO, social media, PPC, and content strategies that convert visitors into loyal customers.','fa-chart-line',2),
('Mobile App Development','mobile-app-development','Cross-platform iOS and Android applications built with React Native and Flutter.','fa-mobile-alt',3),
('UI/UX Design','ui-ux-design','User-centred design systems, wireframes, and interactive prototypes that delight and retain users.','fa-paint-brush',4),
('Cloud & DevOps','cloud-devops','AWS / GCP deployments, CI/CD pipelines, Docker orchestration, and 24×7 server monitoring.','fa-cloud',5),
('EcoTech Solutions','ecotech-solutions','Green-tech consulting — energy dashboards, IoT integrations, and sustainability reporting tools.','fa-leaf',6);

-- -----------------------------------------------------------
-- Table: projects
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`         VARCHAR(200)    NOT NULL,
  `slug`          VARCHAR(210)    NOT NULL UNIQUE,
  `description`   TEXT            NOT NULL,
  `tech_stack`    VARCHAR(255)    NOT NULL,
  `category`      ENUM('website','marketing','template','mobile','other') NOT NULL DEFAULT 'website',
  `thumbnail`     VARCHAR(255)    DEFAULT NULL,
  `live_url`      VARCHAR(255)    DEFAULT NULL,
  `github_url`    VARCHAR(255)    DEFAULT NULL,
  `is_featured`   TINYINT(1)      NOT NULL DEFAULT 0,
  `is_active`     TINYINT(1)      NOT NULL DEFAULT 1,
  `sort_order`    SMALLINT        NOT NULL DEFAULT 0,
  `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_projects_category` (`category`),
  INDEX `idx_projects_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `projects` (`title`,`slug`,`description`,`tech_stack`,`category`,`is_featured`,`sort_order`) VALUES
('GreenTrack Dashboard','greentrack-dashboard','Real-time environmental monitoring dashboard for urban sustainability teams.','PHP, Chart.js, MySQL, REST API','website',1,1),
('EcoShop E-commerce','ecoshop-ecommerce','Full-featured sustainable products marketplace with Stripe payments.','Laravel, Vue.js, MySQL, Stripe','website',1,2),
('SolarMetrics App','solarmetrics-app','Mobile application tracking solar panel efficiency and energy savings.','React Native, Node.js, MongoDB','mobile',1,3),
('AgriConnect Platform','agriconnect-platform','B2B marketplace linking farmers with organic retailers.','PHP MVC, MySQL, Tailwind CSS','website',0,4),
('Startup Landing Pro','startup-landing-pro','Premium responsive landing page template for SaaS startups.','HTML5, CSS3, JavaScript','template',0,5),
('Marketing Blitz Campaign','marketing-blitz','360° digital marketing campaign that tripled client revenue in 6 months.','Google Ads, Meta Ads, SEO','marketing',0,6);

-- -----------------------------------------------------------
-- Table: project_images (gallery per project)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_images` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` INT UNSIGNED NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `alt_text`   VARCHAR(200) DEFAULT NULL,
  `sort_order` SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_pi_project` (`project_id`),
  CONSTRAINT `fk_pi_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Table: templates
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `templates` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(150) NOT NULL,
  `slug`        VARCHAR(160) NOT NULL UNIQUE,
  `description` TEXT         NOT NULL,
  `preview_url` VARCHAR(255) DEFAULT NULL,
  `download_url`VARCHAR(255) DEFAULT NULL,
  `thumbnail`   VARCHAR(255) DEFAULT NULL,
  `price`       DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  `is_free`     TINYINT(1)   NOT NULL DEFAULT 1,
  `is_active`   TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `templates` (`title`,`slug`,`description`,`is_free`) VALUES
('Business Pro','business-pro','A clean, modern business portfolio template with dark/light mode.', 1),
('SaaS Launch Kit','saas-launch-kit','Everything a SaaS startup needs — hero, pricing, FAQ, testimonials.', 0),
('Eco Landing Page','eco-landing','Nature-inspired landing page template optimised for conversions.', 1);

-- -----------------------------------------------------------
-- Table: testimonials
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL,
  `position`   VARCHAR(100) DEFAULT NULL,
  `company`    VARCHAR(100) DEFAULT NULL,
  `avatar`     VARCHAR(255) DEFAULT NULL,
  `message`    TEXT         NOT NULL,
  `rating`     TINYINT      NOT NULL DEFAULT 5 COMMENT '1-5 stars',
  `is_active`  TINYINT(1)   NOT NULL DEFAULT 1,
  `sort_order` SMALLINT     NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `testimonials` (`name`,`position`,`company`,`message`,`rating`,`sort_order`) VALUES
('Sarah Johnson','CEO','GreenVenture Inc.','Ecotech transformed our online presence. The team delivered a stunning, fast website that increased our leads by 220%.', 5, 1),
('Michael Chen','CTO','SolarWave','Exceptional mobile app development. Our SolarMetrics app now has 15k+ active users within 3 months of launch.', 5, 2),
('Priya Sharma','Marketing Director','AgroFresh','Their digital marketing campaign was outstanding — ROI was 4× what we expected. Highly recommend Ecotech!', 5, 3),
('David Okeke','Founder','EcoBuild Ltd.','Clean code, on-time delivery, and excellent communication. Best tech partner we have ever worked with.', 5, 4);

-- -----------------------------------------------------------
-- Table: contacts (form submissions)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contacts` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100) NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `phone`      VARCHAR(20)  DEFAULT NULL,
  `subject`    VARCHAR(200) NOT NULL,
  `message`    TEXT         NOT NULL,
  `is_read`    TINYINT(1)   NOT NULL DEFAULT 0,
  `ip_address` VARCHAR(45)  DEFAULT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_contacts_email` (`email`),
  INDEX `idx_contacts_read`  (`is_read`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Table: blog_posts (optional / future)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`     INT UNSIGNED NOT NULL,
  `title`       VARCHAR(200) NOT NULL,
  `slug`        VARCHAR(210) NOT NULL UNIQUE,
  `excerpt`     TEXT         DEFAULT NULL,
  `body`        LONGTEXT     NOT NULL,
  `thumbnail`   VARCHAR(255) DEFAULT NULL,
  `is_published`TINYINT(1)   NOT NULL DEFAULT 0,
  `published_at`TIMESTAMP    NULL DEFAULT NULL,
  `created_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_bp_slug`    (`slug`),
  INDEX `idx_bp_user`    (`user_id`),
  CONSTRAINT `fk_bp_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------
-- Table: site_settings (key-value store)
-- -----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_settings` (
  `key`        VARCHAR(60)  NOT NULL,
  `value`      TEXT         DEFAULT NULL,
  `updated_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings` (`key`,`value`) VALUES
('site_name','Ecotech Service'),
('site_tagline','Building Sustainable Digital Futures'),
('site_email','ecotech.servic@gmail.com'),
('site_phone','+917398301184'),
('site_address','Lucknow uttar pradesh'),
('whatsapp_number','7398301184'),
('google_analytics_id','G-4ZPQCKJ3EL'),
('meta_description','Ecotech Service — Full-stack web development, digital marketing, and eco-technology solutions for modern businesses.'),
('facebook_url','https://facebook.com/ecotechservice'),
('twitter_url','https://twitter.com/ecotechservice'),
('linkedin_url','https://linkedin.com/company/ecotechservice'),
('instagram_url','https://instagram.com/ecotech.service');

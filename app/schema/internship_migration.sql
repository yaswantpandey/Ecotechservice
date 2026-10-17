-- ============================================================
-- Ecotech Service — Internship Portal Migration
-- Additive only. Does not modify any existing table.
-- Run:  mysql -u root ecotech_service < database/internship_migration.sql
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 1;

-- ─── Intern accounts (separate from the admin `users` table) ──────────────
CREATE TABLE IF NOT EXISTS `interns` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`            VARCHAR(120)  NOT NULL,
    `email`           VARCHAR(190)  NOT NULL,
    `phone`           VARCHAR(20)   DEFAULT NULL,
    `password`        VARCHAR(255)  NOT NULL,
    `college`         VARCHAR(190)  DEFAULT NULL,
    `course`          VARCHAR(120)  DEFAULT NULL,
    `graduation_year` SMALLINT UNSIGNED DEFAULT NULL,
    `is_active`       TINYINT(1)    NOT NULL DEFAULT 1,
    `last_login_at`   DATETIME      DEFAULT NULL,
    `created_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_interns_email` (`email`),
    KEY `idx_interns_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Internship tracks ───────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `internship_tracks` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`          VARCHAR(150) NOT NULL,
    `slug`           VARCHAR(160) NOT NULL,
    `short_desc`     VARCHAR(255) NOT NULL,
    `description`    TEXT         NOT NULL,
    `skills`         VARCHAR(500) NOT NULL DEFAULT '',
    `icon`           VARCHAR(60)  NOT NULL DEFAULT 'fa-code',
    `duration_weeks` SMALLINT UNSIGNED NOT NULL DEFAULT 8,
    `stipend_text`   VARCHAR(120) NOT NULL DEFAULT 'Performance based',
    `seats`          SMALLINT UNSIGNED NOT NULL DEFAULT 10,
    `mode`           VARCHAR(40)  NOT NULL DEFAULT 'Remote / Hybrid',
    `is_active`      TINYINT(1)   NOT NULL DEFAULT 1,
    `sort_order`     SMALLINT     NOT NULL DEFAULT 0,
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_tracks_slug` (`slug`),
    KEY `idx_tracks_active_sort` (`is_active`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Applications ────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `applications` (
    `id`                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ref_no`               VARCHAR(40)  NOT NULL,
    `intern_id`            INT UNSIGNED NOT NULL,
    `track_id`             INT UNSIGNED NOT NULL,
    `status`               ENUM('pending','under_review','shortlisted','approved','rejected','withdrawn')
                           NOT NULL DEFAULT 'pending',
    `cover_note`           TEXT         DEFAULT NULL,
    `portfolio_url`        VARCHAR(255) DEFAULT NULL,
    `resume_path`          VARCHAR(255) NOT NULL,
    `resume_original_name` VARCHAR(255) NOT NULL,
    `resume_mime`          VARCHAR(100) NOT NULL,
    `resume_size`          INT UNSIGNED NOT NULL DEFAULT 0,
    `admin_notes`          TEXT         DEFAULT NULL,
    `reviewed_by`          INT UNSIGNED DEFAULT NULL,
    `reviewed_at`          DATETIME     DEFAULT NULL,
    `offer_letter_no`      VARCHAR(40)  DEFAULT NULL,
    `approved_at`          DATETIME     DEFAULT NULL,
    `start_date`           DATE         DEFAULT NULL,
    `ip_address`           VARCHAR(45)  DEFAULT NULL,
    `created_at`           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`           TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_app_ref` (`ref_no`),
    UNIQUE KEY `uq_app_intern_track` (`intern_id`, `track_id`),
    KEY `idx_app_status` (`status`),
    KEY `idx_app_track` (`track_id`),
    KEY `idx_app_created` (`created_at`),
    CONSTRAINT `fk_app_intern` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_app_track`  FOREIGN KEY (`track_id`)  REFERENCES `internship_tracks` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_app_admin`  FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Status history (audit trail for the dashboard timeline) ──────────────
CREATE TABLE IF NOT EXISTS `application_status_history` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `application_id` INT UNSIGNED NOT NULL,
    `old_status`     VARCHAR(30)  DEFAULT NULL,
    `new_status`     VARCHAR(30)  NOT NULL,
    `note`           VARCHAR(500) DEFAULT NULL,
    `changed_by`     INT UNSIGNED DEFAULT NULL,
    `changed_by_name` VARCHAR(120) DEFAULT NULL,
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_hist_app` (`application_id`, `created_at`),
    CONSTRAINT `fk_hist_app` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─── Seed the 11 internship tracks ───────────────────────────────────────
INSERT INTO `internship_tracks`
    (`title`, `slug`, `short_desc`, `description`, `skills`, `icon`, `duration_weeks`, `stipend_text`, `seats`, `sort_order`)
VALUES
('Full Stack Development', 'full-stack-development',
 'Build complete web products end to end, from database schema to deployed interface.',
 'Work across the entire stack on production-style features. You will design relational schemas, build server-side routing and business logic, then consume your own endpoints from the interface. The track covers authentication, form handling, file uploads, session management and deployment, closing with a fully working application you own.',
 'HTML, CSS, JavaScript, PHP or Node.js, MySQL, REST APIs, Git', 'fa-layer-group', 12, 'Performance based', 10, 1),

('Frontend Development', 'frontend-development',
 'Turn designs into responsive, accessible interfaces that hold up on real devices.',
 'Focus on the layer users actually touch. You will convert designs into semantic markup, build responsive layouts that survive real screen sizes, manage component state, and handle loading and error conditions properly. Includes accessibility fundamentals, cross-browser testing and measurable performance work.',
 'HTML, CSS, JavaScript, React, Responsive Design, Accessibility, Git', 'fa-code', 8, 'Performance based', 12, 2),

('Backend Development', 'backend-development',
 'Design the APIs, data models and server logic that everything else depends on.',
 'Build the engine behind the product. You will model data, write and optimise SQL, design REST endpoints with sane status codes, implement authentication and authorisation, and learn to validate every untrusted input. Covers transactions, error handling, logging and protection against injection and broken access control.',
 'PHP or Node.js, MySQL, REST API Design, Authentication, Caching, Git', 'fa-server', 10, 'Performance based', 10, 3),

('Python Development', 'python-development',
 'Write practical Python for automation, data handling and backend services.',
 'Use Python on real problems rather than exercises. You will build command line tools, automate repetitive workflows, work with files and external APIs, and construct a small web service. Covers virtual environments, dependency management, structured error handling and writing tests for your own code.',
 'Python, Flask or Django, Pandas, REST APIs, SQL, Git', 'fa-python', 8, 'Performance based', 12, 4),

('Java Development', 'java-development',
 'Learn object-oriented engineering and the JVM ecosystem on real assignments.',
 'Apply object-oriented design to working software. You will practise classes and interfaces, collections, exception handling and file and database access through JDBC, then build a layered application with a service and data layer. Introduces Spring Boot, Maven and unit testing with JUnit.',
 'Java, OOP, Collections, JDBC, Spring Boot, Maven, JUnit', 'fa-java', 10, 'Performance based', 10, 5),

('Mobile App Development', 'mobile-app-development',
 'Ship a cross-platform mobile app from first screen to installable build.',
 'Build for phones, including the constraints that come with them. You will construct multi-screen navigation, manage app state, store data locally, consume remote APIs and handle offline and error conditions. Ends with a real device build and a walkthrough of the store submission process.',
 'Flutter or React Native, Dart or JavaScript, REST APIs, Local Storage, Git', 'fa-mobile-screen', 12, 'Performance based', 8, 6),

('UI/UX Design', 'ui-ux-design',
 'Research, wireframe and prototype interfaces, then validate them with users.',
 'Design with evidence rather than taste alone. You will run lightweight user research, map flows, produce wireframes and high-fidelity screens, and assemble a reusable component library with consistent type and spacing. Includes prototyping, usability testing and preparing clean handoff specifications for developers.',
 'Figma, Wireframing, Prototyping, Design Systems, User Research, Accessibility', 'fa-pen-ruler', 8, 'Performance based', 10, 7),

('Cybersecurity', 'cybersecurity',
 'Find, exploit and then correctly fix real vulnerabilities in a safe lab.',
 'Learn offence in order to build better defence, entirely within an authorised lab environment. You will work through the OWASP Top 10 hands-on, covering injection, broken authentication, access control failures and insecure file upload, then write remediation reports with severity ratings. Also covers secure code review and basic network reconnaissance.',
 'OWASP Top 10, Burp Suite, Nmap, Secure Code Review, Linux, Reporting', 'fa-shield-halved', 10, 'Performance based', 8, 8),

('Internet of Things (IoT)', 'internet-of-things',
 'Connect sensors and microcontrollers to dashboards that show live data.',
 'Bridge hardware and software. You will wire sensors to a microcontroller, read and calibrate their output, publish readings over MQTT or HTTP, and store the results in a time-series structure. Finishes with a live dashboard and alerting so the data drives an actual decision.',
 'Arduino or ESP32, C/C++, Sensors, MQTT, Python, Data Visualisation', 'fa-microchip', 10, 'Performance based', 8, 9),

('AI & Machine Learning', 'ai-and-machine-learning',
 'Train, evaluate and deploy models, with honest attention to their limits.',
 'Go past calling a library blindly. You will frame a problem, clean and split data, engineer features, then train and properly evaluate models using the right metric for the task. Covers overfitting, validation strategy, model interpretation and serving a trained model behind a simple API.',
 'Python, NumPy, Pandas, scikit-learn, Model Evaluation, Feature Engineering', 'fa-brain', 12, 'Performance based', 8, 10),

('Data Science', 'data-science',
 'Take messy raw data through to an analysis someone can act on.',
 'Own the full analytical path. You will source and clean untidy real data, explore it for genuine signal, apply statistics correctly, and communicate findings in clear visualisations and written conclusions. Heavy emphasis on SQL, reproducible notebooks and not overstating what the data supports.',
 'Python, SQL, Pandas, Matplotlib, Statistics, Data Cleaning, Visualisation', 'fa-chart-line', 10, 'Performance based', 10, 11)
ON DUPLICATE KEY UPDATE
    `short_desc`     = VALUES(`short_desc`),
    `description`    = VALUES(`description`),
    `skills`         = VALUES(`skills`),
    `icon`           = VALUES(`icon`),
    `duration_weeks` = VALUES(`duration_weeks`),
    `sort_order`     = VALUES(`sort_order`);

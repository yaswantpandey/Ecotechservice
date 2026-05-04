-- ============================================================
-- Blog Posts Migration — Run this if blog_posts table
-- does not exist in your ecotech_service database yet.
-- ============================================================

USE `ecotech_service`;

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`      INT UNSIGNED NOT NULL,
  `title`        VARCHAR(200) NOT NULL,
  `slug`         VARCHAR(210) NOT NULL UNIQUE,
  `excerpt`      TEXT         DEFAULT NULL,
  `body`         LONGTEXT     NOT NULL,
  `thumbnail`    VARCHAR(255) DEFAULT NULL,
  `is_published` TINYINT(1)   NOT NULL DEFAULT 0,
  `published_at` TIMESTAMP    NULL     DEFAULT NULL,
  `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_bp_slug`  (`slug`),
  INDEX `idx_bp_user`  (`user_id`),
  CONSTRAINT `fk_bp_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS wishes (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug CHAR(16) NOT NULL,
  occasion VARCHAR(30) NOT NULL,
  recipient VARCHAR(80) NOT NULL,
  sender VARCHAR(80) NOT NULL DEFAULT '',
  message TEXT NOT NULL,
  theme VARCHAR(20) NOT NULL DEFAULT 'rose',
  lang CHAR(2) NOT NULL DEFAULT 'bn',
  music_hint TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY unique_slug (slug),
  KEY created_at_idx (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

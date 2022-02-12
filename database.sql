DROP DATABASE IF EXISTS inlinedb;
CREATE DATABASE IF NOT EXISTS inlinedb;
USE inlinedb;

DROP TABLE IF EXISTS posts;
CREATE TABLE IF NOT EXISTS posts(
	id int unsigned NOT NULL,
    user_id int unsigned NOT NULL,
    title varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    body text COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY(id)
) ENGINE=INNODB COMMENT='Posts' 
	DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS comments;
CREATE TABLE IF NOT EXISTS comments(
    id int unsigned NOT NULL,
    post_id int unsigned NOT NULL,
    name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    body text COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(post_id) REFERENCES posts(id) ON DELETE CASCADE
)ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
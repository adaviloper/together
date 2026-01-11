CREATE DATABASE IF NOT EXISTS `together` DEFAULT CHARACTER SET = `utf8mb4` DEFAULT COLLATE = `utf8mb4_unicode_ci`;
CREATE DATABASE IF NOT EXISTS `together_testing` DEFAULT CHARACTER SET = `utf8mb4` DEFAULT COLLATE = `utf8mb4_unicode_ci`;

GRANT ALL ON *.* TO 'laravel'@'%';

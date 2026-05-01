<?php

require_once __DIR__ . '/db_connect.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function auth_is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}

function auth_current_user_name(): string
{
    if (!auth_is_logged_in()) {
        return '';
    }

    return (string) ($_SESSION['user_name'] ?? $_SESSION['user_email'] ?? 'User');
}

function auth_login_user(array $user): void
{
    session_regenerate_id(true);

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['user_name'] = (string) $user['name'];
    $_SESSION['user_email'] = (string) $user['email'];
    $_SESSION['user_role'] = (string) ($user['role'] ?? 'user');
}

function auth_logout_user(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $cookieParams = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 3600,
            $cookieParams['path'],
            $cookieParams['domain'],
            $cookieParams['secure'],
            $cookieParams['httponly']
        );
    }

    session_destroy();
}

function auth_redirect_if_logged_in(string $target = 'index.php'): void
{
    if (auth_is_logged_in()) {
        header('Location: ' . $target);
        exit;
    }
}

function auth_ensure_users_table(mysqli $conn): bool
{
    $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'users'");

    if ($tableCheck === false) {
        return false;
    }

    if (mysqli_num_rows($tableCheck) > 0) {
        mysqli_free_result($tableCheck);
        return true;
    }

    mysqli_free_result($tableCheck);

    $createSql = <<<'SQL'
CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) NOT NULL DEFAULT 'admin',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL;

    if (!mysqli_query($conn, $createSql)) {
        return false;
    }

    $seedSql = <<<'SQL'
INSERT INTO `users` (`name`, `email`, `password_hash`, `role`, `is_active`)
VALUES ('Admin User', 'admin@safar.com', '$2y$10$jIbvg9V3.t7JUuPPC5GEHulJTRX7V888WRvmS246L4jzPtKR.0uVW', 'admin', 1)
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`)
SQL;

    return mysqli_query($conn, $seedSql);
}

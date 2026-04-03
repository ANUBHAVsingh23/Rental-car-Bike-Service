<?php
/*
 * Centralized MySQL connection for the project.
 * Update these values once and all pages using this file will pick them up.
 */

if (!function_exists('get_db_connection')) {
    function get_db_connection()
    {
        $servername = getenv('DB_HOST') ?: 'localhost';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASS') ?: '';
        $dbname = getenv('DB_NAME') ?: 'booking';

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            return false;
        }

        mysqli_set_charset($conn, 'utf8mb4');
        return $conn;
    }
}

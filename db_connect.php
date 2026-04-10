<?php
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

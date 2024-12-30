<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'php_practice';

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        echo "<script>alert('Connection Error');</script>";
    }
?>
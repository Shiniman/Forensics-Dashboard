<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $db = new PDO('sqlite:database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    );");

    $db->exec("CREATE TABLE IF NOT EXISTS cases (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        case_id TEXT UNIQUE NOT NULL,
        case_password TEXT NOT NULL
    );");

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
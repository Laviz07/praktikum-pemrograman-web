<?php
// Menggunakan __DIR__ agar path config.php selalu tepat dari mana pun file ini di-include
require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login_Un51k4'])) {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}
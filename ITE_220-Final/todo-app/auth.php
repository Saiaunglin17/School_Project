<?php
if (session_status() === PHP_SESSION_NONE) session_start();
function require_login() {
  if (!isset($_SESSION['user'])) {
    header('Location: /todo-app/login.php');
    exit;
  }
}

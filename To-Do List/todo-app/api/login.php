<?php
declare(strict_types=1);
require __DIR__ . '/../auth.php';
require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /todo-app/login.php'); exit;
}

$email = trim($_POST['email'] ?? '');
$pass  = (string)($_POST['password'] ?? '');
$remember = isset($_POST['remember']);

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$u = $stmt->fetch();

if ($u && password_verify($pass, $u['password_hash'])) {
  $_SESSION['user'] = ['id'=>(int)$u['id'], 'name'=>$u['name'], 'email'=>$u['email']];
  if ($remember) setcookie('remember_email', $email, time() + 60*60*24*30, '/');
  else setcookie('remember_email', '', time() - 3600, '/');
  header('Location: /todo-app/index.php'); exit;
}

header('Location: /todo-app/login.php'); exit;

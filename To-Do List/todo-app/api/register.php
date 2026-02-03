<?php
declare(strict_types=1);
require __DIR__ . '/../auth.php';
require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /todo-app/register.php'); exit;
}

$name  = trim($_POST['name']  ?? '');
$email = trim($_POST['email'] ?? '');
$pass  = (string)($_POST['password'] ?? '');

if ($name === '' || $email === '' || $pass === '') {
  header('Location: /todo-app/register.php'); exit;
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

try {
  $stmt = $pdo->prepare('INSERT INTO users(name,email,password_hash) VALUES(?,?,?)');
  $stmt->execute([$name, $email, $hash]);
  $_SESSION['user'] = ['id'=>(int)$pdo->lastInsertId(), 'name'=>$name, 'email'=>$email];
  header('Location: /todo-app/index.php'); exit;
} catch (Throwable $e) {
  header('Location: /todo-app/register.php'); exit;
}

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$theme = $_COOKIE['theme'] ?? 'light';
?>
<!doctype html>
<html lang="en" data-bs-theme="<?= htmlspecialchars($theme) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>To-Do App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/todo-app/assets/app.css" rel="stylesheet">
</head>
<body class="bg-body">
<?php include __DIR__ . '/nav.php'; ?>
<div class="container py-4">

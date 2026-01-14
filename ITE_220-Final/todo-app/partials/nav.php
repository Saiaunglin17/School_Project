<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg bg-body border-bottom">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/todo-app/index.php">To-Do</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="/todo-app/index.php">Tasks</a></li>
          <li class="nav-item"><a class="nav-link" href="/todo-app/profile.php">Profile</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="/todo-app/contact.php">Contact</a></li>
      </ul>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-secondary btn-sm" id="themeToggle">Toggle Theme</button>
        <?php if (isset($_SESSION['user'])): ?>
          <a class="btn btn-danger btn-sm" href="/todo-app/api/logout.php">Logout</a>
        <?php else: ?>
          <a class="btn btn-outline-primary btn-sm" href="/todo-app/login.php">Login</a>
          <a class="btn btn-primary btn-sm" href="/todo-app/register.php">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$remembered = $_COOKIE['remember_email'] ?? '';
include __DIR__ . '/partials/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">Login</h3>
        <form action="/todo-app/api/login.php" method="post" class="needs-validation" novalidate>
          <div class="mb-2">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required value="<?= htmlspecialchars($remembered) ?>">
            <div class="invalid-feedback">Valid email is required.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required>
            <div class="invalid-feedback">Password is required.</div>
          </div>
          <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember" <?= $remembered ? 'checked' : '' ?>>
            <label for="remember" class="form-check-label">Remember my email</label>
          </div>
          <button class="btn btn-primary w-100">Login</button>
          <p class="mt-3 mb-0">No account? <a href="/todo-app/register.php">Register</a></p>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
(() => {
  const form = document.querySelector('form');
  form.addEventListener('submit', (e) => {
    if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
    form.classList.add('was-validated');
  });
})();
</script>
<?php include __DIR__ . '/partials/footer.php'; ?>

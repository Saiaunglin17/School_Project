<?php
include __DIR__ . '/partials/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">Create Account</h3>
        <form action="/todo-app/api/register.php" method="post" class="needs-validation" novalidate>
          <div class="mb-2">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" required>
            <div class="invalid-feedback">Name is required.</div>
          </div>
          <div class="mb-2">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" type="email" required>
            <div class="invalid-feedback">Valid email is required.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" name="password" type="password" minlength="6" required>
            <div class="invalid-feedback">At least 6 characters.</div>
          </div>
          <button class="btn btn-primary w-100">Register</button>
          <p class="mt-3 mb-0">Already have an account? <a href="/todo-app/login.php">Login</a></p>
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

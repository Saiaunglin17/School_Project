<?php
require __DIR__ . '/auth.php';
require_login();
include __DIR__ . '/partials/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-3">Profile</h4>
        <p>Name: <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong></p>
        <p>Email: <strong><?= htmlspecialchars($_SESSION['user']['email']) ?></strong></p>
        <hr>
        <h5>Theme Preference</h5>
        <p>Click <em>Toggle Theme</em> in the navbar. Your choice is saved to a <code>theme</code> cookie for 30 days.</p>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>

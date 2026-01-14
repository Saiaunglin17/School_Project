<?php
include __DIR__ . '/partials/header.php';
?>
<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4>Contact Us</h4>
        <p class="text-muted">Submit your feedback or questions. Stored in database.</p>
        <form id="contactForm" class="needs-validation" novalidate>
          <div class="mb-2">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" required>
            <div class="invalid-feedback">Name required.</div>
          </div>
          <div class="mb-2">
            <label class="form-label">Email</label>
            <input class="form-control" name="email" type="email" required>
            <div class="invalid-feedback">Valid email required.</div>
          </div>
          <div class="mb-2">
            <label class="form-label">Subject</label>
            <input class="form-control" name="subject" required>
            <div class="invalid-feedback">Subject required.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea class="form-control" name="message" rows="4" required></textarea>
            <div class="invalid-feedback">Message required.</div>
          </div>
          <button class="btn btn-primary">Send</button>
          <div id="contactAlert" class="alert mt-3 d-none"></div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
(() => {
  const form = document.getElementById('contactForm');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!form.checkValidity()) { form.classList.add('was-validated'); return; }

    const data = Object.fromEntries(new FormData(form).entries());
    const res = await fetch('/todo-app/api/contact_submit.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify(data)
    });
    const json = await res.json();

    const alertBox = document.getElementById('contactAlert');
    alertBox.classList.remove('d-none','alert-success','alert-danger');

    if (json.ok) {
      alertBox.classList.add('alert','alert-success');
      alertBox.textContent = 'Message sent. Thank you!';
      form.reset();
      form.classList.remove('was-validated');
    } else {
      alertBox.classList.add('alert','alert-danger');
      alertBox.textContent = 'Something went wrong.';
    }
  });
})();
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>

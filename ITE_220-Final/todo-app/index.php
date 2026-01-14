<?php
require __DIR__ . '/auth.php';
require_login();
require __DIR__ . '/db.php';
include __DIR__ . '/partials/header.php';

$user_id = (int)$_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-3">Your Tasks</h4>

        <!-- Add Task (handled by assets/app.js) -->
        <form id="taskForm" class="row g-2 mb-3">
          <div class="col-12 col-md-6">
            <input class="form-control" name="title" placeholder="Add a task..." required>
          </div>
          <div class="col-6 col-md-3">
            <select class="form-select" name="priority">
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>
          <div class="col-6 col-md-3">
            <input type="date" class="form-control" name="due_date">
          </div>
          <div class="col-12">
            <button class="btn btn-primary w-100">Add Task</button>
          </div>
        </form>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('taskForm');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(form).entries());
    if (!data.title || !data.title.trim()) {
      alert('Please enter a task title.');
      return;
    }

    try {
      // ✅ Use RELATIVE path so it works no matter the folder name
      const res = await fetch('api/task_add.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify(data)
      });

      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')) {
        // Probably got redirected to login (HTML). Handle it gracefully.
        alert('Your session may have expired. Please log in again.');
        window.location.href = 'login.php';
        return;
      }

      const json = await res.json();
      if (res.ok && json.ok) {
        // Add the new task without reloading (optional UX improvement)
        // location.reload(); // fallback
        window.location.reload();
      } else {
        alert('Add failed: ' + (json.error || 'unknown'));
      }
    } catch (err) {
      console.error(err);
      alert('Network/server error while adding task.');
    }
  });
});
<script>
document.addEventListener('DOMContentLoaded', () => {

  // --- Delete Task (robust) ---
  document.body.addEventListener('click', async (e) => {
    const btn = e.target.closest('button.deleteBtn');   // catch nested clicks
    if (!btn) return;

    const li = btn.closest('li');
    if (!li) return;
    const id = li.dataset.id;

    if (!confirm('Delete this task?')) return;

    try {
      // Use RELATIVE path so it works regardless of folder name
      const res = await fetch('api/task_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ id })
      });

      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')) {
        alert('Session expired. Please log in again.');
        location.href = 'login.php';
        return;
      }

      const json = await res.json();
      if (res.ok && json.ok) {
        li.remove(); // instant feedback
      } else {
        alert('Delete failed: ' + (json.error || 'unknown'));
      }
    } catch (err) {
      console.error(err);
      alert('Network/server error while deleting task.');
    }
  });

});
</script>

</script>

                <!-- Task List -->
        <ul id="taskList" class="list-group">
          <?php foreach ($tasks as $t): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center"
                data-id="<?= (int)$t['id'] ?>">
              <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary toggleBtn">
                  <?= $t['is_done'] ? '✅' : '⬜️' ?>
                </button>
                <div>
                  <div class="<?= $t['is_done'] ? 'text-decoration-line-through text-muted' : '' ?>">
                    <?= htmlspecialchars($t['title']) ?>
                  </div>
                  <small class="text-muted">
                    Priority: <?= htmlspecialchars($t['priority']) ?>
                    <?php if ($t['due_date']) echo ' • Due: ' . htmlspecialchars($t['due_date']); ?>
                  </small>
                </div>
              </div>
              <button type="button" class="btn btn-sm btn-outline-danger deleteBtn">Delete</button>
            </li>
          <?php endforeach; ?>
          <?php if (!$tasks): ?>
            <li class="list-group-item text-muted">No tasks yet.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- ✅ All JavaScript combined and placed here -->
<script>
document.addEventListener('DOMContentLoaded', () => {

  // --- ADD TASK ---
  const form = document.getElementById('taskForm');
  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const data = Object.fromEntries(new FormData(form).entries());
      if (!data.title || !data.title.trim()) {
        alert('Please enter a task title.');
        return;
      }

      try {
        const res = await fetch('api/task_add.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          credentials: 'same-origin',
          body: JSON.stringify(data)
        });

        const ct = res.headers.get('content-type') || '';
        if (!ct.includes('application/json')) {
          alert('Your session may have expired. Please log in again.');
          window.location.href = 'login.php';
          return;
        }

        const json = await res.json();
        if (res.ok && json.ok) {
          window.location.reload();
        } else {
          alert('Add failed: ' + (json.error || 'unknown'));
        }
      } catch (err) {
        console.error(err);
        alert('Network/server error while adding task.');
      }
    });
  }

  // --- DELETE TASK ---
  document.body.addEventListener('click', async (e) => {
    const btn = e.target.closest('button.deleteBtn');
    if (!btn) return;

    const li = btn.closest('li');
    if (!li) return;

    const id = li.dataset.id;
    if (!id) { alert('Missing task id'); return; }

    if (!confirm('Delete this task?')) return;

    try {
      const res = await fetch('api/task_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ id })
      });

      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')) {
        alert('Session expired. Please log in again.');
        location.href = 'login.php';
        return;
      }

      const text = await res.text();
      let json = {};
      try { json = JSON.parse(text); } catch {}
      console.log('DELETE status:', res.status, 'response:', text);

      if (res.ok && json.ok) {
        li.remove();
      } else {
        alert('Delete failed: ' + (json.error || 'unknown'));
      }
    } catch (err) {
      console.error(err);
      alert('Network/server error while deleting task.');
    }
  });

});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>

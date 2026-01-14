// ============================
// Light/Dark Theme Toggle
// ============================

// Read current theme from cookie (so it loads correctly on refresh)
function getCookie(name) {
  const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
  return match ? match[2] : null;
}

// Apply saved theme on load
document.addEventListener('DOMContentLoaded', () => {
  const savedTheme = getCookie('theme') || 'light';
  document.documentElement.setAttribute('data-bs-theme', savedTheme);
});
// --- Add Task ---
document.addEventListener('DOMContentLoaded', () => {
  const taskForm = document.getElementById('taskForm');
  if (!taskForm) return;

  taskForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(taskForm).entries());
    if (!data.title || !data.title.trim()) {
      alert('Please enter a task title.');
      return;
    }

    try {
      const res = await fetch('/todo-app/api/task_add.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify(data)
      });

      // If you’re not logged in, PHP will redirect to login.php (HTML, not JSON)
      const contentType = res.headers.get('content-type') || '';
      if (!contentType.includes('application/json')) {
        alert('Your session might have expired. Please log in again.');
        window.location.href = '/todo-app/login.php';
        return;
      }

      const json = await res.json();
      if (res.ok && json.ok) {
        // Refresh to show the new task
        location.reload();
      } else {
        alert('Failed to add task: ' + (json.error || 'unknown'));
      }
    } catch (err) {
      console.error(err);
      alert('Network error while adding task.');
    }
  });
});


// Toggle theme when button clicked
document.addEventListener('click', (e) => {
  if (e.target && e.target.id === 'themeToggle') {
    const html = document.documentElement;
    const current = html.getAttribute('data-bs-theme') || 'light';
    const next = current === 'light' ? 'dark' : 'light';
    html.setAttribute('data-bs-theme', next);

    // Save preference to cookie for 30 days
    const expires = new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toUTCString();
    document.cookie = `theme=${next}; path=/; expires=${expires}`;

    console.log(`Theme switched to: ${next}`);
  }
});


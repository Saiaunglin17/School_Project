<?php
declare(strict_types=1);

require __DIR__ . '/../auth.php';
require_login();                       // must be logged in (redirects if not)
require __DIR__ . '/../db.php';

header('Content-Type: application/json');

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
  }

  // Support BOTH JSON and form-encoded bodies
  $ctype = $_SERVER['CONTENT_TYPE'] ?? '';
  if (stripos($ctype, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
  } else {
    // Fallback to form-encoded
    $input = $_POST;
  }

  if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'bad_body']);
    exit;
  }

  $title    = isset($input['title']) ? trim((string)$input['title']) : '';
  $priority = isset($input['priority']) ? (string)$input['priority'] : 'low';
  $due_date = isset($input['due_date']) && $input['due_date'] !== '' ? (string)$input['due_date'] : null;

  if ($title === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'title_required']);
    exit;
  }

  $stmt = $pdo->prepare(
    'INSERT INTO tasks (user_id, title, priority, due_date)
     VALUES (?, ?, ?, ?)'
  );
  $stmt->execute([$_SESSION['user']['id'], $title, $priority, $due_date]);

  echo json_encode(['ok' => true, 'id' => (int)$pdo->lastInsertId()]);
  exit;

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'server_error']);
  exit;
}

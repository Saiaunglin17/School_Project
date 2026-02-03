<?php
declare(strict_types=1);

require __DIR__ . '/../auth.php'; // session started inside auth.php if you follow our setup
require __DIR__ . '/../db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
  exit;
}

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);

// Guard: invalid JSON
if (!is_array($input)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'bad_json']);
  exit;
}

$name    = isset($input['name'])    ? trim((string)$input['name'])    : '';
$email   = isset($input['email'])   ? trim((string)$input['email'])   : '';
$subject = isset($input['subject']) ? trim((string)$input['subject']) : '';
$message = isset($input['message']) ? trim((string)$input['message']) : '';

// Basic validation
if ($name === '' || $email === '' || $subject === '' || $message === '') {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'validation_failed']);
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'invalid_email']);
  exit;
}

// Safe nested session access
$userId = (isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : null);

try {
  $stmt = $pdo->prepare(
    'INSERT INTO messages(user_id, name, email, subject, message)
     VALUES (?, ?, ?, ?, ?)'
  );
  $stmt->execute([$userId, $name, $email, $subject, $message]);

  echo json_encode(['ok' => true]);
  exit;

} catch (Throwable $e) {
  // For production, don’t expose $e->getMessage()
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'server_error']);
  exit;
}

<?php
declare(strict_types=1);

require __DIR__ . '/../auth.php';
require_login();
require __DIR__ . '/../db.php';

header('Content-Type: application/json');

// Turn on during debugging (remove before submitting)
error_reporting(E_ALL); ini_set('display_errors', '1');

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']); exit;
  }

  // Accept JSON *or* form-encoded
  $ctype = $_SERVER['CONTENT_TYPE'] ?? '';
  if (stripos($ctype, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
  } else {
    $input = $_POST;
  }

  $id = isset($input['id']) ? (int)$input['id'] : 0;
  if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'bad_id']); exit;
  }

  $userId = (int)$_SESSION['user']['id'];

  // Delete only if it belongs to the logged-in user
  $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
  $stmt->execute([$id, $userId]);

  if ($stmt->rowCount() > 0) {
    echo json_encode(['ok' => true]); exit;
  }

  // Helpful error so you know what happened
  http_response_code(404);
  echo json_encode(['ok' => false, 'error' => 'not_found_or_not_owned']); exit;

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'server_error']); exit;
}

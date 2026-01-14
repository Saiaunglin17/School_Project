<?php
declare(strict_types=1);
require __DIR__ . '/../auth.php';
require_login();
require __DIR__ . '/../db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['ok'=>false,'error'=>'method_not_allowed']); exit; }

$input = json_decode(file_get_contents('php://input'), true);
$id = isset($input['id']) ? (int)$input['id'] : 0;
if ($id <= 0) { echo json_encode(['ok'=>false,'error'=>'bad_id']); exit; }

$stmt = $pdo->prepare('UPDATE tasks SET is_done = 1 - is_done WHERE id = ? AND user_id = ?');
$stmt->execute([$id, $_SESSION['user']['id']]);

echo json_encode(['ok'=>$stmt->rowCount() > 0]);

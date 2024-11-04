<?php
require 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM houses WHERE id = :id');
$stmt->execute(['id' => $id]);
$house = $stmt->fetch(PDO::FETCH_ASSOC);

if ($house) {
    echo json_encode($house);
} else {
    echo json_encode(['error' => 'House not found']);
}
?>

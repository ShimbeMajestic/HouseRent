<?php
require 'db.php';

$stmt = $pdo->query('SELECT * FROM houses');
$houses = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($houses);
?>

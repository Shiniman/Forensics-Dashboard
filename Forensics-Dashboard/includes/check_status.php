<?php
/**
 * check_status.php
 * Polling endpoint — returns JSON parse status for the latest Wireshark
 * evidence file belonging to the active case.
 *
 * Response: { "status": "pending|processing|done|error|none", "artifact_count": N }
 */
require '../db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['case_id'])) {
    echo json_encode(['status' => 'none', 'artifact_count' => 0]);
    exit;
}

$case_id = $_SESSION['case_id'];

$stmt = $db->prepare(
    "SELECT parse_status, artifact_count
     FROM evidence
     WHERE case_id = ? AND source_program = 'Wireshark'
     ORDER BY upload_date DESC LIMIT 1"
);
$stmt->execute([$case_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(['status' => 'none', 'artifact_count' => 0]);
} else {
    echo json_encode([
        'status'         => $row['parse_status']   ?? 'pending',
        'artifact_count' => (int)($row['artifact_count'] ?? 0),
    ]);
}
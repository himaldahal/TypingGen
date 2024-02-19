<?php
include '../includes/config.php';
if(!isset($_SESSION['user_id'])){
    header('Location: /auth/login.php');
    exit;
}
$userId = $_SESSION['user_id'];
function addRecord($conn, $userId, $wpm, $cpm, $mistakes)
{
    $query = "INSERT INTO records (user_id, wpm, cpm, mistakes) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'iiii', $userId, $wpm, $cpm, $mistakes);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($userId !== null) {
        $wpm = $_POST['wpm'];
        $cpm = $_POST['cpm'];
        $mistakes = $_POST['mistakes'];

        addRecord($conn, $userId, $wpm, $cpm, $mistakes);
        echo json_encode(['status' => 'success', 'message' => 'Record added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Authentication failed']);
      }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unsupported request method']);
    }


?>

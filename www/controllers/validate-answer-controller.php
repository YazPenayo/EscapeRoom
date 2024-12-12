<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');

date_default_timezone_set('America/Argentina/Buenos_Aires');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_option']) && isset($_POST['question_id'])) {
    $selectedOption = $_POST['selected_option'];
    $questionId = $_POST['question_id'];
    $playerId = $_SESSION['id_player'];
    $roomId = $_SESSION['selected_room'];

    $stmt = $conn->prepare(SQL_GET_CORRECT_ANSWER);
    $stmt->bind_param('ii', $selectedOption, $questionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $isCorrect = $row['is_correct'];

        $insertStmt = $conn->prepare(SQL_INSERT_ANSWER);
        $currentTimestamp = date('Y-m-d H:i:s');
        $insertStmt->bind_param('isiiii', $isCorrect, $currentTimestamp, $playerId, $questionId, $selectedOption, $roomId);
        $insertStmt->execute();
        $insertStmt->close();

        // Responder con el estado de la respuesta
        echo json_encode(['correct' => $isCorrect == 1]);
    } else {
        echo json_encode(['correct' => false]);
    }

    $stmt->close();
}
?>

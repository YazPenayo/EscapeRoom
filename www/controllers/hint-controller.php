<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_player = $_SESSION['id_player'];
    $id_room = $_SESSION['selected_room'];
    $id_question = $_POST['id_question'];

    if (!$id_player || !$id_room || !$id_question) {
        echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
        exit;
    }

    // Verificar si ya se usó una pista en esta habitación por este jugador
    $stmt_check = $conn->prepare(SQL_CHECK_USED_HINT);
    $stmt_check->bind_param('ii', $id_player, $id_room);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        if ($row['used_hint'] == 1) {
            echo json_encode(['success' => false, 'error' => 'Ya revelaste tu pista en esta habitación.']);
            exit;
        }
    }

    // Registrar que se usó una pista en esta habitación
    $stmt_update = $conn->prepare(SQL_INSERT_USED_HINT);
    $stmt_update->bind_param('iii', $id_player, $id_room, $id_question); // Asegurando que todos los parámetros sean enviados correctamente

    if ($stmt_update->execute()) {
        // Obtener el texto de la pista
        $stmt_hint = $conn->prepare(SQL_SELECT_HINT);
        $stmt_hint->bind_param('i', $id_question);
        $stmt_hint->execute();
        $result_hint = $stmt_hint->get_result();

        if ($result_hint->num_rows > 0) {
            $hint = $result_hint->fetch_assoc()['hint'];
            echo json_encode(['success' => true, 'hint' => $hint]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se encontró la pista asociada a esta pregunta.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al registrar el uso de la pista.']);
    }
}


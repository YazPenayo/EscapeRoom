<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');
date_default_timezone_set('America/Argentina/Buenos_Aires');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_player = $_SESSION['id_player'];
    $id_room = $_SESSION['selected_room'];
    $id_question = $_POST['id_question'];
    $correct = $_POST['correct'];
    $currentDate = date('Y-m-d H:i:s');

    if (!$id_player || !$id_room || !$id_question) {
        echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
        exit;
    }

    $stmt_update = $conn->prepare(SQL_INSERT_PROGRESS);
    $stmt_update->bind_param(
        'iiiiss', 
        $id_player, 
        $id_room, 
        $id_question, 
        $correct, 
        $currentDate, 
        $currentDate
    );

    if ($stmt_update->execute()) {
        echo json_encode(['success' => true, 'message' => 'Progreso registrado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al registrar el progreso.']);
    }
}


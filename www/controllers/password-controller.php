<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');

$response = array(); // Array para guardar la respuesta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_id = $_SESSION['id_player'];
    $password_last = $_POST['password_last'];
    $password_new = $_POST['password_new'];
    $password_confirm = $_POST['confirm-password'];

    // Verificar que las contraseñas coincidan
    if ($password_new !== $password_confirm) {
        $response['error'] = "Las contraseñas nuevas no coinciden.";
        echo json_encode($response);
        exit();
    }

    // Verificar la contraseña actual
    $stmt = $conn->prepare(SQL_SELECT_PASSWORD);
    if ($stmt === false) {
        $response['error'] = 'Error en la preparación de la declaración: ' . htmlspecialchars($conn->error);
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("i", $player_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row || !password_verify($password_last, $row['password'])) {
        $response['error'] = "La contraseña actual es incorrecta.";
        echo json_encode($response);
        exit();
    }

    // Actualizar la contraseña
    $hashed_password = password_hash($password_new, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(SQL_UPDATE_PASSWORD);
    if ($stmt === false) {
        $response['error'] = 'Error en la preparación de la declaración: ' . htmlspecialchars($conn->error);
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("sis", $hashed_password, $player_id, $row['password']); 

    if ($stmt->execute()) {
        $response['success'] = "Contraseña actualizada exitosamente.";
        echo json_encode($response);
        exit();
    } else {
        $response['error'] = "Error al actualizar la contraseña: " . htmlspecialchars($stmt->error);
        echo json_encode($response);
        exit();
    }

    $stmt->close();
}

<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['input'];
    $password = $_POST['password'];

    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $sql = SQL_LOGIN_PLAYERS;
        $param1 = $input;
        $param2 = $input;
    } else {
        $sql = SQL_LOGIN_PLAYERS;
        $param1 = $input;
        $param2 = $input;
    }

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $param1, $param2);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verificamos la contraseña
            if (password_verify($password, $user['password'])) {
                $_SESSION['name_player'] = $user['name_player'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['id_player'] = $user['id_player'];
                $_SESSION['is_login'] = true;

                if (isset($_SESSION['selected_room'])) {
                    $room_id = $_SESSION['selected_room'];
                    unset($_SESSION['selected_room']);
                    echo json_encode(['success' => true, 'redirect' => "../views/trivia.php?id_room=$room_id"]);
                    exit;
                } else {
                    echo json_encode(['success' => true, 'redirect' => "../views/rooms.php"]);
                    exit;
                }
                
            } else {
                echo json_encode(['success' => false, 'error' => 'Contraseña incorrecta.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta.']);
        exit;
    }
}
?>


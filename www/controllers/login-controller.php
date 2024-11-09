<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST['input'];
    $password = $_POST['password'];

    // Determinar si es un email o un username y preparar la consulta
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        // Si el valor ingresado parece un email, usamos el email en la consulta
        $sql = SQL_LOGIN_PLAYERS;
        $param1 = $input;  // Email
        $param2 = $input;  // Email también
    } else {
        // Si no es un email, asumimos que es un username
        $sql = SQL_LOGIN_PLAYERS;
        $param1 = $input;  // Username
        $param2 = $input;  // Username también
    }

    // Preparamos la consulta SQL
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $param1, $param2);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificamos si encontramos un usuario
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verificamos la contraseña
            if (password_verify($password, $user['password'])) {
                // Si la contraseña es correcta, iniciamos sesión
                $_SESSION['user_name'] = $user['name_player'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['id_player'] = $user['id_player'];

                // Redirigimos al index.php o a la página que prefieras
                header("Location: ../views/menu.php");
                exit;
            } else {
                // Si la contraseña es incorrecta
                $_SESSION['error'] = "Contraseña incorrecta.";
            }
        } else {
            // Si no se encuentra el usuario
            $_SESSION['error'] = "Usuario no encontrado.";
        }
    } else {
        // Si hubo un error al preparar la consulta
        $_SESSION['error'] = "Error al preparar la consulta.";
    }
    // Redirigimos al login con mensaje de error
    header("Location: ../index.php");  // Cambié esto a index.php
    exit;
}

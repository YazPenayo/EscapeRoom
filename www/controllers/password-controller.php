<?php
session_start();
include('../models/dbConnection.php');
include('../querys/querys.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $player_id = $_SESSION['id_player'];
    $password_last = $_POST['password_last'];
    $password_new = $_POST['password_new'];
    $password_confirm = $_POST['confirm-password'];

    if ($password_new !== $password_confirm) {
        die("Las contraseñas nuevas no coinciden.");//agregar en las alertas
    }

    $stmt = $conn->prepare(SQL_SELECT_PASSWORD);
    if ($stmt === false) {
        die('Error en la preparación de la declaración: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $player_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row || !password_verify($password_last, $row['password'])) {
        die("La contraseña actual es incorrecta.");
    }

    $hashed_password = password_hash($password_new, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(SQL_UPDATE_PASSWORD);
    if ($stmt === false) {
        die('Error en la preparación de la declaración: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("sis", $hashed_password, $player_id, $row['password']); 

    if ($stmt->execute()) {
        header("Location: ../views/settings.php");
        exit();
    } else {
        die("Error al actualizar la contraseña: " . htmlspecialchars($stmt->error));
    }
    $stmt->close();
}
?>

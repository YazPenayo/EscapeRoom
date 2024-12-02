<?php
include('../models/dbConnection.php');
include('../querys/querys.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $player_id = $_POST['id_player']; 
    $name_player = ucfirst(trim($_POST['name_player']));
    $lastname_player = ucfirst(trim($_POST['lastname_player']));
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    
    $stmt = $conn->prepare(SQL_UPDATE_PLAYER);
    $stmt->bind_param("sssss", $name_player, $lastname_player, $username, $email, $player_id);
    if ($stmt === false) {
        die('Error en la preparación de la declaración: ' . htmlspecialchars($conn->error));
    }

    if ($stmt->execute()) {
        header("Location: ../views/settings.php");
        exit();
    } else {
        die("Error al actualizar el jugador: " . htmlspecialchars($stmt->error));
    }
    $stmt->close();
}
?>

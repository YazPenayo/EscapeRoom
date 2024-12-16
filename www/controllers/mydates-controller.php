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
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la declaración']);
        exit();
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);  // Devuelve un éxito
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el jugador']);
    }
    $stmt->close();
}
?>

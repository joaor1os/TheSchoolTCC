<?php
session_start();
include_once 'db.php';
include_once '../includes/class/Sala.php';

$database = new Database();
$db = $database->conn;

$sala = new Sala($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_sala'], $_POST['ano_sala'], $_POST['serie_sala'], $_POST['ativa_sala'])) {
        $id_sala = $_POST['id_sala'];
        $ano_sala = $_POST['ano_sala'];
        $serie_sala = $_POST['serie_sala'];
        $ativa_sala = $_POST['ativa_sala'];

        // Atualiza a sala
        $query = "UPDATE salas SET ano_sala = ?, serie_sala = ?, ativa_sala = ? WHERE id_sala = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iiii", $ano_sala, $serie_sala, $ativa_sala, $id_sala);
        if ($stmt->execute()) {
            $_SESSION['mensagem'] = "Sala atualizada com sucesso!";
            header('Location: gerenciar_salas.php');
            exit();
        } else {
            $_SESSION['mensagem'] = "Erro ao atualizar a sala.";
        }
    }
}
?>

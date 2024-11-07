<?php
session_start();

include_once 'db.php';
include_once '../includes/class/SalaProfessor.php';

$database = new Database();
$db = $database->conn;

$salaProfessor = new SalaProfessor($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sp = $_POST['id_sp'];
    $professor_sp = $_POST['professor_sp'];

    if ($salaProfessor->atualizarProfessorNaSala($id_sp, $professor_sp)) {
        echo "Professor atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o professor.";
    }

    // Redirecionar ou mostrar uma mensagem após a atualização
    echo '<a href="visualizar_sala_professor.php?sala_sp=' . $professor_sp . '">Voltar</a>';
}
?>

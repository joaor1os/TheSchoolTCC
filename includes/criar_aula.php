<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    $professor_id = $_SESSION['user_id'];

    // Verifica se o ID da sala foi passado na URL
    if (isset($_GET['sala_id'])) {
        $sala_id = $_GET['sala_id'];

        // Busca a disciplina do professor
        $query_disciplina = "SELECT disciplina_professor FROM professor WHERE id_professor = ?";
        $stmt_disciplina = $conn->prepare($query_disciplina);
        $stmt_disciplina->bind_param("i", $professor_id);
        $stmt_disciplina->execute();
        $result_disciplina = $stmt_disciplina->get_result();
        $disciplina = $result_disciplina->fetch_assoc()['disciplina_professor'];

        // Cria a aula automaticamente na tabela `aulas`
        $data_aula = date('Y-m-d H:i:s'); // A data da aula é automaticamente preenchida com o momento atual

        $query_aula = "INSERT INTO aulas (data_aula, sala_aula, disciplina_aula) VALUES (?, ?, ?)";
        $stmt_aula = $conn->prepare($query_aula);
        $stmt_aula->bind_param("sii", $data_aula, $sala_id, $disciplina);
        $stmt_aula->execute();

        // Recupera o ID da aula criada
        $aula_id = $stmt_aula->insert_id;

        // Redireciona para a página de presença
        header("Location: dar_presenca.php?id_aula=" . $aula_id);
        exit();
    }
} else {
    // Redireciona para a página de login caso o usuário não seja um professor
    header("Location: login.php");
    exit();
}
?>

<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    $professor_id = $_SESSION['user_id'];
    $sala_id = isset($_GET['sala_id']) ? $_GET['sala_id'] : null;
    $disciplina_id = isset($_GET['disciplina_id']) ? $_GET['disciplina_id'] : null;

    // Verifica se a sala_id e disciplina_id foram passados corretamente pela URL
    if ($sala_id && $disciplina_id) {
        // Query para calcular a média dos 4 bimestres de cada aluno e trazer a situação
        $query = "
            SELECT a.id_aluno, 
                (IFNULL(n1.nota1, 0) + IFNULL(n2.nota1, 0) + IFNULL(n3.nota1, 0) + IFNULL(n4.nota1, 0)) / 4 AS media_final
            FROM aluno a
            LEFT JOIN notas n1 ON a.id_aluno = n1.aluno_nota AND n1.bimestre_nota = 1 AND n1.disciplina_nota = ?
            LEFT JOIN notas n2 ON a.id_aluno = n2.aluno_nota AND n2.bimestre_nota = 2 AND n2.disciplina_nota = ?
            LEFT JOIN notas n3 ON a.id_aluno = n3.aluno_nota AND n3.bimestre_nota = 3 AND n3.disciplina_nota = ?
            LEFT JOIN notas n4 ON a.id_aluno = n4.aluno_nota AND n4.bimestre_nota = 4 AND n4.disciplina_nota = ?
            WHERE n1.disciplina_nota = ? OR n2.disciplina_nota = ? OR n3.disciplina_nota = ? OR n4.disciplina_nota = ?
            ORDER BY a.id_aluno;
        ";

        // Preparando e executando a consulta
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiiiiiii", $disciplina_id, $disciplina_id, $disciplina_id, $disciplina_id, $disciplina_id, $disciplina_id, $disciplina_id, $disciplina_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Atualiza a média e a situação
        while ($row = $result->fetch_assoc()) {
            $media_final = $row['media_final'];
            $situacao = ($media_final >= 6) ? 2 : 3;  // 2 para Aprovado, 3 para Reprovado

            // Atualiza a situação do aluno na tabela mf_aluno
            $update_query = "
                UPDATE mf_aluno
                SET situacao_mf = ?
                WHERE aluno_mf = ? AND sala_mf = ? AND disciplina_mf = ?
            ";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("iiii", $situacao, $row['id_aluno'], $sala_id, $disciplina_id);
            $stmt_update->execute();
        }

        // Redireciona de volta para a página de gerenciamento de notas
        header("Location: gerenciar_notas_finais.php?sala_id=$sala_id&disciplina_id=$disciplina_id");
        exit();
    }
} else {
    // Redireciona para a página de login caso o usuário não seja um professor
    header("Location: login.php");
    exit();
}

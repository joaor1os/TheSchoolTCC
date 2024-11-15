<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica se os dados necessários foram recebidos
        if (isset($_POST['id_nota'], $_POST['nota1'], $_POST['nota2'], $_POST['nota3'], $_POST['bimestre'], $_POST['sala_id'], $_POST['disciplina_id'])) {
            // Recupera os dados enviados pelo formulário
            $id_nota = $_POST['id_nota'];
            $nota1 = floatval($_POST['nota1']);  // Garantir que os valores sejam números
            $nota2 = floatval($_POST['nota2']);
            $nota3 = floatval($_POST['nota3']);
            $bimestre = intval($_POST['bimestre']);
            $sala_id = intval($_POST['sala_id']);
            $disciplina_id = intval($_POST['disciplina_id']);

            // Calcula a média
            $media = ($nota1 + $nota2 + $nota3) / 3;

            // Prepara a consulta para atualizar as notas no banco de dados
            $query = "
                UPDATE notas 
                SET nota1 = ?, nota2 = ?, nota3 = ?, media = ? 
                WHERE id_nota = ? 
                  AND sala_nota = ? 
                  AND disciplina_nota = ? 
                  AND bimestre_nota = ?
            ";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ddddiiii", $nota1, $nota2, $nota3, $media, $id_nota, $sala_id, $disciplina_id, $bimestre);
            $stmt->execute();

            // Verifica se a atualização foi bem-sucedida
            if ($stmt->affected_rows > 0) {
                $_SESSION['message'] = 'Notas atualizadas com sucesso!';
            } else {
                $_SESSION['message'] = 'Erro ao atualizar as notas.';
            }

            // Redireciona de volta para a página de gerenciamento de notas
            header("Location: gerenciar_notas.php?sala_id=$sala_id&disciplina_id=$disciplina_id");
            exit();
        } else {
            // Caso os dados não tenham sido recebidos corretamente
            $_SESSION['message'] = 'Dados não recebidos corretamente.';
            header("Location: gerenciar_notas.php?sala_id=$sala_id&disciplina_id=$disciplina_id");
            exit();
        }
    }
} else {
    // Redireciona para a página de login caso o usuário não seja um professor
    header("Location: login.php");
    exit();
}
?>

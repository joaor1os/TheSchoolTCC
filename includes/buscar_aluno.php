<?php
include_once 'db.php';
include_once '../includes/class/SalaAluno.php';


$db = new Database();
$conn = $db->conn;

if (isset($_GET['nome']) && isset($_GET['ano_sala'])) {
    $nome = $_GET['nome'];
    $ano_sala = $_GET['ano_sala'];

    // Consulta para buscar alunos ativos que não estão cadastrados na sala para o ano letivo
    $query = "
        SELECT a.id_aluno, a.nome_aluno, a.cpf_aluno, a.data_nascimento_aluno
        FROM aluno a
        WHERE a.nome_aluno LIKE ? 
        AND a.id_aluno NOT IN (
            SELECT sa.aluno_sa
            FROM sala_alunos sa
            JOIN salas s ON sa.sala_sa = s.id_sala
            WHERE s.ano_sala = ? AND sa.ativo_sa = 1
        )
    ";
    
    $stmt = $conn->prepare($query);
    $nome_param = "%$nome%";
    $stmt->bind_param("si", $nome_param, $ano_sala);
    $stmt->execute();
    $result = $stmt->get_result();

    $alunos = [];
    while ($row = $result->fetch_assoc()) {
        $alunos[] = $row;
    }

    // Retorna os alunos em formato HTML para o select
    if ($alunos) {
        foreach ($alunos as $aluno) {
            // Calculando a idade
            $data_nascimento = new DateTime($aluno['data_nascimento_aluno']);
            $idade = $data_nascimento->diff(new DateTime())->y;
            
            echo "<option value='{$aluno['id_aluno']}'>
                    {$aluno['nome_aluno']} - Idade: $idade - CPF: {$aluno['cpf_aluno']}
                  </option>";
        }
    } else {
        echo "<option value=''>Nenhum aluno encontrado.</option>";
    }
}


?>

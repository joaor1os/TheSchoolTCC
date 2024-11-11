<?php
session_start();
include_once 'db.php';

// Conectar ao banco de dados
$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    if (isset($_GET['aula_id']) && isset($_GET['sala_id'])) {
        $aula_id = $_GET['aula_id'];
        $sala_id = $_GET['sala_id']; // Recebe o ID da sala

        // Recuperar os alunos da sala associada à aula
        $query = "SELECT sa.id_sa, a.nome_aluno, p.id_presenca, p.aula_presenca 
                  FROM sala_alunos sa
                  JOIN aluno a ON sa.aluno_sa = a.id_aluno
                  LEFT JOIN presenca_aulas p ON p.aula_realizada = ? AND p.aluno_presenca = a.id_aluno
                  WHERE sa.sala_sa = ? AND sa.ativo_sa = 1";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $aula_id, $sala_id);
        $stmt->execute();
        $result_presencas = $stmt->get_result();
    } else {
        echo "Aula ou sala não especificada.";
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Presenças da Aula</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Presenças da Aula</h1>

    <table>
        <tr>
            <th>Nome do Aluno</th>
            <th>Presença</th>
            <th>Editar</th>
        </tr>
        <?php while ($presenca = $result_presencas->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $presenca['nome_aluno']; ?></td>
                <td>
                    <?php echo $presenca['aula_presenca'] ? $presenca['aula_presenca'] : 'Nenhuma presença registrada'; ?>
                </td>
                <td>
                    <a href="editar_presenca.php?presenca_id=<?php echo $presenca['id_presenca']; ?>&aula_id=<?php echo $aula_id; ?>&sala_id=<?php echo $sala_id; ?>" class="btn">Editar Presença</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="visualizar_aulas.php?sala_id=<?php echo $sala_id; ?>">Voltar para Aulas</a>
</body>
</html>

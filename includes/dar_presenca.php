<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    $professor_id = $_SESSION['user_id'];

    // Verifica se o ID da aula foi passado na URL
    if (isset($_GET['id_aula'])) {
        $aula_id = $_GET['id_aula'];

        // Consulta os alunos da sala associada à aula
        $query_alunos = "
            SELECT a.id_aluno, a.nome_aluno
            FROM aluno a
            JOIN sala_alunos sa ON a.id_aluno = sa.aluno_sa
            JOIN salas s ON sa.sala_sa = s.id_sala
            WHERE s.id_sala IN (SELECT sala_aula FROM aulas WHERE id_aula = ?)
            AND sa.ativo_sa = 1"; // Apenas alunos ativos
        $stmt_alunos = $conn->prepare($query_alunos);
        $stmt_alunos->bind_param("i", $aula_id);
        $stmt_alunos->execute();
        $result_alunos = $stmt_alunos->get_result();

        // Quando o formulário de presença é enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $presencas_registradas = true; // Variável para verificar se todas as presenças foram registradas

            while ($aluno = $result_alunos->fetch_assoc()) {
                if (isset($_POST['presenca_' . $aluno['id_aluno']])) {
                    $presenca = $_POST['presenca_' . $aluno['id_aluno']];

                    // Inserir a presença na tabela presenca_aulas
                    $query_presenca = "INSERT INTO presenca_aulas (aluno_presenca, aula_presenca, aula_realizada) VALUES (?, ?, ?)";
                    $stmt_presenca = $conn->prepare($query_presenca);
                    $stmt_presenca->bind_param("isi", $aluno['id_aluno'], $presenca, $aula_id);
                    $stmt_presenca->execute();
                } else {
                    $presencas_registradas = false; // Caso algum aluno não tenha presença marcada
                }
            }

            // Mensagem de sucesso ou erro após o processamento
            if ($presencas_registradas) {
                // Exibe a mensagem de sucesso com JavaScript e redireciona
                echo "<script type='text/javascript'>
                        alert('Presença registrada com sucesso!');
                        window.location.href = 'professor_home.php'; // Redireciona após a confirmação
                      </script>";
            } else {
                // Exibe erro caso algum aluno não tenha marcado presença
                echo "<script type='text/javascript'>
                        alert('Por favor, marque a presença de todos os alunos!');
                      </script>";
            }
        }
    } else {
        echo "Aula não encontrada.";
    }
} else {
    // Redireciona para a página de login caso o usuário não seja um professor
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar Presença na Aula</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Registrar Presença na Aula</h1>

    <form method="POST" action="">
        <table>
            <tr>
                <th>Aluno</th>
                <th>Presença</th>
            </tr>
            <?php 
            // Reset o ponteiro para o início do resultado dos alunos, pois já foi consumido no POST
            $stmt_alunos->data_seek(0); 

            // Exibe os alunos e seus campos de presença
            while ($aluno = $result_alunos->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $aluno['nome_aluno']; ?></td>
                    <td>
                        <input type="radio" name="presenca_<?php echo $aluno['id_aluno']; ?>" value="P"> Presente
                        <input type="radio" name="presenca_<?php echo $aluno['id_aluno']; ?>" value="A"> Ausente
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <button type="submit">Registrar Presenças</button>
    </form>

    <br>
    <a href="professor_home.php">Voltar para a Home</a>
</body>
</html>

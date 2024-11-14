<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    $professor_id = $_SESSION['user_id'];

    if (isset($_GET['id_aula'])) {
        $aula_id = $_GET['id_aula'];

        $query_alunos = "
            SELECT a.id_aluno, a.nome_aluno
            FROM aluno a
            JOIN sala_alunos sa ON a.id_aluno = sa.aluno_sa
            JOIN salas s ON sa.sala_sa = s.id_sala
            WHERE s.id_sala IN (SELECT sala_aula FROM aulas WHERE id_aula = ?)
            AND sa.ativo_sa = 1";
        $stmt_alunos = $conn->prepare($query_alunos);
        $stmt_alunos->bind_param("i", $aula_id);
        $stmt_alunos->execute();
        $result_alunos = $stmt_alunos->get_result();

        // Envio do Formulário
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['salvar_presenca'])) {
            while ($aluno = $result_alunos->fetch_assoc()) {
                // Verifica se a presença foi marcada para o aluno
                if (isset($_POST['presenca_' . $aluno['id_aluno']])) {
                    $presenca = $_POST['presenca_' . $aluno['id_aluno']];
                } else {
                    // Define "A" para ausente caso não tenha sido marcada presença
                    $presenca = "A";
                }

                // Insere a presença no banco de dados
                $query_presenca = "INSERT INTO presenca_aulas (aluno_presenca, aula_presenca, aula_realizada) VALUES (?, ?, ?)";
                $stmt_presenca = $conn->prepare($query_presenca);
                $stmt_presenca->bind_param("isi", $aluno['id_aluno'], $presenca, $aula_id);
                $stmt_presenca->execute();
            }

            echo "<script type='text/javascript'>
                    alert('Presença registrada com sucesso! Alunos sem presença marcada foram considerados ausentes.');
                    window.location.href = 'professor_home.php';
                  </script>";
        }

        // Botão Voltar (Exclui o registro da aula)
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['voltar'])) {
            $query_delete_aula = "DELETE FROM aulas WHERE id_aula = ?";
            $stmt_delete = $conn->prepare($query_delete_aula);
            $stmt_delete->bind_param("i", $aula_id);
            $stmt_delete->execute();

            echo "<script type='text/javascript'>
                    window.location.href = 'professor_home.php';
                  </script>";
            exit();
        }
    } else {
        echo "Aula não encontrada.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Presença</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Presenca/confirmedPresenca.css">
</head>
<body>
    <?php $dataAtual = date('d/m/Y'); ?>
    <h1>Registrar Presença na Aula - <?php echo $dataAtual; ?></h1>

    <form method="POST">
        <table>
            <tr>
                <th>Aluno</th>
                <th>Presença</th>
            </tr>
            <?php 
            $stmt_alunos->data_seek(0); 
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
        <button type="submit" name="salvar_presenca" class="btn">Registrar Presenças</button>
    </form>

    <!-- Botão de voltar em um formulário separado para deletar a aula -->
    <form method="POST" style="margin-top: 15px;">
        <button type="submit" name="voltar" class="btn btn-secondary">Voltar para a Home</button>
    </form>
</body>
</html>


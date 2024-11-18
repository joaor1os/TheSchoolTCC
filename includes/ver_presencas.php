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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presenças da Aula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/Presenca/viewPresenca.css">
</head>
<body class="bg-light">


    <div class="container mt-5">
        <h1 class="text-center mb-4 fade-in">Presenças da Aula</h1>

 
        <div class="card shadow-sm mb-4 slide-in">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Lista de Presenças</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Nome do Aluno</th>
                            <th>Presença</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($presenca = $result_presencas->fetch_assoc()) : ?>
                            <tr>
                                <td><?= htmlspecialchars($presenca['nome_aluno']); ?></td>
                                <td>
                                    <?php echo $presenca['aula_presenca'] ? $presenca['aula_presenca'] : 'Nenhuma presença registrada'; ?>
                                </td>
                                <td>
                                    <a href="editar_presenca.php?presenca_id=<?php echo $presenca['id_presenca']; ?>&aula_id=<?php echo $aula_id; ?>&sala_id=<?php echo $sala_id; ?>" class="btn btn-primary btn-sm">Editar Presença</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="visualizar_aulas.php?sala_id=<?php echo $sala_id; ?>" class="btn btn-secondary">Voltar para Aulas</a>
    </div>
</body>
</html>


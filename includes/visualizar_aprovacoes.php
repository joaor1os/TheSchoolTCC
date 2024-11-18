<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

$sala_id = isset($_GET['id_sala']) ? $_GET['id_sala'] : null;

if ($sala_id) {
    // Query para buscar os alunos, suas situações finais e disciplinas reprovadas
    $query = "
        SELECT 
            a.id_aluno, 
            a.nome_aluno, 
            GROUP_CONCAT(DISTINCT d.nome_disciplina SEPARATOR ', ') AS disciplinas_reprovadas,
            IF(MIN(mfa.situacao_mf = 2), 'Aprovado', 'Reprovado') AS situacao_final
        FROM aluno a
        LEFT JOIN mf_aluno mfa ON a.id_aluno = mfa.aluno_mf
        LEFT JOIN disciplinas d ON mfa.disciplina_mf = d.id_disciplina
        WHERE mfa.sala_mf = ?
        GROUP BY a.id_aluno, a.nome_aluno
        ORDER BY a.nome_aluno;
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sala_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $error_message = "ID da sala não fornecido.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Aprovações</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/room/viewAprove.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Resultados Finais dos Alunos</h1>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message; ?></div>
        <?php elseif (isset($result) && $result->num_rows > 0): ?>
            <table class="table table-hover table-bordered mt-4 shadow">
                <thead class="table-success">
                    <tr>
                        <th>ID do Aluno</th>
                        <th>Nome do Aluno</th>
                        <th>Situação Final</th>
                        <th>Disciplinas Reprovadas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_aluno']; ?></td>
                            <td><?= $row['nome_aluno']; ?></td>
                            <td><?= $row['situacao_final']; ?></td>
                            <td>
                                <?= $row['situacao_final'] === 'Reprovado' 
                                    ? $row['disciplinas_reprovadas'] 
                                    : 'Nenhuma'; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning mt-4">Nenhum resultado encontrado para esta sala.</div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


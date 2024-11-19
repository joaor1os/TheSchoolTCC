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

    if ($sala_id && $disciplina_id) {
        atualizar_notas_finais($sala_id, $disciplina_id);

        // Query para buscar informações atualizadas
        $query = "
            SELECT a.id_aluno, a.nome_aluno, 
                COALESCE(n1.media, 0) AS media_b1,
                COALESCE(n2.media, 0) AS media_b2,
                COALESCE(n3.media, 0) AS media_b3,
                COALESCE(n4.media, 0) AS media_b4,
                mfa.media_final AS media_final,
                mf.nome_st_mf AS situacao
            FROM aluno a
            LEFT JOIN notas n1 ON a.id_aluno = n1.aluno_nota AND n1.bimestre_nota = 1 AND n1.disciplina_nota = ?
            LEFT JOIN notas n2 ON a.id_aluno = n2.aluno_nota AND n2.bimestre_nota = 2 AND n2.disciplina_nota = ?
            LEFT JOIN notas n3 ON a.id_aluno = n3.aluno_nota AND n3.bimestre_nota = 3 AND n3.disciplina_nota = ?
            LEFT JOIN notas n4 ON a.id_aluno = n4.aluno_nota AND n4.bimestre_nota = 4 AND n4.disciplina_nota = ?
            LEFT JOIN mf_aluno mfa ON a.id_aluno = mfa.aluno_mf AND mfa.sala_mf = ? AND mfa.disciplina_mf = ?
            LEFT JOIN mf_situacao mf ON mfa.situacao_mf = mf.id_st_mf
            WHERE EXISTS (
                SELECT 1 
                FROM mf_aluno 
                WHERE mf_aluno.aluno_mf = a.id_aluno 
                  AND mf_aluno.sala_mf = ? 
                  AND mf_aluno.disciplina_mf = ?
            )
            ORDER BY a.nome_aluno;
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiiiiiii", $disciplina_id, $disciplina_id, $disciplina_id, $disciplina_id, $sala_id, $disciplina_id, $sala_id, $disciplina_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }
} else {
    header("Location: login.php");
    exit();
}

function atualizar_notas_finais($sala_id, $disciplina_id) {
    global $conn;

    // Query para calcular a média final com base nos 4 bimestres
    $query = "
        SELECT a.id_aluno,
            (
                COALESCE(n1.media, 0) + 
                COALESCE(n2.media, 0) + 
                COALESCE(n3.media, 0) + 
                COALESCE(n4.media, 0)
            ) / 4 AS media_final
        FROM aluno a
        LEFT JOIN notas n1 ON a.id_aluno = n1.aluno_nota AND n1.bimestre_nota = 1 AND n1.disciplina_nota = ?
        LEFT JOIN notas n2 ON a.id_aluno = n2.aluno_nota AND n2.bimestre_nota = 2 AND n2.disciplina_nota = ?
        LEFT JOIN notas n3 ON a.id_aluno = n3.aluno_nota AND n3.bimestre_nota = 3 AND n3.disciplina_nota = ?
        LEFT JOIN notas n4 ON a.id_aluno = n4.aluno_nota AND n4.bimestre_nota = 4 AND n4.disciplina_nota = ?
        WHERE EXISTS (
            SELECT 1 
            FROM mf_aluno 
            WHERE mf_aluno.aluno_mf = a.id_aluno 
              AND mf_aluno.sala_mf = ? 
              AND mf_aluno.disciplina_mf = ?
        )
        ORDER BY a.id_aluno;
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiiii", $disciplina_id, $disciplina_id, $disciplina_id, $disciplina_id, $sala_id, $disciplina_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $media_final = round($row['media_final'], 2);
        $situacao = ($media_final >= 6) ? 2 : 3;

        $update_query = "
            UPDATE mf_aluno
            SET situacao_mf = ?, media_final = ?
            WHERE aluno_mf = ? AND sala_mf = ? AND disciplina_mf = ?
        ";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("idiii", $situacao, $media_final, $row['id_aluno'], $sala_id, $disciplina_id);
        $stmt_update->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Notas Finais</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Professor/gerenciarNotaFinal.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Notas Finais dos Alunos</h1>

        <?php if (isset($result) && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped fade-in">
                    <thead class="table-dark">
                        <tr>
                            <th>ID do Aluno</th>
                            <th>Nome do Aluno</th>
                            <th>Média Final</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_aluno']; ?></td>
                                <td><?php echo $row['nome_aluno']; ?></td>
                                <td><?php echo number_format($row['media_final'], 2, ',', '.'); ?></td>
                                <td><?php echo $row['situacao']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning fade-in">
                Nenhum aluno encontrado ou as notas não foram inseridas.
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="professor_home.php" class="btn btn-secondary fade-in">Voltar para a Home</a>
        </div>
    </div>

    <script src="../js/confirmedClass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

$sala_id = isset($_GET['id_sala']) ? $_GET['id_sala'] : null;
$aluno_id = isset($_GET['id_aluno']) ? $_GET['id_aluno'] : null;

if ($sala_id) {
    // Query para listar todos os alunos da sala, ordenados alfabeticamente
    $query_alunos = "
        SELECT a.id_aluno, a.nome_aluno 
        FROM aluno a
        INNER JOIN notas n ON a.id_aluno = n.aluno_nota
        WHERE n.sala_nota = ?
        GROUP BY a.id_aluno, a.nome_aluno
        ORDER BY a.nome_aluno ASC  -- Ordena os alunos em ordem alfabética
    ";

    $stmt = $conn->prepare($query_alunos);
    $stmt->bind_param("i", $sala_id);
    $stmt->execute();
    $result_alunos = $stmt->get_result();

    if ($aluno_id) {
        // Query para buscar as médias dos 4 bimestres e a média final de cada disciplina do aluno
        $query = "
            SELECT 
                a.id_aluno, 
                a.nome_aluno,
                d.nome_disciplina,
                AVG(CASE WHEN n.bimestre_nota = 1 THEN n.media ELSE NULL END) AS media_bimestre1,
                AVG(CASE WHEN n.bimestre_nota = 2 THEN n.media ELSE NULL END) AS media_bimestre2,
                AVG(CASE WHEN n.bimestre_nota = 3 THEN n.media ELSE NULL END) AS media_bimestre3,
                AVG(CASE WHEN n.bimestre_nota = 4 THEN n.media ELSE NULL END) AS media_bimestre4,
                ma.media_final,
                mf_situacao.nome_st_mf AS situacao_disciplina
            FROM aluno a
            LEFT JOIN notas n ON a.id_aluno = n.aluno_nota
            LEFT JOIN disciplinas d ON n.disciplina_nota = d.id_disciplina
            LEFT JOIN mf_aluno ma ON a.id_aluno = ma.aluno_mf 
                AND ma.disciplina_mf = d.id_disciplina 
                AND ma.sala_mf = n.sala_nota
            LEFT JOIN mf_situacao ON ma.situacao_mf = mf_situacao.id_st_mf
            WHERE n.sala_nota = ? AND a.id_aluno = ?
            GROUP BY a.id_aluno, a.nome_aluno, d.nome_disciplina, ma.media_final, mf_situacao.nome_st_mf
            ORDER BY d.nome_disciplina;
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $sala_id, $aluno_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }
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
        <?php else: ?>
            <!-- Filtro de Alunos -->
            <form action="" method="get">
                <input type="hidden" name="id_sala" value="<?= $sala_id; ?>">
                <div class="mb-4">
                    <label for="aluno" class="form-label">Escolha um Aluno</label>
                    <select name="id_aluno" id="aluno" class="form-select">
                        <option value="">Selecione um aluno</option>
                        <?php while ($row_aluno = $result_alunos->fetch_assoc()): ?>
                            <option value="<?= $row_aluno['id_aluno']; ?>" <?= $row_aluno['id_aluno'] == $aluno_id ? 'selected' : ''; ?> >
                                <?= $row_aluno['nome_aluno']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>

            <?php if ($aluno_id && isset($result)): ?>
                <!-- Exibir Notas e Situação do Aluno -->
                <table class="table table-hover table-bordered mt-4 shadow">
                    <thead class="table-success">
                        <tr>
                            <th>Disciplina</th>
                            <th>Média Bimestre 1</th>
                            <th>Média Bimestre 2</th>
                            <th>Média Bimestre 3</th>
                            <th>Média Bimestre 4</th>
                            <th>Média Final</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <tr class="<?= $row['situacao_disciplina'] == 'Reprovado' ? 'table-danger' : ''; ?>">
                                <td><?= $row['nome_disciplina']; ?></td>
                                <td><?= number_format($row['media_bimestre1'], 2, ',', '.'); ?></td>
                                <td><?= number_format($row['media_bimestre2'], 2, ',', '.'); ?></td>
                                <td><?= number_format($row['media_bimestre3'], 2, ',', '.'); ?></td>
                                <td><?= number_format($row['media_bimestre4'], 2, ',', '.'); ?></td>
                                <td><?= number_format($row['media_final'], 2, ',', '.'); ?></td>
                                <td><?= $row['situacao_disciplina']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php elseif ($aluno_id): ?>
                <div class="alert alert-warning mt-4">Nenhum resultado encontrado para este aluno.</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

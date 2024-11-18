<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database(); // Instancia a classe Database
$conn = $db->conn; // Obtém a conexão

// Verifica se o usuário está autenticado e é um aluno
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'aluno') {
    header("Location: login.php");
    exit();
}

$id_aluno = $_SESSION['user_id'];

// Filtro de disciplina
$filtro_disciplina = isset($_GET['disciplina']) ? $_GET['disciplina'] : '';

// Consulta para listar as disciplinas disponíveis para o filtro
$disciplina_query = "
    SELECT DISTINCT d.id_disciplina, d.nome_disciplina
    FROM notas n
    JOIN disciplinas d ON n.disciplina_nota = d.id_disciplina
    WHERE n.aluno_nota = ? 
    ORDER BY d.nome_disciplina;
";
$disciplina_stmt = $conn->prepare($disciplina_query);
$disciplina_stmt->bind_param("i", $id_aluno);
$disciplina_stmt->execute();
$disciplinas_result = $disciplina_stmt->get_result();
$disciplinas = $disciplinas_result->fetch_all(MYSQLI_ASSOC);

// Consulta para buscar as presenças do aluno e o total de aulas dadas
$presencas_query = "
    SELECT 
        COUNT(a.id_aula) AS total_aulas,
        SUM(CASE WHEN pa.aula_presenca = 'P' THEN 1 ELSE 0 END) AS aulas_presentes
    FROM presenca_aulas pa
    JOIN aulas a ON pa.aula_realizada = a.id_aula
    WHERE pa.aluno_presenca = ? 
    AND a.disciplina_aula = ?
";
$presencas_stmt = $conn->prepare($presencas_query);
$presencas_stmt->bind_param("ii", $id_aluno, $filtro_disciplina);
$presencas_stmt->execute();
$presencas_result = $presencas_stmt->get_result();
$presencas_data = $presencas_result->fetch_assoc();

$total_aulas = $presencas_data['total_aulas'];
$aulas_presentes = $presencas_data['aulas_presentes'];

if ($total_aulas > 0) {
    $percentual_presenca = ($aulas_presentes / $total_aulas) * 100;
} else {
    $percentual_presenca = 0;
}

// Consulta para buscar as notas do aluno com filtro por disciplina
$notas = [];
if (!empty($filtro_disciplina)) {
    $query = "
        SELECT 
            s.ano_sala,
            sr.nome_serie,
            d.nome_disciplina,
            b.nome_bimestre,
            n.nota1,
            n.nota2,
            n.nota3,
            n.media,
            mf.media_final,
            mf_s.nome_st_mf
        FROM sala_alunos sa
        JOIN salas s ON sa.sala_sa = s.id_sala
        JOIN serie sr ON s.serie_sala = sr.id_serie
        JOIN notas n ON sa.aluno_sa = n.aluno_nota AND s.id_sala = n.sala_nota
        JOIN disciplinas d ON n.disciplina_nota = d.id_disciplina
        JOIN bimestres b ON n.bimestre_nota = b.id_bimestre
        LEFT JOIN mf_aluno mf ON sa.aluno_sa = mf.aluno_mf AND n.disciplina_nota = mf.disciplina_mf AND n.sala_nota = mf.sala_mf
        LEFT JOIN mf_situacao mf_s ON mf.situacao_mf = mf_s.id_st_mf
        WHERE sa.aluno_sa = ? 
        AND sa.ativo_sa = 1 
        AND s.ativa_sala = 1  -- Certificando que a sala está ativa
        AND n.disciplina_nota = ?
        ORDER BY s.ano_sala DESC, sr.nome_serie, d.nome_disciplina, b.id_bimestre
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_aluno, $filtro_disciplina);
    $stmt->execute();
    $result = $stmt->get_result();
    $notas = $result->fetch_all(MYSQLI_ASSOC);
}

// Consulta para buscar salas inativas em que o aluno está registrado
$salas_inativas_query = "
    SELECT 
        s.ano_sala,
        sr.nome_serie,
        s.id_sala
    FROM sala_alunos sa
    JOIN salas s ON sa.sala_sa = s.id_sala
    JOIN serie sr ON s.serie_sala = sr.id_serie
    WHERE sa.aluno_sa = ? AND s.ativa_sala = 2
    ORDER BY s.ano_sala DESC, sr.nome_serie
";
$salas_stmt = $conn->prepare($salas_inativas_query);
$salas_stmt->bind_param("i", $id_aluno);
$salas_stmt->execute();
$salas_result = $salas_stmt->get_result();
$salas_inativas = $salas_result->fetch_all(MYSQLI_ASSOC);

// Função para exibir as notas da sala inativa
function exibirNotasSalaInativa($id_sala, $conn, $id_aluno) {
    $query = "
        SELECT 
            d.nome_disciplina,
            b.nome_bimestre,
            n.nota1,
            n.nota2,
            n.nota3,
            n.media
        FROM notas n
        JOIN disciplinas d ON n.disciplina_nota = d.id_disciplina
        JOIN bimestres b ON n.bimestre_nota = b.id_bimestre
        WHERE n.sala_nota = ? 
        AND n.aluno_nota = ?
        ORDER BY b.id_bimestre;
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_sala, $id_aluno);
    $stmt->execute();
    $result = $stmt->get_result();
    $notas_inativas = $result->fetch_all(MYSQLI_ASSOC);
    
    // Exibe as notas
    if (count($notas_inativas) > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Disciplina</th><th>Bimestre</th><th>Nota 1</th><th>Nota 2</th><th>Nota 3</th><th>Média</th></tr></thead>";
        echo "<tbody>";
        foreach ($notas_inativas as $nota) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($nota['nome_disciplina']) . "</td>";
            echo "<td>" . htmlspecialchars($nota['nome_bimestre']) . "</td>";
            echo "<td>" . number_format($nota['nota1'], 2) . "</td>";
            echo "<td>" . number_format($nota['nota2'], 2) . "</td>";
            echo "<td>" . number_format($nota['nota3'], 2) . "</td>";
            echo "<td>" . number_format($nota['media'], 2) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Não há notas registradas para esta sala inativa.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas e Presenças</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Painel do Aluno</a>
            <div class="d-flex">
                <a href="../includes/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4 fade-in">Área do Aluno</h1>
        
        <!-- Formulário de Filtro -->
        <form method="GET" class="mb-4 slide-in">
            <div class="row align-items-end">
                <div class="col-md-8">
                    <label for="disciplina" class="form-label">Filtrar por Disciplina</label>
                    <select id="disciplina" name="disciplina" class="form-select" required>
                        <option value="" disabled selected>Selecione uma disciplina</option>
                        <?php foreach ($disciplinas as $disciplina): ?>
                            <option value="<?= $disciplina['id_disciplina'] ?>" <?= $filtro_disciplina == $disciplina['id_disciplina'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($disciplina['nome_disciplina']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Exibição da Porcentagem de Presença com Card -->
        <div class="row mb-4 fade-in">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Presença</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Porcentagem de Presença: <span class="fw-bold"><?= number_format($percentual_presenca, 2) ?>%</span></h5>
                        <p class="card-text">Aulas presentes: <?= $aulas_presentes ?> / <?= $total_aulas ?></p>
                        <?php if ($percentual_presenca < 75): ?>
                            <div class="alert alert-warning mt-3">
                                Atenção: Sua presença está abaixo de 75%! Procure melhorar sua frequência.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Notas -->
        <?php if (!empty($notas)): ?>
            <table class="table table-striped table-bordered slide-in">
                <thead class="table-primary">
                    <tr>
                        <th>Ano</th>
                        <th>Série</th>
                        <th>Disciplina</th>
                        <th>Bimestre</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota 3</th>
                        <th>Média Bimestral</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notas as $nota): ?>
                        <tr>
                            <td><?= htmlspecialchars($nota['ano_sala']) ?></td>
                            <td><?= htmlspecialchars($nota['nome_serie']) ?></td>
                            <td><?= htmlspecialchars($nota['nome_disciplina']) ?></td>
                            <td><?= htmlspecialchars($nota['nome_bimestre']) ?></td>
                            <td><?= number_format($nota['nota1'], 2) ?></td>
                            <td><?= number_format($nota['nota2'], 2) ?></td>
                            <td><?= number_format($nota['nota3'], 2) ?></td>
                            <td class="<?= ($nota['media'] >= 6) ? 'text-green' : 'text-red' ?>">
                                <?= number_format($nota['media'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

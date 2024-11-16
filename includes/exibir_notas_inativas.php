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

// Recebe o id_sala da URL
$id_sala = isset($_GET['id_sala']) ? $_GET['id_sala'] : 0;
if ($id_sala == 0) {
    header("Location: index.php");
    exit();
}

// Recupera as disciplinas para o filtro apenas se o aluno estiver registrado nelas na sala selecionada
$disciplinas_query = "
    SELECT DISTINCT d.id_disciplina, d.nome_disciplina
    FROM notas n
    JOIN disciplinas d ON n.disciplina_nota = d.id_disciplina
    JOIN sala_alunos sa ON sa.aluno_sa = n.aluno_nota
    WHERE sa.aluno_sa = ? AND sa.sala_sa = ? AND sa.ativo_sa = 1
    ORDER BY d.nome_disciplina
";
$disciplinas_stmt = $conn->prepare($disciplinas_query);
$disciplinas_stmt->bind_param("ii", $id_aluno, $id_sala);
$disciplinas_stmt->execute();
$disciplinas_result = $disciplinas_stmt->get_result();
$disciplinas = $disciplinas_result->fetch_all(MYSQLI_ASSOC);

// Recupera a disciplina selecionada, se houver
$disciplina_filtro = isset($_POST['disciplina']) ? $_POST['disciplina'] : '';

// Inicializa a variável de notas
$notas = [];

// Consulta para buscar as notas do aluno para a sala inativa, com ou sem filtro de disciplina
if (!empty($disciplina_filtro)) {
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
        WHERE sa.aluno_sa = ? AND s.id_sala = ? AND sa.ativo_sa = 1
        AND d.id_disciplina = ?
        ORDER BY s.ano_sala DESC, sr.nome_serie, d.nome_disciplina, b.id_bimestre
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $id_aluno, $id_sala, $disciplina_filtro);
    $stmt->execute();
    $result = $stmt->get_result();
    $notas = $result->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas da Sala Inativa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Notas da Sala Inativa</h1>

        <!-- Filtro de Disciplina -->
        <?php if (!empty($disciplinas)): ?>
            <form method="POST" class="mb-4">
                <div class="form-group">
                    <label for="disciplina">Filtrar por Disciplina</label>
                    <select name="disciplina" id="disciplina" class="form-control">
                        <option value="">Selecione uma disciplina</option>
                        <?php foreach ($disciplinas as $disciplina): ?>
                            <option value="<?= $disciplina['id_disciplina'] ?>" <?= $disciplina_filtro == $disciplina['id_disciplina'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($disciplina['nome_disciplina']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
            </form>
        <?php endif; ?>

        <!-- Tabela de Notas -->
        <?php if (!empty($notas)): ?>
            <?php 
                $media_total = 0; 
                $quantidade_medias = 0; 
            ?>
            <table class="table table-striped table-bordered">
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
                            <td><?= number_format($nota['media'], 2) ?></td>
                        </tr>
                        <?php 
                            $media_total += $nota['media'];
                            $quantidade_medias++;
                        ?>
                    <?php endforeach; ?>
                    <?php 
                        $media_final = $quantidade_medias > 0 ? $media_total / $quantidade_medias : 0;
                        $media_class = $media_final >= 6 ? 'text-green' : 'text-red';
                    ?>
                    <tr>
                        <td colspan="7" class="text-end"><strong>Média Final da Sala:</strong></td>
                        <td class="<?= $media_class ?>"><?= number_format($media_final, 2) ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
        <?php endif; ?>

        <a href="aluno_home.php" class="btn btn-secondary mt-4">Voltar</a>
    </div>
</body>
</html>

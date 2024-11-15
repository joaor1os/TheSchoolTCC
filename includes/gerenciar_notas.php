<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

// Verificar se o parâmetro sala_id e disciplina_id estão presentes na URL
if (!isset($_GET['sala_id']) || !isset($_GET['disciplina_id'])) {
    die("Sala e disciplina não informadas.");
}

$sala_id = $_GET['sala_id'];
$disciplina_id = $_GET['disciplina_id'];

// Verificar se um bimestre foi enviado
$bimestre = isset($_GET['bimestre']) ? $_GET['bimestre'] : null;

// Consulta para obter os bimestres disponíveis
$query_bimestres = "SELECT * FROM bimestres";
$result_bimestres = $conn->query($query_bimestres);

// Se o bimestre for especificado, exibe as notas dos alunos
if ($bimestre) {
    $query = "
        SELECT n.*, a.nome_aluno 
        FROM notas n
        JOIN aluno a ON n.aluno_nota = a.id_aluno
        WHERE n.sala_nota = ? AND n.disciplina_nota = ? AND n.bimestre_nota = ?
        GROUP BY n.aluno_nota, n.bimestre_nota
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $sala_id, $disciplina_id, $bimestre);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Gerenciar Notas - Sala <?php echo $sala_id; ?> - Disciplina <?php echo $disciplina_id; ?></h2>

        <!-- Formulário de pesquisa por bimestre -->
        <form action="gerenciar_notas.php" method="get">
            <input type="hidden" name="sala_id" value="<?php echo $sala_id; ?>">
            <input type="hidden" name="disciplina_id" value="<?php echo $disciplina_id; ?>">

            <div class="mb-3">
                <label for="bimestre" class="form-label">Selecione o Bimestre:</label>
                <select name="bimestre" id="bimestre" class="form-select" required>
                    <option value="">Selecione um Bimestre</option>
                    <?php while ($bimestre_option = $result_bimestres->fetch_assoc()) : ?>
                        <option value="<?php echo $bimestre_option['id_bimestre']; ?>" <?php echo isset($bimestre) && $bimestre == $bimestre_option['id_bimestre'] ? 'selected' : ''; ?>>
                            <?php echo $bimestre_option['nome_bimestre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>

        <!-- Exibição das Notas se o bimestre for selecionado -->
        <?php if ($bimestre && $result->num_rows > 0): ?>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota 3</th>
                        <th>Média</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($nota = $result->fetch_assoc()) : ?>
                        <form action="editar_nota.php" method="post">
                            <input type="hidden" name="id_nota" value="<?php echo $nota['id_nota']; ?>">
                            <input type="hidden" name="sala_id" value="<?php echo $sala_id; ?>">
                            <input type="hidden" name="disciplina_id" value="<?php echo $disciplina_id; ?>">
                            <input type="hidden" name="bimestre" value="<?php echo $nota['bimestre_nota']; ?>">

                            <tr>
                                <td><?php echo $nota['nome_aluno']; ?></td>
                                <td><input type="number" step="0.01" name="nota1" value="<?php echo $nota['nota1']; ?>" class="form-control" min="0" max="10"></td>
                                <td><input type="number" step="0.01" name="nota2" value="<?php echo $nota['nota2']; ?>" class="form-control" min="0" max="10"></td>
                                <td><input type="number" step="0.01" name="nota3" value="<?php echo $nota['nota3']; ?>" class="form-control" min="0" max="10"></td>
                                <td><input type="text" value="<?php echo $nota['media']; ?>" class="form-control" disabled></td>
                                <td><button type="submit" class="btn btn-success">Salvar</button></td>
                            </tr>
                        </form>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php elseif ($bimestre && $result->num_rows == 0): ?>
            <p class="alert alert-warning">Nenhuma nota encontrada para o bimestre selecionado.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
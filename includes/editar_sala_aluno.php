<?php
session_start();
include_once 'db.php';
include_once '../includes/class/SalaAluno.php';

$database = new Database();
$db = $database->conn;

$salaAluno = new SalaAluno($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_sa'])) {
    $id_sa = $_GET['id_sa'];
    $alunoDetails = $salaAluno->buscarAlunoPorId($id_sa);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sa'])) {
    $id_sa = $_POST['id_sa'];
    $aluno_sa = $_POST['aluno_sa'];
    $ativo_sa = $_POST['ativo_sa'];

    if ($salaAluno->atualizar($id_sa, $aluno_sa, $ativo_sa)) {
        header("Location: gerenciar_salas.php"); // Redirecionar para a lista de alunos após a atualização
        exit;
    } else {
        $mensagem = "Erro ao atualizar aluno.";
    }
}

// Buscar alunos e situações para preencher o formulário
$alunos = $salaAluno->buscarAlunos();
$situacoes = $salaAluno->buscarSituacoes();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno na Sala</title>
</head>
<body>
    <h1>Editar Aluno</h1>
    <?php if (isset($mensagem)) echo "<p>$mensagem</p>"; ?>
    
    <form method="POST" action="editar_sala_aluno.php">
        <input type="hidden" name="id_sa" value="<?= $id_sa; ?>">

        <label for="aluno_sa">Selecione o Aluno:</label>
        <select id="aluno_sa" name="aluno_sa" required>
            <?php foreach ($alunos as $aluno): ?>
                <option value="<?= $aluno['id_aluno']; ?>" <?= ($aluno['id_aluno'] == $alunoDetails['aluno_sa']) ? 'selected' : ''; ?>>
                    <?= $aluno['nome_aluno']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="ativo_sa">Situação:</label>
        <select id="ativo_sa" name="ativo_sa" required>
            <?php foreach ($situacoes as $situacao): ?>
                <option value="<?= $situacao['id_situacao']; ?>" <?= ($situacao['id_situacao'] == $alunoDetails['ativo_sa']) ? 'selected' : ''; ?>>
                    <?= $situacao['nome_situacao']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Atualizar</button>
    </form>

    <a href="gerenciar_salas.php">Voltar</a>
</body>
</html>

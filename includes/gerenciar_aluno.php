<?php
session_start();

include_once 'db.php';
include_once '../includes/class/Aluno.php';

$database = new Database();
$db = $database->conn;

$aluno = new Aluno($db);
$alunos = [];
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buscar'])) {
        // Busca aluno pelo nome ou CPF
        $busca = $_POST['busca'];
        $alunos = $aluno->buscarPorNomeOuCpf($busca);
    } elseif (isset($_POST['deletar'])) {
        // Deleta aluno
        $id_aluno = $_POST['id_aluno'];

        if ($aluno->deletar($id_aluno)) {
            $mensagem = "Aluno deletado com sucesso!";
        } else {
            $mensagem = "Erro ao deletar aluno.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Alunos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/aluno/gerenciarAluno.css">
</head>
<body>

<div class="container my-5">
    <h1>Gerenciar Alunos</h1>

    <?php if ($mensagem) : ?>
        <div class="alert alert-info">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <div class="form-container mb-4">
        <form method="POST" action="gerenciar_aluno.php" class="form-inline">
            <label for="busca" class="mr-2">Nome ou CPF:</label>
            <input type="text" id="busca" name="busca" class="form-control mr-2" required>
            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
        </form>
    </div>

    <?php if (!empty($alunos)) : ?>
        <h2 class="mt-4">Resultados da Busca:</h2>
        <div class="card-container">
            <?php foreach ($alunos as $alu) : ?>
                <div class="card aluno-card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $alu['nome_aluno']; ?></h5>
                        <p class="card-text"><strong>CPF:</strong> <?= $alu['cpf_aluno']; ?></p>
                        <p class="card-text"><strong>Email:</strong> <?= $alu['email']; ?></p>
                        <a href="editar_aluno.php?id_aluno=<?= $alu['id_aluno']; ?>" class="btn btn-success btn-sm">Editar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($_POST['buscar'])) : ?>
        <p class="text-center text-muted">Nenhum aluno encontrado.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="cadastrar_aluno.php" class="btn btn-secondary btn-lg">Cadastrar Novo Aluno</a>
    </div>

    <div class="text-center mt-3">
        <a href="../includes/admin_home.php" class="btn btn-outline-primary">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
session_start();
include_once 'db.php';
include_once '../includes/class/SalaAluno.php';

$database = new Database();
$db = $database->conn;

$salaAluno = new SalaAluno($db);
$alunosNaSala = [];
$mensagem = '';

// ID da sala (pode vir de um parâmetro GET, por exemplo)
$id_sala = isset($_GET['id_sala']) ? $_GET['id_sala'] : 0;

// Listar alunos cadastrados na sala
if ($id_sala > 0) {
    $alunosNaSala = $salaAluno->listarAlunosNaSala($id_sala);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar dados do formulário de edição
    $id_sa = $_POST['id_sa'];
    $aluno_sa = $_POST['aluno_sa'];
    $ativo_sa = $_POST['ativo_sa'];

    // Atualizar os dados do aluno na sala
    if ($salaAluno->atualizar($id_sa, $aluno_sa, $ativo_sa)) {
        $mensagem = "Aluno atualizado com sucesso!";
        // Opcional: redirecionar ou atualizar a lista após a edição
    } else {
        $mensagem = "Erro ao atualizar aluno.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Alunos na Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/room/viewAlunoRoom.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 titulo-azul fadeIn">Editar Alunos na Sala</h1>
        <h2 class="mb-4">Alunos Cadastrados</h2>

        <?php if ($mensagem): ?>
            <div class="alert alert-info fadeIn" role="alert"><?= $mensagem; ?></div>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($alunosNaSala as $aluno): ?>
                <div class="col-md-4 mb-4">
                    <div class="card fadeIn">
                        <div class="card-body">
                            <h5 class="card-title"><?= $aluno['nome_aluno']; ?></h5>
                            <p class="card-text">Situação: <?= $aluno['nome_situacao']; ?></p>
                            <a href="../includes/editar_sala_aluno.php?id_sa=<?= $aluno['id_sa']; ?>" class="btn btn-success btn-sm transition">Editar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="gerenciar_salas.php" class="btn btn-outline-success w-100 mt-4 transition">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


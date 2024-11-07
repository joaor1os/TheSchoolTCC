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
</head>
<body>
    <h1>Editar Alunos na Sala</h1>
    <h2>Alunos Cadastrados</h2>

    <?php if ($mensagem): ?>
        <p><?= $mensagem; ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>Nome do Aluno</th>
            <th>Situação</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($alunosNaSala as $aluno): ?>
            <tr>
                <td><?= $aluno['nome_aluno']; ?></td>
                <td><?= $aluno['nome_situacao']; ?></td>
                <td>
                    <a href="../includes/editar_sala_aluno.php?id_sa=<?= $aluno['id_sa']; ?>"><button>Editar</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="gerenciar_salas.php"><button>Voltar</button></a>
</body>
</html>

<?php
session_start();

include_once 'db.php';
include_once '../includes/class/Aluno.php';

$database = new Database();
$db = $database->conn;

$aluno = new Aluno($db);
$mensagem = '';
$alunoEdicao = null;
$situacoes = [];

// Verifica se o ID do aluno foi passado na URL
if (isset($_GET['id_aluno'])) {
    $id_aluno = $_GET['id_aluno'];
    $alunoEdicao = $aluno->buscarPorId($id_aluno);

    // Verifica se o aluno foi encontrado
    if (!$alunoEdicao) {
        $mensagem = "Aluno não encontrado.";
    }
}

// Recupera as opções de situação da tabela 'situacao'
$querySituacao = "SELECT id_situacao, nome_situacao FROM situacao";
$stmt = $db->prepare($querySituacao);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $situacoes[] = $row;
}

// Lógica para atualizar aluno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $id_aluno = $_POST['id_aluno'];
    $aluno->setNomeAluno($_POST['nome_aluno']);
    $aluno->setCpfAluno($_POST['cpf_aluno']);
    $aluno->setDataNascimentoAluno($_POST['data_nascimento_aluno']);
    $aluno->setSexoAluno($_POST['sexo_aluno']);
    $aluno->setSituacaoAluno($_POST['situacao_aluno']);
    $aluno->setContatoAluno($_POST['contato_aluno']);
    $aluno->setEmail($_POST['email']);

    if ($aluno->atualizar($id_aluno)) {
        $msg = "Aluno atualizado com sucesso!";
        echo "<script>
                alert('$msg');
                window.location.href = 'gerenciar_aluno.php';
              </script>";
    } else {
        $mensagem = "Erro ao atualizar aluno.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/aluno/editAluno.css">
</head>
<body>

<div class="container my-5">
    <h1>Editar Aluno</h1>

    <?php if ($mensagem) : ?>
        <div class="alert alert-info">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <?php if ($alunoEdicao) : ?>
        <div class="card aluno-card">
            <div class="card-body">
                <form method="POST" action="editar_aluno.php">
                    <input type="hidden" name="id_aluno" value="<?= $alunoEdicao['id_aluno']; ?>">

                    <div class="form-group">
                        <label for="nome_aluno">Nome:</label>
                        <input type="text" id="nome_aluno" name="nome_aluno" class="form-control" value="<?= $alunoEdicao['nome_aluno']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="cpf_aluno">CPF:</label>
                        <input type="text" id="cpf_aluno" name="cpf_aluno" class="form-control" value="<?= $alunoEdicao['cpf_aluno']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="data_nascimento_aluno">Data de Nascimento:</label>
                        <input type="date" id="data_nascimento_aluno" name="data_nascimento_aluno" class="form-control" value="<?= $alunoEdicao['data_nascimento_aluno']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="sexo_aluno">Sexo:</label>
                        <input type="text" id="sexo_aluno" name="sexo_aluno" class="form-control" value="<?= $alunoEdicao['sexo_aluno']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="situacao_aluno">Situação:</label>
                        <select id="situacao_aluno" name="situacao_aluno" class="form-control" required>
                            <?php foreach ($situacoes as $situacao) : ?>
                                <option value="<?= $situacao['id_situacao']; ?>" <?= $alunoEdicao['situacao_aluno'] == $situacao['id_situacao'] ? 'selected' : ''; ?>>
                                    <?= $situacao['nome_situacao']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contato_aluno">Contato:</label>
                        <input type="text" id="contato_aluno" name="contato_aluno" class="form-control" value="<?= $alunoEdicao['contato_aluno']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= $alunoEdicao['email']; ?>" required>
                    </div>

                    <button type="submit" name="salvar" class="btn btn-success btn-lg btn-block">Salvar</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Não foi possível encontrar os dados do aluno para edição.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="gerenciar_aluno.php" class="btn btn-outline-primary">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

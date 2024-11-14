<?php
session_start(); // Inicia a sessão


include_once 'db.php';
include_once '../includes/class/Aluno.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->conn;

    $aluno = new Aluno($db);
    $aluno->setNomeAluno($_POST['nome_aluno']);
    $aluno->setCpfAluno($_POST['cpf_aluno']);
    $aluno->setDataNascimentoAluno($_POST['data_nascimento_aluno']);
    $aluno->setSexoAluno($_POST['sexo_aluno']);
    $aluno->setContatoAluno($_POST['contato_aluno']);
    $aluno->setEmail($_POST['email']);
    $aluno->generateAndSetPassword(); // Gera a senha automaticamente

    if ($aluno->cadastrar()) {
        $mensagem = "Aluno cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar o aluno. Verifique os dados e tente novamente.";
    }

    $database->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Cadastrar Novo Aluno</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/aluno/registerAluno.css">
</head>
<body>

<div class="container my-5">
    <h1>Cadastrar Novo Aluno</h1>

    <?php if (isset($mensagem)) : ?>
        <div class="alert alert-info">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <div class="card aluno-card">
        <div class="card-body">
            <form action="cadastrar_aluno.php" method="POST">

                <div class="form-group">
                    <label for="nome_aluno">Nome do Aluno:</label>
                    <input type="text" id="nome_aluno" name="nome_aluno" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="cpf_aluno">CPF:</label>
                    <input type="text" id="cpf_aluno" name="cpf_aluno" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="data_nascimento_aluno">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento_aluno" name="data_nascimento_aluno" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="sexo_aluno">Sexo:</label>
                    <select id="sexo_aluno" name="sexo_aluno" class="form-control" required>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="contato_aluno">Contato:</label>
                    <input type="text" id="contato_aluno" name="contato_aluno" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success btn-lg btn-block">Cadastrar</button>
            </form>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="../includes/gerenciar_aluno.php" class="btn btn-outline-primary">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>


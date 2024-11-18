<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../includes/login_instituicional.php"); 
    exit();
}

include_once 'db.php';
include_once '../includes/class/funcionario_instituicao.php';

$database = new Database();
$db = $database->conn;

$funcionario = new funcionario_instituicao($db);
$mensagem = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Limpa o CPF para remover caracteres não numéricos
    $cpf_funcionario = preg_replace('/\D/', '', $_POST['cpf_funcionario']);
    
    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf_funcionario) !== 11) {
        $mensagem = "CPF deve conter 11 dígitos.";
        
    } else {
        // Cadastrar novo funcionario$funcionario
        $funcionario->setNomeFuncionario($_POST['nome_funcionario']);
        $funcionario->setCpfFuncionario($cpf_funcionario); // Usar o CPF limpo
        $funcionario->setDataNascimentoFuncionario($_POST['data_nascimento_funcionario']);
        $funcionario->setSexoFuncionario($_POST['sexo_funcionario']);
        $funcionario->setSituacaoFuncionario($_POST['situacao_funcionario']);
        $funcionario->setContatoFuncionario($_POST['contato_funcionario']);
        $funcionario->setTipoFuncionario($_POST['tipo_funcionario']);
        $funcionario->setEmail($_POST['email']);
        $funcionario->generateAndSetPassword(); // Gera e define a senha automaticamente

        if ($funcionario->cadastrar()) {
            $mensagem = "funcionario cadastrado com sucesso!";
            echo "<script>
                alert('$mensagem');
                window.location.href = 'gerenciar_funcionario_instituicao.php';
              </script>";
        } else {
            $mensagem = "Erro ao cadastrar funcionario$funcionario.";
        }
    }
}
?>

    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar funcionario</title>
        <link rel="stylesheet" href="../css/Colaborador/registerFuncionario.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
<body>
    <h1>Cadastrar Novo Colaborador</h1>

    <?php if ($mensagem) : ?>
        <p class="mensagem"><?= $mensagem ?></p>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="cadastrar_funcionario.php" onsubmit="return validarFormulario();">
            <div class="mb-3">
                <label for="nome_funcionario" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome_funcionario" name="nome_funcionario" required>
            </div>

            <div class="mb-3">
                <label for="cpf_funcionario" class="form-label">CPF:</label>
                <input type="text" class="form-control" id="cpf_funcionario" name="cpf_funcionario" required>
            </div>

            <div class="mb-3">
                <label for="data_nascimento_funcionario" class="form-label">Data de Nascimento:</label>
                <input type="date" min="1910-01-01" max="2019-12-31"  class="form-control" id="data_nascimento_funcionario" name="data_nascimento_funcionario" required>
            </div>

            <div class="mb-3">
                <label for="sexo_funcionario" class="form-label">Sexo:</label>
                <select class="form-select" id="sexo_funcionario" name="sexo_funcionario" required>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="situacao_funcionario" class="form-label">Situação:</label>
                <select class="form-select" id="situacao_funcionario" name="situacao_funcionario" required>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="contato_funcionario" class="form-label">Contato:</label>
                <input type="text" class="form-control" id="contato_funcionario" name="contato_funcionario" required>
            </div>

            <div class="mb-3">
                <label for="tipo_funcionario" class="form-label">Tipo de Funcionário:</label>
                <select class="form-select" id="tipo_funcionario" name="tipo_funcionario" required>
                    <option value="1">Administrativo</option>
                    <option value="2">Professor</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

        <br>
        <a href="../includes/gerenciar_funcionario_instituicao.php">Voltar para Gerenciamento de Colaboradores</a>
    </div>

    <script src="../js/validaCpf.js"></script>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

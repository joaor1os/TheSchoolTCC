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
    <script>
        // Função para validar CPF (exemplo simples, pode ser adaptado para uma validação completa)
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, ''); // Remove qualquer caractere que não seja número
            if (cpf.length !== 11) {
                return false;
            }
            return true;
        }

        // Função para validar o formulário
        function validarFormulario() {
            var nome = document.getElementById("nome_funcionario").value;
            var cpf = document.getElementById("cpf_funcionario").value;
            var email = document.getElementById("email").value;
            var contato = document.getElementById("contato_funcionario").value;

            var errorMessage = "";

            // Verifica se o nome está preenchido
            if (nome === "") {
                errorMessage += "O campo Nome é obrigatório.\n";
            }

            // Valida o CPF
            if (!validarCPF(cpf)) {
                errorMessage += "CPF inválido. Deve conter 11 dígitos.\n";
            }

            // Verifica se o email está no formato correto
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorMessage += "Formato de email inválido.\n";
            }

            // Verifica se o campo de contato está preenchido
            if (contato === "") {
                errorMessage += "O campo Contato é obrigatório.\n";
            }

            // Exibe os erros, se houver
            if (errorMessage !== "") {
                alert(errorMessage);  // Mostra os erros em um alert
                return false;  // Impede o envio do formulário
            }

            return true;  // Permite o envio do formulário se não houver erros
        }
    </script>
</head>
<body>
    <h1>Cadastrar Novo Colaborador</h1>

    <?php if ($mensagem) : ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="POST" action="cadastrar_funcionario.php" onsubmit="return validarFormulario();">
        <label for="nome_funcionario">Nome:</label>
        <input type="text" id="nome_funcionario" name="nome_funcionario" required><br><br>

        <label for="cpf_funcionario">CPF:</label>
        <input type="text" id="cpf_funcionario" name="cpf_funcionario" required><br><br>


        <label for="data_nascimento_funcionario">Data de Nascimento:</label>
        <input type="date" id="data_nascimento_funcionario" name="data_nascimento_funcionario" required><br><br>

        <label for="sexo_funcionario">Sexo:</label>
        <select id="sexo_funcionario" name="sexo_funcionario" required>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select><br><br>

        <label for="situacao_funcionario">Situação:</label>
        <select id="situacao_funcionario" name="situacao_funcionario" required>
            <option value="1">Ativo</option>
            <option value="2">Inativo</option>
        </select><br><br>

        <label for="contato_funcionario">Contato:</label>
        <input type="text" id="contato_funcionario" name="contato_funcionario" required><br><br>

        <label for="tipo_funcionario">Tipo de Funcionário:</label>
        <select id="tipo_funcionario" name="tipo_funcionario" required>
            <option value="1">Administrativo</option>
            <option value="2">Professor</option>
        </select><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="../includes/gerenciar_funcionario_instituicao.php">Voltar para Gerenciamento de Colaboradores</a>
</body>
</html>

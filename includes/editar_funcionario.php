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

$funcionario_instituicao = new funcionario_instituicao($db);
$mensagem = '';
$funcionarioEdicao = null;

if (isset($_GET['id'])) {
    $id_funcionario = $_GET['id'];
    $funcionarioEdicao = $funcionario_instituicao->buscarPorId($id_funcionario); // Método que busca dados pelo ID
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_funcionario = $_POST['id_funcionario'];
    
    // Limpa o CPF para remover caracteres não numéricos
    $cpf_funcionario = preg_replace('/\D/', '', $_POST['cpf_funcionario']);
    
    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf_funcionario) !== 11) {
        $mensagem = "CPF deve conter 11 dígitos.";
    } else {
        $funcionario_instituicao->setNomeFuncionario($_POST['nome_funcionario']);
        $funcionario_instituicao->setCpfFuncionario($cpf_funcionario); // Usar o CPF limpo
        $funcionario_instituicao->setDataNascimentoFuncionario($_POST['data_nascimento_funcionario']);
        $funcionario_instituicao->setSexoFuncionario($_POST['sexo_funcionario']);
        $funcionario_instituicao->setSituacaoFuncionario($_POST['situacao_funcionario']);
        $funcionario_instituicao->setContatoFuncionario($_POST['contato_funcionario']);
        $funcionario_instituicao->setTipoFuncionario($_POST['tipo_funcionario']);
        $funcionario_instituicao->setEmail($_POST['email']);

        if ($funcionario_instituicao->atualizar($id_funcionario)) {
            $msg = "Colaborador atualizado com sucesso!";
            echo "<script>
                alert('$msg');
                window.location.href = 'gerenciar_funcionario_instituicao.php';
              </script>";
        } else {
            $mensagem = "Erro ao atualizar colaborador$funcionario_instituicao.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
</head>
<title>Editar Professor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJx3v3nI3j0f1vZ1Kd7zIaXoBhVG4+zJcJbFV1Hp0F4aD+Xz7+zjntjxkaCK" crossorigin="anonymous">
<link rel="stylesheet" href="../css/Colaborador/editFuncionario.css">
<body>

    <h1>Editar Professor</h1>

    <?php if ($mensagem) : ?>
        <p class="mensagem"><?= $mensagem ?></p>
    <?php endif; ?>

    <?php if ($funcionarioEdicao) : ?>
        <div class="form-container">
            <form method="POST" action="editar_funcionario.php?id=<?= $funcionarioEdicao['id_funcionario']; ?>" onsubmit="return validarFormulario();">
                <div class="mb-3">
                    <label for="nome_funcionario" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="nome_funcionario" name="nome_funcionario" value="<?= $funcionarioEdicao['nome_funcionario']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="cpf_funcionario" class="form-label">CPF:</label>
                    <input type="text" class="form-control" id="cpf_funcionario" name="cpf_funcionario" value="<?= $funcionarioEdicao['cpf_funcionario']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="data_nascimento_funcionario" class="form-label">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="data_nascimento_funcionario" name="data_nascimento_funcionario" value="<?= $funcionarioEdicao['data_nascimento_funcionario']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="sexo_funcionario" class="form-label">Sexo:</label>
                    <select class="form-select" id="sexo_funcionario" name="sexo_funcionario" required>
                        <option value="M" <?= $funcionarioEdicao['sexo_funcionario'] == 'M' ? 'selected' : ''; ?>>Masculino</option>
                        <option value="F" <?= $funcionarioEdicao['sexo_funcionario'] == 'F' ? 'selected' : ''; ?>>Feminino</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="situacao_funcionario" class="form-label">Situação:</label>
                    <select class="form-select" id="situacao_funcionario" name="situacao_funcionario" required>
                        <option value="1" <?= $funcionarioEdicao['situacao_funcionario'] == 1 ? 'selected' : ''; ?>>Ativo</option>
                        <option value="2" <?= $funcionarioEdicao['situacao_funcionario'] == 2 ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="contato_funcionario" class="form-label">Contato:</label>
                    <input type="text" class="form-control" id="contato_funcionario" name="contato_funcionario" value="<?= $funcionarioEdicao['contato_funcionario']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tipo_funcionario" class="form-label">Tipo:</label>
                    <select class="form-select" id="tipo_funcionario" name="tipo_funcionario" required>
                        <option value="1" <?= $funcionarioEdicao['tipo_funcionario'] == 1 ? 'selected' : ''; ?>>Administrativo</option>
                        <option value="2" <?= $funcionarioEdicao['tipo_funcionario'] == 2 ? 'selected' : ''; ?>>Professor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $funcionarioEdicao['email']; ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="gerenciar_funcionario_instituicao.php">Voltar para Gerenciar Colaboradores</a>
            </form>
        </div>
    <?php else : ?>
        <p>Colaborador não encontrado.</p>
    <?php endif; ?>

  

    <script src="../js/validaCpf.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
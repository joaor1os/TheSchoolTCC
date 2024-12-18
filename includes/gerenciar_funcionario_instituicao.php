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
$funcionarios = [];
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buscar'])) {
        // Busca funcionário pelo nome ou CPF
        $busca = $_POST['busca'];
        $funcionarios = $funcionario_instituicao->buscarPorNomeOuCpf($busca);
    } elseif (isset($_POST['deletar'])) {
        // Deleta funcionário
        $id_funcionario = $_POST['id_funcionario'];

        if ($funcionario_instituicao->deletar($id_funcionario)) {
            $mensagem = "Funcionário deletado com sucesso!";
        } else {
            $mensagem = "Erro ao deletar funcionário.";
        }
    }
} else {
    // Exibe apenas funcionários ativos
    $funcionarios = $funcionario_instituicao->buscarFuncionariosAtivos();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Colaboradores</title>
    <link rel="stylesheet" href="../css/Colaborador/gerenciarFuncionario.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciar Colaboradores</h1>

        <?php if ($mensagem) : ?>
            <p class="message"><?= $mensagem ?></p>
        <?php endif; ?>

        <!-- Formulário de busca -->
        <form method="POST" action="gerenciar_funcionario_instituicao.php">
            <label for="busca">Nome ou CPF:</label>
            <input type="text" id="busca" name="busca" required>
            <button type="submit" name="buscar">Buscar</button>
        </form>

        <!-- Resultados da busca -->
        <?php if (!empty($funcionarios)) : ?>
            <div class="card-grid">
                <?php foreach ($funcionarios as $func) : ?>
                    <div class="card">
                        <h2><?= $func['nome_funcionario']; ?></h2>
                        <p>CPF: <?= $func['cpf_funcionario']; ?></p>
                        <p>Email: <?= $func['email']; ?></p>
                        <div class="action-buttons">
                            <a href="editar_funcionario.php?id=<?= $func['id_funcionario']; ?>">
                                <button class="edit">Editar</button>
                            </a>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (isset($_POST['buscar'])) : ?>
            <p class="message">Nenhum funcionário encontrado.</p>
        <?php endif; ?>

        <div class="button-container">
            <a href="cadastrar_funcionario.php"><button>Cadastrar Novo Colaborador</button></a>
            <a href="../includes/admin_home.php"><button>Voltar</button></a>
        </div>
    </div>
</body>
</html>



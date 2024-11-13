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
</head>
<body>
    <h1>Gerenciar Colaboradores</h1>

    <?php if ($mensagem) : ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <!-- Formulário de busca -->
    <form method="POST" action="gerenciar_funcionario_instituicao.php">
        <label for="busca">Nome ou CPF:</label>
        <input type="text" id="busca" name="busca" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <!-- Resultados da busca -->
    <?php if (!empty($funcionarios)) : ?>
        
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($funcionarios as $func) : ?>
                <tr>
                    <td><?= $func['nome_funcionario']; ?></td>
                    <td><?= $func['cpf_funcionario']; ?></td>
                    <td><?= $func['email']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_funcionario" value="<?= $func['id_funcionario']; ?>">
                            <a href="editar_funcionario.php?id=<?= $func['id_funcionario']; ?>"><button type="button">Editar</button></a>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($_POST['buscar'])) : ?>
        <p>Nenhum funcionário encontrado.</p>
    <?php endif; ?>

    <br><br>
    <a href="cadastrar_funcionario.php"><button>Cadastrar Novo Colaborador</button></a>
    <a href="../includes/admin_home.php">Voltar</a>
</body>
</html>

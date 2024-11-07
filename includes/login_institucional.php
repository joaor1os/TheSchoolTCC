<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database(); // Instancia a classe Database
$conn = $db->conn; // Obtém a conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados enviados pelo formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário é um funcionário do tipo 1
    $query_funcionario = "SELECT id_funcionario, senha FROM funcionario_instituicao WHERE email = ? AND tipo_funcionario = 1";
    $stmt_funcionario = $conn->prepare($query_funcionario);
    $stmt_funcionario->bind_param("s", $email);
    $stmt_funcionario->execute();
    $result_funcionario = $stmt_funcionario->get_result();

    if ($result_funcionario->num_rows > 0) {
        $row_funcionario = $result_funcionario->fetch_assoc();
        // Verifica a senha usando password_verify
        if (password_verify($senha, $row_funcionario['senha'])) {
            // Funcionário autenticado
            $_SESSION['user_id'] = $row_funcionario['id_funcionario'];
            header("Location: pagina_funcionario.php"); // Redireciona para a página do funcionário
            exit();
        } else {
            $login_error = "Email ou senha incorretos.";
        }
    } else {
        // Verificar se o usuário é um usuário da instituição
        $query_usuario = "SELECT id_instituicao FROM instituicao WHERE email = ?"; // A tabela se chama 'instituicao'
        $stmt_usuario = $conn->prepare($query_usuario);
        $stmt_usuario->bind_param("s", $email);
        $stmt_usuario->execute();
        $result_usuario = $stmt_usuario->get_result();

        if ($result_usuario->num_rows > 0) {
            // Usuário da instituição autenticado (sem verificação de senha)
            $row_usuario = $result_usuario->fetch_assoc();
            $_SESSION['user_id'] = $row_usuario['id_instituicao'];
            header("Location: admin_home.php"); // Redireciona para a página do usuário da instituição
            exit();
        } else {
            $login_error = "Email ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Funcionário</title>
</head>
<body>
    <h2>Login Institucional</h2>
    <?php if (isset($login_error)) echo "<p style='color:red;'>$login_error</p>"; ?>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>


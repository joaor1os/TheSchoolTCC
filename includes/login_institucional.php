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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>Login Funcionário</title>
    <!-- Incluindo o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center text-primary mb-4">Login Institucional</h2>

                    <!-- Exibindo erro de login -->
                    <?php if (isset($login_error)): ?>
                        <p class="text-danger text-center"><?= $login_error ?></p>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" name="senha" id="senha" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <!-- Botão para voltar à página inicial -->
                    <a href="../index.php" class="btn btn-secondary w-100 mt-3">Voltar à Home</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluindo o Bootstrap JS (se necessário para componentes interativos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



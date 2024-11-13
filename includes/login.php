<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database(); // Instancia a classe Database
$conn = $db->conn; // Obtém a conexão

// Redireciona se o usuário já está logado e o tipo de usuário foi definido
if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'professor') {
        header("Location: professor_home.php");
        exit();
    } elseif ($_SESSION['user_type'] === 'aluno') {
        header("Location: aluno_home.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o usuário é um professor
    $query_professor = "SELECT id_funcionario, senha FROM funcionario_instituicao WHERE email = ? AND tipo_funcionario = 2";
    $stmt_professor = $conn->prepare($query_professor);
    $stmt_professor->bind_param("s", $email);
    $stmt_professor->execute();
    $result_professor = $stmt_professor->get_result();

    if ($result_professor->num_rows > 0) {
        $row_professor = $result_professor->fetch_assoc();
        if (password_verify($senha, $row_professor['senha'])) {
            // Professor autenticado
            $_SESSION['user_id'] = $row_professor['id_funcionario'];
            $_SESSION['user_type'] = 'professor';
            header("Location: professor_home.php");
            exit();
        } else {
            $login_error = "Email ou senha incorretos.";
        }
    } else {
        // Verifica se o usuário é um aluno
        $query_aluno = "SELECT matricula_aluno, senha FROM aluno WHERE email = ?";
        $stmt_aluno = $conn->prepare($query_aluno);
        $stmt_aluno->bind_param("s", $email);
        $stmt_aluno->execute();
        $result_aluno = $stmt_aluno->get_result();

        if ($result_aluno->num_rows > 0) {
            $row_aluno = $result_aluno->fetch_assoc();
            if (password_verify($senha, $row_aluno['senha'])) {
                // Aluno autenticado
                $_SESSION['user_id'] = $row_aluno['matricula_aluno'];
                $_SESSION['user_type'] = 'aluno';
                header("Location: aluno_home.php");
                exit();
            } else {
                $login_error = "Email ou senha incorretos.";
            }
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
<<<<<<< HEAD
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>Login Aluno</title>
    <!-- Incluindo o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center text-primary mb-4">Login Aluno</h2>

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

=======
    <title>Login Acadêmico</title>
</head>
<body>
    <h2>Login Acadêmico</h2>
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
>>>>>>> 987d6520ee9329409f685eed70eb524d45753122

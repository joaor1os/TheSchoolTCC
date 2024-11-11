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

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../includes/login_instituicional.php"); 
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial do Administrador</title>
</head>
<body>
    <h1>Bem-vindo, Administrador!</h1>
    <a href="gerenciar_funcionario_instituicao.php">Gerenciar Colaboradores</a>
    <br><br>
    <a href="gerenciar_professor.php">Gerenciar Professores</a>
    <br><br>
    <a href="gerenciar_aluno.php">Gerenciar Alunos</a>
    <br><br>
    <a href="gerenciar_salas.php">Gerenciar Salas</a>
</body>
</html>

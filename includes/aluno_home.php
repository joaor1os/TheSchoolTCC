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
</head>
<body>
<a href="includes/login.php">login Acadêmico</a>
<br><br>
<a href="includes/login_institucional.php">Login Institucional</a>
</body>
</html>
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial do Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adminpainel/adminHome.css">
</head>
<body>

    <div class="container">
        <h1 class="text-center text-primary my-5">Bem-vindo, Administrador!</h1>

        <div class="row text-center mb-4">
            <div class="col-12">
                <p class="lead">Escolha uma opção para gerenciar a instituição.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <a href="gerenciar_funcionario_instituicao.php" class="card text-decoration-none text-dark">
                    <div class="card-body">
                        <i class="bi bi-person-fill" style="font-size: 3rem; color: #007bff;"></i>
                        <h5 class="card-title">Gerenciar Colaboradores</h5>
                        <p class="card-text">Administre colaboradores da instituição.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a href="gerenciar_professor.php" class="card text-decoration-none text-dark">
                    <div class="card-body">
                        <i class="bi bi-person-gear" style="font-size: 3rem; color: #007bff;"></i>
                        <h5 class="card-title">Gerenciar Professores</h5>
                        <p class="card-text">Gerencie os dados dos professores.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a href="gerenciar_aluno.php" class="card text-decoration-none text-dark">
                    <div class="card-body">
                        <i class="bi bi-person-lines-fill" style="font-size: 3rem; color: #007bff;"></i>
                        <h5 class="card-title">Gerenciar Alunos</h5>
                        <p class="card-text">Controle as informações dos alunos.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a href="gerenciar_salas.php" class="card text-decoration-none text-dark">
                    <div class="card-body">
                        <i class="bi bi-house-door" style="font-size: 3rem; color: #007bff;"></i>
                        <h5 class="card-title">Gerenciar Salas</h5>
                        <p class="card-text">Organize as salas de aula da instituição.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The School | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
 
    <header class="py-3 shadow-sm fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <img src="./assets/img/logo_img.jfif" alt="Logotipo da Instituição" class="logo" />
        </div>
    </header>

    <!-- Seção principal -->
    <main class="pt-5 mt-5">
        <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
            <div class="text-center mb-5">
                <h2 class="mb-4">Bem-vindo à The School</h2>
                <p class="mb-5">Acesse as áreas de login. Escolha abaixo o tipo de login que você deseja acessar.</p>
                <div class="d-grid gap-2">
                    <a href="includes/login.php" class="btn btn-primary btn-lg login-btn">Login Aluno / Professor</a>
                    <a href="includes/login_institucional.php" class="btn btn-secondary btn-lg login-btn">Login Institucional</a>
                </div>
            </div>
        </div>

      
        <div class="news-section mb-5">
            <h3 class="mb-4">Últimas Notícias</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="" class="card-img-top" alt="Notícia 1">
                        <div class="card-body">
                            <h5 class="card-title">...</h5>
                            <p class="card-text">...</p>
                            <a href="#" class="btn btn-primary">Leia Mais</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="" class="card-img-top" alt="Notícia 2">
                        <div class="card-body">
                            <h5 class="card-title">...</h5>
                            <p class="card-text">...</p>
                            <a href="#" class="btn btn-primary">Leia Mais</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <img src="" class="card-img-top" alt="Notícia 3">
                        <div class="card-body">
                            <h5 class="card-title">...</h5>
                            <p class="card-text">....</p>
                            <a href="#" class="btn btn-primary">Leia Mais</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <!-- Rodapé -->
    <footer class="text-center py-3">
        <p class="text-white mb-0">© 2024 The School. Todos os direitos reservados.</p>
    </footer>

    <!-- JS do Bootstrap (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/api.js"></script>

</body>

</html>

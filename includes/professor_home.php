<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    $professor_id = $_SESSION['user_id'];

    // Consulta as salas ativas do professor, agora incluindo o nome_serie da tabela 'serie'
    $query_salas = "
        SELECT s.id_sala, s.ano_sala, se.nome_serie 
        FROM salas s 
        JOIN sala_professor sp ON s.id_sala = sp.sala_sp 
        LEFT JOIN serie se ON s.serie_sala = se.id_serie
        WHERE sp.professor_sp = ? AND s.ativa_sala = 1
    ";
    $stmt_salas = $conn->prepare($query_salas);
    $stmt_salas->bind_param("i", $professor_id);
    $stmt_salas->execute();
    $result_salas = $stmt_salas->get_result();
} else {
    // Redireciona para a página de login caso o usuário não seja um professor
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salas Ativas do Professor</title>
    <!-- Link para o Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Link para o CSS personalizado -->
    <link rel="stylesheet" href="../css/Professor/professorHome.css">
</head>
<body>

    <div class="container">
        <h1>Salas Ativas do Professor</h1>

        <?php if ($result_salas->num_rows > 0) : ?>
            <div class="card-container">
                <?php while ($sala = $result_salas->fetch_assoc()) : ?>
                    <div class="card">
                        <h2>ID da Sala: <?php echo $sala['id_sala']; ?></h2>
                        <p><strong>Ano:</strong> <?php echo $sala['ano_sala']; ?></p>
                        <p><strong>Série:</strong> <?php echo $sala['nome_serie']; ?></p>

                        
                        <button class="btn btn-primary" onclick="confirmarCriacaoAula(<?php echo $sala['id_sala']; ?>)">Registrar Aula</button>
                        <a href="visualizar_aulas.php?sala_id=<?php echo $sala['id_sala']; ?>" class="btn btn-primary">Visualizar Aulas</a>
                        <a href="registrar_notas.php?sala_id=<?php echo $sala['id_sala']; ?>" class="btn btn-primary">Registrar Notas</a>
                        <a href="visualizar_notas.php?sala_id=<?php echo $sala['id_sala']; ?>" class="btn btn-primary">Visualizar Notas</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="alert alert-warning">Nenhuma sala ativa encontrada.</p>
        <?php endif; ?>

        <a href="../index.php" class="btn btn-secondary">Voltar para a Home</a>
    </div>

    <script src="../js/confirmedClass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>



<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    $professor_id = $_SESSION['user_id'];

    // Verifica se o id_sala foi passado na URL
    if (isset($_GET['sala_id'])) {
        $sala_id = $_GET['sala_id'];

        // Consulta as aulas do professor para a sala específica
        $query_aulas = "
            SELECT a.id_aula, a.data_aula, s.ano_sala, ser.nome_serie, d.nome_disciplina 
            FROM aulas a
            JOIN salas s ON a.sala_aula = s.id_sala
            JOIN serie ser ON s.serie_sala = ser.id_serie
            JOIN professor p ON a.disciplina_aula = p.disciplina_professor
            JOIN disciplinas d ON a.disciplina_aula = d.id_disciplina
            WHERE p.id_professor = ? AND s.id_sala = ?
        ";

        $stmt_aulas = $conn->prepare($query_aulas);
        $stmt_aulas->bind_param("ii", $professor_id, $sala_id);
        $stmt_aulas->execute();
        $result_aulas = $stmt_aulas->get_result();
    } else {
        echo "Sala não especificada.";
        exit();
    }
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
    <title>Visualizar Aulas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Professor/viewAulas.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Aulas Dadas</h1>

        <?php if ($result_aulas->num_rows > 0) : ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>    
                        <th>Data da Aula</th>
                        <th>Ano</th>
                        <th>Série</th>
                        <th>Disciplina</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($aula = $result_aulas->fetch_assoc()) : ?>
                        <?php 
                            // Formatar a data
                            $data_formatada = date('d/m/Y', strtotime($aula['data_aula']));
                        ?>
                        <tr>
                            <td><?php echo $data_formatada; ?></td>
                            <td><?php echo $aula['ano_sala']; ?></td>
                            <td><?php echo $aula['nome_serie']; ?></td>
                            <td><?php echo $aula['nome_disciplina']; ?></td>
                            <td>
                                <a href="ver_presencas.php?aula_id=<?php echo $aula['id_aula']; ?>&sala_id=<?php echo $sala_id; ?>">
                                    <button class="btn btn-info">Ver Presenças</button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Nenhuma aula encontrada.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="professor_home.php" class="btn btn-secondary">Voltar para a Home</a>
        </div>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

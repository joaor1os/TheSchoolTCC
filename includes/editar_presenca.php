<?php
session_start();
include_once 'db.php';

// Conectar ao banco de dados
$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    // Recupera os parâmetros de ID passados pela URL
    if (isset($_GET['presenca_id']) && isset($_GET['aula_id']) && isset($_GET['sala_id'])) {
        $presenca_id = $_GET['presenca_id'];
        $aula_id = $_GET['aula_id'];
        $sala_id = $_GET['sala_id'];

        // Recupera a presença atual do aluno
        $query = "SELECT p.id_presenca, p.aula_presenca, a.nome_aluno
                  FROM presenca_aulas p
                  JOIN aluno a ON a.id_aluno = p.aluno_presenca
                  WHERE p.id_presenca = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $presenca_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se não encontrar a presença
        if ($result->num_rows == 0) {
            echo "Presença não encontrada.";
            exit();
        }

        $presenca = $result->fetch_assoc();
    } else {
        echo "Dados de presença inválidos.";
        exit();
    }

    // Processa a alteração da presença
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['presenca'])) {
            $nova_presenca = $_POST['presenca'];

            // Atualiza a presença
            $update_query = "UPDATE presenca_aulas SET aula_presenca = ? WHERE id_presenca = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $nova_presenca, $presenca_id);
            $update_stmt->execute();

            // Redireciona de volta para a página de listagem de presenças
            header("Location: ver_presencas.php?aula_id=$aula_id&sala_id=$sala_id");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Presença</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/Presenca/editPresenca.css">
</head>
<body class="bg-light">

  
    <div class="container mt-5 pt-5">
        <h1 class="text-center mb-4 fade-in">Editar Presença de <?= htmlspecialchars($presenca['nome_aluno']); ?></h1>

        <div class="card shadow-sm mb-4 slide-in">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Editar Status de Presença</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-check">
                        <input type="radio" name="presenca" value="P" class="form-check-input" 
                               <?php echo ($presenca['aula_presenca'] == 'P') ? 'checked' : ''; ?>>
                        <label class="form-check-label">Presente</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="presenca" value="A" class="form-check-input" 
                               <?php echo ($presenca['aula_presenca'] == 'A') ? 'checked' : ''; ?>>
                        <label class="form-check-label">Ausente</label>
                    </div>
                    <br><br>
                    <button type="submit" class="btn btn-primary w-100">Salvar Alteração</button>
                </form>
            </div>
        </div>

    
        <a href="ver_presencas.php?aula_id=<?php echo $aula_id; ?>&sala_id=<?php echo $sala_id; ?>" 
           class="btn btn-secondary btn-sm">Voltar para Listagem</a>
    </div>

</body>
</html>

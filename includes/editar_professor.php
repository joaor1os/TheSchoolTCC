<?php
include_once 'db.php';
include_once '../includes/class/Professor.php';

$db = new Database();
$conn = $db->conn;

if (isset($_GET['id_professor'])) {
    $id_professor = $_GET['id_professor'];
    
    // Busca dados do professor
    $query = "
        SELECT p.disciplina_professor, fi.nome_funcionario
        FROM professor p
        JOIN funcionario_instituicao fi ON p.id_prof_func = fi.id_funcionario
        WHERE p.id_professor = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_professor);
    $stmt->execute();
    $result = $stmt->get_result();
    $professor = $result->fetch_assoc();

    // Busca todas as disciplinas
    $disciplinas_query = "SELECT id_disciplina, nome_disciplina FROM disciplinas";
    $disciplinas_result = $conn->query($disciplinas_query);
} else {
    echo "ID do professor não especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Professor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Professor/editProf.css">
</head>
<body>

<div class="container my-5">
    <h1>Editar Professor: <?php echo $professor['nome_funcionario']; ?></h1>

    <div class="form-container">
        <form method="POST" action="processa_edicao_professor.php">
            <input type="hidden" name="id_professor" value="<?php echo $id_professor; ?>">

            <label for="disciplina_professor">Disciplina:</label>
            <select id="disciplina_professor" name="disciplina_professor">
                <?php while ($disciplina = $disciplinas_result->fetch_assoc()) : ?>
                    <option value="<?php echo $disciplina['id_disciplina']; ?>" <?php echo $professor['disciplina_professor'] == $disciplina['id_disciplina'] ? 'selected' : ''; ?>>
                        <?php echo $disciplina['nome_disciplina']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="gerenciar_professor.php" class="btn btn-secondary btn-lg">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>


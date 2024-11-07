<?php
include_once 'db.php';
include_once '../includes/class/Professor.php';

$db = new Database();
$conn = $db->conn;

if (isset($_GET['id_professor'])) {
    $id_professor = $_GET['id_professor'];
    
    // Busca dados do professor
    $query = "
        SELECT p.formacao_professor, p.disciplina_professor, fi.nome_funcionario
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
    <title>Editar Professor</title>
</head>
<body>
    <h1>Editar Professor: <?php echo $professor['nome_funcionario']; ?></h1>
    <form method="POST" action="processa_edicao_professor.php">
        <input type="hidden" name="id_professor" value="<?php echo $id_professor; ?>">

        <label for="formacao_professor">Formação:</label>
        <input type="text" id="formacao_professor" name="formacao_professor" value="<?php echo $professor['formacao_professor']; ?>" required>

        <label for="disciplina_professor">Disciplina:</label>
        <select id="disciplina_professor" name="disciplina_professor">
            <?php while ($disciplina = $disciplinas_result->fetch_assoc()) : ?>
                <option value="<?php echo $disciplina['id_disciplina']; ?>" <?php echo $professor['disciplina_professor'] == $disciplina['id_disciplina'] ? 'selected' : ''; ?>>
                    <?php echo $disciplina['nome_disciplina']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>

<?php
session_start();

include_once 'db.php';
include_once '../includes/class/SalaProfessor.php';

$database = new Database();
$db = $database->conn;

$salaProfessor = new SalaProfessor($db);

if (isset($_GET['id_sp'])) {
    $id_sp = $_GET['id_sp'];
    $professor = $salaProfessor->buscarProfessorPorId($id_sp);

    if (!$professor) {
        echo "Professor não encontrado.";
        exit;
    }

    // Busca os professores da mesma disciplina
    $professores = $salaProfessor->buscarProfessoresPorDisciplina($professor['disciplina_professor']);
} else {
    echo "ID não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Professor na Sala</title>
</head>
<body>
    <h1>Editar Professor na Sala</h1>
    <p>Professor: <?= $professor['nome_funcionario']; ?> (Disciplina: <?= $professor['disciplina_professor'] ? $professor['disciplina_professor'] : 'Disciplina não encontrada'; ?>)</p>

    <form method="POST" action="atualizar_sala_professor.php">
        <input type="hidden" name="id_sp" value="<?= $id_sp; ?>">
        <label for="professor_sp">Selecionar Novo Professor:</label>
        <select id="professor_sp" name="professor_sp" required>
            <option value="">Selecione um professor</option>
            <?php foreach ($professores as $p): ?>
                <option value="<?= $p['id_professor']; ?>" <?= ($p['id_professor'] == $professor['professor_sp']) ? 'selected' : ''; ?>>
                    <?= $p['nome_professor']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Atualizar</button>
    </form>

    <a href="visualizar_sala_professor.php"><button>Voltar</button></a>
</body>
</html>

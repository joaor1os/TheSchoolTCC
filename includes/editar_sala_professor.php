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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/room/editProfRoom.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 titulo-azul fadeIn">Editar Professor na Sala</h1>
        
        <div class="card p-4 shadow-sm mb-4">
            <p>Professor: <strong><?= $professor['nome_funcionario']; ?></strong> (Disciplina: <?= $professor['disciplina_professor'] ? $professor['disciplina_professor'] : 'Disciplina não encontrada'; ?>)</p>

            <form method="POST" action="atualizar_sala_professor.php">
                <input type="hidden" name="id_sp" value="<?= $id_sp; ?>">

                <div class="mb-3">
                    <label for="professor_sp" class="form-label">Selecionar Novo Professor:</label>
                    <select id="professor_sp" name="professor_sp" class="form-select" required>
                        <option value="">Selecione um professor</option>
                        <?php foreach ($professores as $p): ?>
                            <option value="<?= $p['id_professor']; ?>" <?= ($p['id_professor'] == $professor['professor_sp']) ? 'selected' : ''; ?>>
                                <?= $p['nome_professor']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary transition w-100">Atualizar</button>
            </form>
        </div>

        <a href="visualizar_sala_professor.php" class="btn btn-primary w-100 mt-4 transition">Voltar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


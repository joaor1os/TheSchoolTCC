<?php
session_start();

include_once 'db.php';
include_once '../includes/class/SalaProfessor.php';

$database = new Database();
$db = $database->conn;

$salaProfessor = new SalaProfessor($db);
$salas = $salaProfessor->buscarSalas();
$professoresNaSala = [];

if (isset($_GET['sala_sp'])) {
    $sala_sp = $_GET['sala_sp'];
    $professoresNaSala = $salaProfessor->listarProfessoresNaSala($sala_sp);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Professores na Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/room/viewProfRoom.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 titulo-azul fadeIn">Professores na Sala</h1>

        <form method="GET" action="visualizar_sala_professor.php" class="mb-4">
            <label for="sala_sp" class="form-label">Sala:</label>
            <select id="sala_sp" name="sala_sp" class="form-select" required onchange="this.form.submit()">
                <option value="">Selecione uma sala</option>
                <?php foreach ($salas as $sala): ?>
                    <option value="<?= $sala['id_sala']; ?>" <?= (isset($sala_sp) && $sala_sp == $sala['id_sala']) ? 'selected' : ''; ?>>
                        <?= $sala['ano_sala'] . " - " . $sala['nome_serie']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if (!empty($professoresNaSala)): ?>
            <h2 class="fadeIn">Professores Cadastrados:</h2>
            <div class="row">
                <?php foreach ($professoresNaSala as $professor): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= $professor['nome_professor']; ?></h5>
                                <p class="card-text"><strong>Disciplina:</strong> <?= $professor['disciplina']; ?></p>
                                <p class="card-text"><strong>ID:</strong> <?= $professor['id_sp']; ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <form method="GET" action="editar_sala_professor.php" style="display:inline;">
                                    <input type="hidden" name="id_sp" value="<?= $professor['id_sp']; ?>">
                                    <button type="submit" class="btn btn-success transition">Editar</button>
                                </form>
                                <form method="POST" action="excluir_sala_professor.php" style="display:inline;">
                                    <input type="hidden" name="id_sp" value="<?= $professor['id_sp']; ?>">
                                    <button type="submit" class="btn btn-danger transition" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum professor cadastrado nesta sala.</p>
        <?php endif; ?>

        <a href="gerenciar_salas.php" class="btn btn-primary w-100 mt-4 transition">Voltar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

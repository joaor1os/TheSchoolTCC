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
</head>
<body>
    <h1>Professores na Sala</h1>

    <form method="GET" action="visualizar_sala_professor.php">
        <label for="sala_sp">Sala:</label>
        <select id="sala_sp" name="sala_sp" required onchange="this.form.submit()">
            <option value="">Selecione uma sala</option>
            <?php foreach ($salas as $sala): ?>
                <option value="<?= $sala['id_sala']; ?>" <?= (isset($sala_sp) && $sala_sp == $sala['id_sala']) ? 'selected' : ''; ?>>
                    <?= $sala['ano_sala'] . " - " . $sala['nome_serie']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($professoresNaSala)): ?>
        <h2>Professores Cadastrados:</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome do Professor</th>
                <th>Disciplina</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($professoresNaSala as $professor): ?>
            <tr>
                <td><?= $professor['id_sp']; ?></td>
                <td><?= $professor['nome_professor']; ?></td>
                <td><?= $professor['disciplina']; ?></td> <!-- Exibindo a disciplina do professor -->
                <td>
                    <form method="GET" action="editar_sala_professor.php" style="display:inline;">
                        <input type="hidden" name="id_sp" value="<?= $professor['id_sp']; ?>">
                        <button type="submit">Editar</button>
                    </form>
                    <form method="POST" action="excluir_sala_professor.php" style="display:inline;">
                        <input type="hidden" name="id_sp" value="<?= $professor['id_sp']; ?>">
                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum professor cadastrado nesta sala.</p>
    <?php endif; ?>

    <a href="gerenciar_salas.php"><button>Voltar</button></a>
</body>
</html>

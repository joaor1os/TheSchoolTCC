<?php
session_start();

include_once 'db.php';
include_once '../includes/class/SalaProfessor.php';

$database = new Database();
$db = $database->conn;

$salaProfessor = new SalaProfessor($db);
$professores = $salaProfessor->buscarProfessores();
$salas = $salaProfessor->buscarSalas();

$mensagem = '';

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $professor_sp = $_POST['professor_sp'];
    $sala_sp = $_POST['sala_sp'];

    // Verifica se já existe um professor cadastrado na mesma disciplina na sala
    $disciplina_professor = null;
    $query = "SELECT disciplina_professor FROM professor WHERE id_professor = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $professor_sp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $disciplina_professor = $row['disciplina_professor'];

        // Verifica se já existe um professor da mesma disciplina na sala
        $queryVerificacao = "SELECT COUNT(*) as total FROM sala_professor WHERE sala_sp = ? AND professor_sp IN 
                             (SELECT id_professor FROM professor WHERE disciplina_professor = ?)";
        $stmtVerificacao = $db->prepare($queryVerificacao);
        $stmtVerificacao->bind_param("ii", $sala_sp, $disciplina_professor);
        $stmtVerificacao->execute();
        $verificacaoResult = $stmtVerificacao->get_result();
        $verificacaoRow = $verificacaoResult->fetch_assoc();

        if ($verificacaoRow['total'] > 0) {
            $mensagem = "Este professor já está cadastrado na sala para a disciplina correspondente!";
        } else {
            // Cadastra o professor na sala
            if ($salaProfessor->cadastrar($professor_sp, $sala_sp)) {
                $mensagem = "Professor cadastrado na sala com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar o professor na sala.";
            }
        }
    } else {
        $mensagem = "Professor não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Professor na Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/room/registerSalaProf.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 titulo-azul fadeIn">Cadastrar Professor na Sala</h1>
        
        <?php if ($mensagem): ?>
            <div class="alert alert-info fadeIn" role="alert"><?= $mensagem; ?></div>
        <?php endif; ?>

        <form method="POST" action="cadastrar_sala_professor.php">
            <div class="mb-3">
                <label for="professor_sp" class="form-label">Professor:</label>
                <select id="professor_sp" name="professor_sp" class="form-select" required>
                    <option value="">Selecione um professor</option>
                    <?php foreach ($professores as $professor): ?>
                        <option value="<?= $professor['id_professor']; ?>">
                            <?= htmlspecialchars($professor['nome_professor']); ?> - <?= htmlspecialchars($professor['disciplina']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="sala_sp" class="form-label">Sala:</label>
                <select id="sala_sp" name="sala_sp" class="form-select" required>
                    <option value="">Selecione uma sala</option>
                    <?php foreach ($salas as $sala): ?>
                        <option value="<?= $sala['id_sala']; ?>">
                            <?= htmlspecialchars($sala['ano_sala']) . " - " . htmlspecialchars($sala['nome_serie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100 transition">Cadastrar</button>
        </form>

        <a href="gerenciar_salas.php" class="btn btn-primary w-100 mt-4 transition">Voltar</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


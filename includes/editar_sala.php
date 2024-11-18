<?php
session_start();
include_once 'db.php';
include_once '../includes/class/Sala.php';

$database = new Database();
$db = $database->conn;

$sala = new Sala($db);
$salaEdicao = null; // Para armazenar os dados da sala para edição
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_sala'])) {
        // Busca a sala pelo ID
        $id_sala = $_POST['id_sala'];
        $salaEdicao = $sala->buscarPorId($id_sala);
        
        if (!$salaEdicao) {
            $mensagem = "Sala não encontrada.";
        }
    }
}

// Se a sala foi encontrada, você pode prosseguir com o carregamento do formulário
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sala</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/room/editRoom.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary">Editar Sala</h1>

        <?php if ($mensagem): ?>
            <div class="alert alert-info"><?= $mensagem ?></div>
        <?php endif; ?>

        <?php if ($salaEdicao): ?>
            <form method="POST" action="atualizar_sala.php" class="mt-4 shadow p-4 rounded">
                <input type="hidden" name="id_sala" value="<?= $salaEdicao['id_sala']; ?>">

                <div class="mb-3">
                    <label for="ano_sala" class="form-label">Ano</label>
                    <input type="number" id="ano_sala" name="ano_sala" value="<?= $salaEdicao['ano_sala']; ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="serie_sala" class="form-label">Série</label>
                    <select id="serie_sala" name="serie_sala" class="form-select" required>
                        <?php
                        $series = $sala->buscarSeries();
                        foreach ($series as $serie) {
                            $selected = ($serie['id_serie'] == $salaEdicao['serie_sala']) ? 'selected' : '';
                            echo "<option value=\"{$serie['id_serie']}\" $selected>{$serie['nome_serie']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ativa_sala" class="form-label">Situação</label>
                    <select id="ativa_sala" name="ativa_sala" class="form-select" required>
                        <?php
                        $situacoes = $sala->buscarSituacoes();
                        foreach ($situacoes as $situacao) {
                            $selected = ($situacao['id_situacao'] == $salaEdicao['ativa_sala']) ? 'selected' : '';
                            echo "<option value=\"{$situacao['id_situacao']}\" $selected>{$situacao['nome_situacao']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a href="gerenciar_salas.php" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

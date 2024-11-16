<?php
session_start();
include_once 'db.php';
include_once '../includes/class/Sala.php';

$database = new Database();
$db = $database->conn;

$sala = new Sala($db);
$mensagem = '';

// Obter o ano letivo atual
$query_ano_letivo = "SELECT ano_letivo FROM ano_letivo WHERE id_ano_letivo = 1";
$result_ano = $db->query($query_ano_letivo);
$ano_letivo_atual = $result_ano->fetch_assoc()['ano_letivo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ano_sala = $ano_letivo_atual; // Ano letivo puxado automaticamente
    $serie_sala = $_POST['serie_sala'];
    $ativa_sala = $_POST['ativa_sala'];

    if ($sala->cadastrar($ano_sala, $serie_sala, $ativa_sala)) {
        $mensagem = "Sala cadastrada com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar sala.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Sala</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/room/registerRoom.css">
</head>
<body>

<div class="container my-5">
    <h1 class="text-center">Cadastrar Sala</h1>

    <?php if ($mensagem) : ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <form method="POST" action="cadastrar_sala.php">
        <div class="form-group">
            <label for="ano_sala">Ano:</label>
            <input type="number" id="ano_sala" name="ano_sala" class="form-control" value="<?= $ano_letivo_atual ?>" readonly>
        </div>

        <div class="form-group">
            <label for="serie_sala">Série:</label>
            <select id="serie_sala" name="serie_sala" class="form-control" required>
                <?php
                // Carregar séries para o combobox
                $series = $sala->buscarSeries();
                foreach ($series as $serie) {
                    echo "<option value=\"{$serie['id_serie']}\">{$serie['nome_serie']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="ativa_sala">Ativa:</label>
            <select id="ativa_sala" name="ativa_sala" class="form-control" required>
                <?php
                // Carregar situações para o combobox
                $situacoes = $sala->buscarSituacoes();
                foreach ($situacoes as $situacao) {
                    echo "<option value=\"{$situacao['id_situacao']}\">{$situacao['nome_situacao']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success btn-lg btn-block">Cadastrar</button>
    </form>

    <div class="text-center mt-4">
        <a href="gerenciar_salas.php" class="btn btn-outline-primary btn-lg">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>

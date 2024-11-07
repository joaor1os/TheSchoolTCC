<?php
session_start();
include_once 'db.php';
include_once '../includes/class/Sala.php';

$database = new Database();
$db = $database->conn;

$sala = new Sala($db);
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ano_sala = $_POST['ano_sala'];
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
    <title>Cadastrar Sala</title>
</head>
<body>
    <h1>Cadastrar Sala</h1>

    <?php if ($mensagem) : ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <form method="POST" action="cadastrar_sala.php">
        <label for="ano_sala">Ano:</label>
        <input type="number" id="ano_sala" name="ano_sala" required>

        <label for="serie_sala">Série:</label>
        <select id="serie_sala" name="serie_sala" required>
            <?php
            // Carregar séries para o combobox
            $series = $sala->buscarSeries();
            foreach ($series as $serie) {
                echo "<option value=\"{$serie['id_serie']}\">{$serie['nome_serie']}</option>";
            }
            ?>
        </select>

        <label for="ativa_sala">Ativa:</label>
        <select id="ativa_sala" name="ativa_sala" required>
            <?php
            // Carregar situações para o combobox
            $situacoes = $sala->buscarSituacoes();
            foreach ($situacoes as $situacao) {
                echo "<option value=\"{$situacao['id_situacao']}\">{$situacao['nome_situacao']}</option>";
            }
            ?>
        </select>

        <button type="submit">Cadastrar</button>
    </form>

    <br><a href="gerenciar_salas.php">Voltar</a>
</body>
</html>

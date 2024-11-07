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
    <title>Editar Sala</title>
</head>
<body>
    <h1>Editar Sala</h1>

    <?php if ($mensagem): ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <?php if ($salaEdicao): ?>
        <form method="POST" action="atualizar_sala.php">
            <input type="hidden" name="id_sala" value="<?= $salaEdicao['id_sala']; ?>">
            
            <label for="ano_sala">Ano:</label>
            <input type="number" id="ano_sala" name="ano_sala" value="<?= $salaEdicao['ano_sala']; ?>" required>
            
            <label for="serie_sala">Série:</label>
            <select id="serie_sala" name="serie_sala" required>
                <?php
                // Exemplo de como preencher o select com as séries disponíveis
                $series = $sala->buscarSeries();
                foreach ($series as $serie) {
                    $selected = ($serie['id_serie'] == $salaEdicao['serie_sala']) ? 'selected' : '';
                    echo "<option value=\"{$serie['id_serie']}\" $selected>{$serie['nome_serie']}</option>";
                }
                ?>
            </select>

            <label for="ativa_sala">Situação:</label>
            <select id="ativa_sala" name="ativa_sala" required>
                <?php
                $situacoes = $sala->buscarSituacoes();
                foreach ($situacoes as $situacao) {
                    $selected = ($situacao['id_situacao'] == $salaEdicao['ativa_sala']) ? 'selected' : '';
                    echo "<option value=\"{$situacao['id_situacao']}\" $selected>{$situacao['nome_situacao']}</option>";
                }
                ?>
            </select>

            <button type="submit">Atualizar</button>
        </form>
    <?php endif; ?>

    <a href="gerenciar_salas.php">Voltar</a>
</body>
</html>

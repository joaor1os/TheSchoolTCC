<?php
session_start();

include_once 'db.php';
include_once '../includes/class/Sala.php';

$database = new Database();
$db = $database->conn;

$sala = new Sala($db);
$salasAtivas = [];
$salasBuscadas = [];
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buscar'])) {
        $serie = $_POST['serie_sala'];
        $ano = $_POST['ano_sala'];
        $salasBuscadas = $sala->buscarPorSerieEAno($serie, $ano);
    }
}

// Listar salas ativas
$salasAtivas = $sala->listarSalasAtivas();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Salas</title>
</head>
<body>
    <h1>Gerenciar Salas</h1>

    <h2>Salas Ativas</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Ano</th>
            <th>Série</th>
            <th>Situação</th>
            <th>Ações Aluno</th>
            <th>Ações Professor</th>
        </tr>
        <?php foreach ($salasAtivas as $salaAtiva): ?>
        <tr>
            <td><?= htmlspecialchars($salaAtiva['id_sala']); ?></td>
            <td><?= htmlspecialchars($salaAtiva['ano_sala']); ?></td>
            <td><?= htmlspecialchars($salaAtiva['nome_serie']); ?></td>
            <td><?= htmlspecialchars($salaAtiva['nome_situacao']); ?></td>
            <td>
                <!-- Link para cadastrar aluno na sala ativa -->
                <a href="../includes/cadastrar_sala_aluno.php?id_sala=<?= $salaAtiva['id_sala']; ?>">Cadastrar Alunos</a>
                <br><br>
                <a href="../includes/visualizar_sala_aluno.php?id_sala=<?= $salaAtiva['id_sala']; ?>">Visualizar Alunos</a>
            </td>
            <td>
                <a href="../includes/cadastrar_sala_professor.php?id_sala=<?= $salaAtiva['id_sala']; ?>">Cadastar Professores</a>
                <br><br>
                <a href="../includes/visualizar_sala_professor.php?id_sala=<?= $salaAtiva['id_sala']; ?>">Visualizar Professores</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Buscar Salas</h2>
    <form method="POST" action="gerenciar_salas.php">
        <label for="serie_sala">Série:</label>
        <select id="serie_sala" name="serie_sala" required>
            <?php
            $series = $sala->buscarSeries();
            foreach ($series as $serie) {
                echo "<option value=\"{$serie['id_serie']}\">" . htmlspecialchars($serie['nome_serie']) . "</option>";
            }
            ?>
        </select>

        <label for="ano_sala">Ano:</label>
        <input type="number" id="ano_sala" name="ano_sala" required>

        <button type="submit" name="buscar">Buscar</button>
    </form>

    <!-- Resultados da busca -->
    <?php if (!empty($salasBuscadas)): ?>
        <h2>Resultados da Busca:</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Ano</th>
                <th>Série</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($salasBuscadas as $salaBuscada): ?>
            <tr>
                <td><?= htmlspecialchars($salaBuscada['id_sala']); ?></td>
                <td><?= htmlspecialchars($salaBuscada['ano_sala']); ?></td>
                <td><?= htmlspecialchars($salaBuscada['nome_serie']); ?></td>
                <td><?= htmlspecialchars($salaBuscada['nome_situacao']); ?></td>
                <td>
                    <!-- Link para editar sala -->
                    <form method="POST" action="editar_sala.php" style="display:inline;">
                        <input type="hidden" name="id_sala" value="<?= $salaBuscada['id_sala']; ?>">
                        <button type="submit">Editar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="cadastrar_sala.php"><button>Cadastrar Nova Sala</button></a>
    <p></p>
    <a href="../includes/admin_home.php"><button>Voltar</button></a>
</body>
</html>

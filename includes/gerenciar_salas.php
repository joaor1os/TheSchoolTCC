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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Salas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/room/gerenciarRoom.css">
</head>
<body>

<div class="container my-5">
    <h1 class="text-center">Gerenciar Salas</h1>

    <h2>Salas Ativas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Ano</th>
                    <th>Série</th>
                    <th>Situação</th>
                    <th>Ações Aluno</th>
                    <th>Ações Professor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salasAtivas as $salaAtiva): ?>
                    <tr>
                        <td><?= htmlspecialchars($salaAtiva['id_sala']); ?></td>
                        <td><?= htmlspecialchars($salaAtiva['ano_sala']); ?></td>
                        <td><?= htmlspecialchars($salaAtiva['nome_serie']); ?></td>
                        <td><?= htmlspecialchars($salaAtiva['nome_situacao']); ?></td>
                        <td>
                            <a href="../includes/cadastrar_sala_aluno.php?id_sala=<?= $salaAtiva['id_sala']; ?>" class="btn btn-primary btn-sm">Cadastrar Alunos</a>
                            <a href="../includes/visualizar_sala_aluno.php?id_sala=<?= $salaAtiva['id_sala']; ?>" class="btn btn-info btn-sm">Visualizar Alunos</a>
                            <a href="../includes/visualizar_aprovacoes.php?id_sala=<?= $salaAtiva['id_sala']; ?>" class="btn btn-secondary btn-sm">Visualizar Aprovações</a>
                        </td>
                        <td>
                            <a href="../includes/cadastrar_sala_professor.php?id_sala=<?= $salaAtiva['id_sala']; ?>" class="btn btn-primary btn-sm">Cadastrar Professores</a>
                            <a href="../includes/visualizar_sala_professor.php?id_sala=<?= $salaAtiva['id_sala']; ?>" class="btn btn-info btn-sm">Visualizar Professores</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2>Buscar Salas</h2>
    <form method="POST" action="gerenciar_salas.php" class="mb-5">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="serie_sala">Série:</label>
                <select id="serie_sala" name="serie_sala" class="form-control" required>
                    <?php
                    $series = $sala->buscarSeries();
                    foreach ($series as $serie) {
                        echo "<option value=\"{$serie['id_serie']}\">" . htmlspecialchars($serie['nome_serie']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="ano_sala">Ano:</label>
                <input type="number" id="ano_sala" name="ano_sala" class="form-control" required>
            </div>
        </div>
        <button type="submit" name="buscar" class="btn btn-success btn-lg btn-block">Buscar</button>
    </form>

    <!-- Resultados da busca -->
    <?php if (!empty($salasBuscadas)): ?>
        <h2>Resultados da Busca:</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Ano</th>
                        <th>Série</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salasBuscadas as $salaBuscada): ?>
                        <tr>
                            <td><?= htmlspecialchars($salaBuscada['id_sala']); ?></td>
                            <td><?= htmlspecialchars($salaBuscada['ano_sala']); ?></td>
                            <td><?= htmlspecialchars($salaBuscada['nome_serie']); ?></td>
                            <td><?= htmlspecialchars($salaBuscada['nome_situacao']); ?></td>
                            <td>
                                <form method="POST" action="editar_sala.php" style="display:inline;">
                                    <input type="hidden" name="id_sala" value="<?= $salaBuscada['id_sala']; ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="text-center mt-5">
        <a href="cadastrar_sala.php" class="btn btn-success btn-lg">Cadastrar Nova Sala</a>
        <a href="editar_ano_letivo.php" class="btn btn-success btn-lg">Editar Ano Letivo</a>
        <a href="../includes/admin_home.php" class="btn btn-outline-primary btn-lg">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>


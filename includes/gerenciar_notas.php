<?php
session_start();
include_once 'db.php'; // Inclui a classe Database
include_once '../includes/class/notas.php'; // Inclui a classe Notas

$db = new Database();
$conn = $db->conn;

// Cria uma instância da classe Notas
$notas = new Notas($conn);

// Verificar se o parâmetro sala_id e disciplina_id estão presentes na URL
if (!isset($_GET['sala_id']) || !isset($_GET['disciplina_id'])) {
    die("Sala e disciplina não informadas.");
}

$sala_id = $_GET['sala_id'];
$disciplina_id = $_GET['disciplina_id'];

// Verificar se um bimestre foi enviado
$bimestre = isset($_GET['bimestre']) ? $_GET['bimestre'] : null;

// Consultas para obter informações da sala e nome da série
$query_sala = "SELECT s.id_sala, ser.nome_serie, si.nome_situacao 
               FROM salas s 
               JOIN serie ser ON s.serie_sala = ser.id_serie
               JOIN situacao si ON s.ativa_sala = si.id_situacao
               WHERE s.id_sala = ?";
$query_disciplina = "SELECT nome_disciplina FROM disciplinas WHERE id_disciplina = ?";

// Preparar e executar a consulta para obter o nome da série e situação
$stmt_sala = $conn->prepare($query_sala);
$stmt_sala->bind_param("i", $sala_id);
$stmt_sala->execute();
$result_sala = $stmt_sala->get_result();
$sala = $result_sala->fetch_assoc();
$nome_serie = $sala['nome_serie']; // Nome da série
$nome_situacao = $sala['nome_situacao']; // Nome da situação (ex: "7º Ano")

// Preparar e executar a consulta para obter o nome da disciplina
$stmt_disciplina = $conn->prepare($query_disciplina);
$stmt_disciplina->bind_param("i", $disciplina_id);
$stmt_disciplina->execute();
$result_disciplina = $stmt_disciplina->get_result();
$nome_disciplina = $result_disciplina->fetch_assoc()['nome_disciplina'];

// Consulta para obter os bimestres disponíveis
$query_bimestres = "SELECT * FROM bimestres";
$result_bimestres = $conn->query($query_bimestres);

// Se o bimestre for especificado, exibe as notas dos alunos
if ($bimestre) {
    $query_notas = "
        SELECT n.id_nota, a.nome_aluno, n.nota1, n.nota2, n.nota3, n.media, n.bimestre_nota
        FROM notas n
        JOIN aluno a ON n.aluno_nota = a.id_aluno
        WHERE n.sala_nota = ? AND n.disciplina_nota = ? AND n.bimestre_nota = ?
        ORDER BY a.nome_aluno ASC";  // Ordena os alunos por nome em ordem alfabética

    $stmt_notas = $conn->prepare($query_notas);
    $stmt_notas->bind_param("iii", $sala_id, $disciplina_id, $bimestre);
    $stmt_notas->execute();
    $result_notas = $stmt_notas->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/Professor/gerenciarBimestre.css.css"> 
</head>
<body class="bg-light">


 
    <div class="container mt-5 pt-5">
        <h2 class="text-center mb-4 fade-in">Gerenciar Notas - Série <?php echo $nome_serie; ?> - Disciplina: <?php echo $nome_disciplina; ?></h2>

    
        <div class="card shadow-sm mb-4 slide-in">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Selecione o Bimestre para Gerenciamento</h4>
            </div>
            <div class="card-body">
                <form action="gerenciar_notas.php" method="get">
                    <input type="hidden" name="sala_id" value="<?php echo $sala_id; ?>">
                    <input type="hidden" name="disciplina_id" value="<?php echo $disciplina_id; ?>">

                    <div class="mb-3">
                        <label for="bimestre" class="form-label">Selecione o Bimestre:</label>
                        <select name="bimestre" id="bimestre" class="form-select" required>
                            <option value="">Selecione um Bimestre</option>
                            <?php while ($bimestre_option = $result_bimestres->fetch_assoc()) : ?>
                                <option value="<?php echo $bimestre_option['id_bimestre']; ?>" <?php echo isset($bimestre) && $bimestre == $bimestre_option['id_bimestre'] ? 'selected' : ''; ?>>
                                    <?php echo $bimestre_option['nome_bimestre']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </form>
            </div>
        </div>

   
        <?php if ($bimestre && $result_notas->num_rows > 0): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Notas dos Alunos</h4>
                </div>
                <div class="card-body">
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Nota 1</th>
                                <th>Nota 2</th>
                                <th>Nota 3</th>
                                <th>Média</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($nota = $result_notas->fetch_assoc()) : ?>
                                <form action="editar_notas.php" method="post">
                                    <input type="hidden" name="id_nota" value="<?php echo $nota['id_nota']; ?>">
                                    <input type="hidden" name="sala_id" value="<?php echo $sala_id; ?>">
                                    <input type="hidden" name="disciplina_id" value="<?php echo $disciplina_id; ?>">
                                    <input type="hidden" name="bimestre" value="<?php echo $nota['bimestre_nota']; ?>">

                                    <tr>
                                        <td><?php echo $nota['nome_aluno']; ?></td>
                                        <td><input type="number" step="0.1" name="nota1" value="<?php echo $nota['nota1']; ?>" class="form-control" required></td>
                                        <td><input type="number" step="0.1" name="nota2" value="<?php echo $nota['nota2']; ?>" class="form-control" required></td>
                                        <td><input type="number" step="0.1" name="nota3" value="<?php echo $nota['nota3']; ?>" class="form-control" required></td>
                                        <td><?php echo number_format($nota['media'], 2); ?></td>
                                        <td><button type="submit" class="btn btn-warning">Editar</button></td>
                                    </tr>
                                </form>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p>Selecione um Bimestre</p>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="../includes/professor_home.php" class="btn btn-outline-primary">Voltar</a>
        </div>
    </div>

</body>
</html>

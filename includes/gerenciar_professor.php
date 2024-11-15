<?php
include_once 'db.php';
include_once '../includes/class/Professor.php';

$db = new Database();
$conn = $db->conn;

// Inicializa as variáveis
$mensagem = '';
$resultados = [];

// Consulta para buscar professores ativos e suas disciplinas
$query = "
    SELECT p.id_professor, fi.nome_funcionario, d.id_disciplina, d.nome_disciplina 
    FROM professor p
    JOIN funcionario_instituicao fi ON p.id_prof_func = fi.id_funcionario
    JOIN disciplinas d ON p.disciplina_professor = d.id_disciplina 
    WHERE fi.situacao_funcionario = 1";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Armazena resultados
if ($result->num_rows > 0) {
    $resultados = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $mensagem = "Nenhum professor ativo encontrado.";
}

// Verifica se há busca
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nome_busca'])) {
    $nome_busca = "%" . $_POST['nome_busca'] . "%";
    
    // Consulta para buscar professores ativos e suas disciplinas
    $queryBusca = "
        SELECT p.id_professor, fi.nome_funcionario, d.id_disciplina, d.nome_disciplina 
        FROM professor p
        JOIN funcionario_instituicao fi ON p.id_prof_func = fi.id_funcionario
        JOIN disciplinas d ON p.disciplina_professor = d.id_disciplina 
        WHERE fi.situacao_funcionario = 1 AND fi.nome_funcionario LIKE ?";
    
    $stmt = $conn->prepare($queryBusca);
    $stmt->bind_param("s", $nome_busca);
    $stmt->execute();
    $resultBusca = $stmt->get_result();

    // Armazena resultados da busca
    if ($resultBusca->num_rows > 0) {
        $resultados = $resultBusca->fetch_all(MYSQLI_ASSOC);
    } else {
        $mensagem = "Nenhum professor ativo encontrado com o nome especificado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Professor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Professor/gerenciarProf.css">
</head>
<body>

<div class="container my-5">
    <h1>Buscar Professor</h1>

    <div class="form-container mb-4">
        <form method="POST" action="">
            <label for="nome_busca">Nome do Professor:</label>
            <input type="text" id="nome_busca" name="nome_busca" required>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <?php if (!empty($mensagem)) : ?>
        <p class="alert alert-info text-center"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <?php if (!empty($resultados)) : ?>
        <h2 class="text-center mb-4">Professores Ativos:</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Disciplina</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $professor) : 
                    // Verifica se o professor está inscrito em alguma sala
                    $query_sala = "
                        SELECT 1 
                        FROM sala_professor sp
                        WHERE sp.professor_sp = ? 
                        LIMIT 1";
                    $stmt_sala = $conn->prepare($query_sala);
                    $stmt_sala->bind_param("i", $professor['id_professor']);
                    $stmt_sala->execute();
                    $result_sala = $stmt_sala->get_result();

                    // Se o resultado não for vazio, significa que o professor está inscrito em alguma sala
                    $professor_tem_sala = $result_sala->num_rows > 0;
                ?>
                    <tr>
                        <td><?php echo $professor['id_professor']; ?></td>
                        <td><?php echo $professor['nome_funcionario']; ?></td>
                        <td><?php echo $professor['nome_disciplina']; ?></td>
                        <td class="text-center">
                            <?php if (!$professor_tem_sala) : ?>
                                <a href="editar_professor.php?id_professor=<?php echo $professor['id_professor']; ?>" class="btn btn-success btn-sm">Editar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="text-center mt-5">
        <a href="../includes/admin_home.php" class="btn btn-primary">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

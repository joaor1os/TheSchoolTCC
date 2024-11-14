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
    <h1 class="text-center animate-header">Buscar Professor</h1>
    
    <form method="POST" action="" class="mb-4">
        <div class="form-group">
            <label for="nome_busca" class="font-weight-bold">Nome do Professor:</label>
            <input type="text" id="nome_busca" name="nome_busca" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Buscar</button>
    </form>

    <?php if (!empty($mensagem)) : ?>
        <p class="alert alert-info text-center"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <?php if (!empty($resultados)) : ?>
        <h2 class="text-center mb-4">Professores Ativos:</h2>
        
        <div class="card-deck">
            <?php foreach ($resultados as $professor) : ?>
                <div class="card small-card shadow-sm animate-card">
                    <div class="card-body">
                        <h6 class="card-title"><strong>ID:</strong> <?php echo $professor['id_professor']; ?></h6>
                        <p class="card-text mb-1"><strong>Nome:</strong> <?php echo $professor['nome_funcionario']; ?></p>
                        <p class="card-text mb-2"><strong>Disciplina:</strong> <?php echo $professor['nome_disciplina']; ?></p>
                        <div class="text-center">
                            <?php if (!$professor_tem_sala) : ?>
                                <a href="editar_professor.php?id_professor=<?php echo $professor['id_professor']; ?>" class="btn btn-success btn-sm btn-edit">Editar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center mt-5">
        <a href="../includes/admin_home.php" class="btn btn-secondary btn-lg">Voltar</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>


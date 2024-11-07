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
    SELECT p.id_professor, fi.nome_funcionario, p.formacao_professor, d.nome_disciplina 
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
        SELECT p.id_professor, fi.nome_funcionario, p.formacao_professor, d.nome_disciplina 
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
    <title>Gerenciar Professor</title>
</head>
<body>
    <h1>Buscar Professor</h1>
    <form method="POST" action="">
        <label for="nome_busca">Nome do Professor:</label>
        <input type="text" id="nome_busca" name="nome_busca" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if (!empty($mensagem)) : ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <?php if (!empty($resultados)) : ?>
        <h2>Professores Ativos:</h2>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Formação</th>
                <th>Disciplina</th>
                <th>Ação</th>
            </tr>
            <?php foreach ($resultados as $professor) : ?>
                <tr>
                    <td><?php echo $professor['id_professor']; ?></td>
                    <td><?php echo $professor['nome_funcionario']; ?></td>
                    <td><?php echo $professor['formacao_professor']; ?></td>
                    <td><?php echo $professor['nome_disciplina']; ?></td> <!-- Nome da disciplina exibido aqui -->
                    <td>
                        <a href="editar_professor.php?id_professor=<?php echo $professor['id_professor']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <a href="../includes/admin_home.php"><button>Voltar</button></a>
</body>
</html>


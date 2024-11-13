<?php
session_start();
include_once 'db.php'; // Inclui a classe Database

$db = new Database();
$conn = $db->conn;

// Verifica se o usuário está logado e é um professor
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'professor') {
    $professor_id = $_SESSION['user_id'];

    // Consulta as salas ativas do professor, agora incluindo o nome_serie da tabela 'serie'
    $query_salas = "
        SELECT s.id_sala, s.ano_sala, se.nome_serie 
        FROM salas s 
        JOIN sala_professor sp ON s.id_sala = sp.sala_sp 
        LEFT JOIN serie se ON s.serie_sala = se.id_serie
        WHERE sp.professor_sp = ? AND s.ativa_sala = 1
    ";
    $stmt_salas = $conn->prepare($query_salas);
    $stmt_salas->bind_param("i", $professor_id);
    $stmt_salas->execute();
    $result_salas = $stmt_salas->get_result();
} else {
    // Redireciona para a página de login caso o usuário não seja um professor
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Salas Ativas do Professor</title>

    <script type="text/javascript">
        // Função para confirmação antes de redirecionar para criar aula
        function confirmarCriacaoAula(salaId) {
            var resposta = confirm("Tem certeza de que deseja criar a aula para esta sala?");
            if (resposta) {
                // Se o usuário clicar em "Sim", redireciona para a página de criação de aula
                window.location.href = "criar_aula.php?sala_id=" + salaId;
            }
        }
    </script>
</head>
<body>
    <h1>Salas Ativas do Professor</h1>

    <?php if ($result_salas->num_rows > 0) : ?>
        <table border="1">
            <tr>
                <th>ID da Sala</th>
                <th>Ano</th>
                <th>Série</th>
                <th>Ação</th>
            </tr>
            <?php while ($sala = $result_salas->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $sala['id_sala']; ?></td>
                    <td><?php echo $sala['ano_sala']; ?></td>
                    <td><?php echo $sala['nome_serie']; ?></td> <!-- Exibe o nome da série -->
                    <td>
                        <!-- Modificado para chamar a função JavaScript com o ID da sala -->
                        <button onclick="confirmarCriacaoAula(<?php echo $sala['id_sala']; ?>)">Criar Aula</button>
                        <!-- Modificado para passar o id_sala via GET para a página de visualizar aulas -->
                        <a href="visualizar_aulas.php?sala_id=<?php echo $sala['id_sala']; ?>"><button>Visualizar Aulas</button></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhuma sala ativa encontrada.</p>
    <?php endif; ?>

    <a href="professor_home.php">Voltar para a Home</a>
</body>
</html>

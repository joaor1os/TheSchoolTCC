<?php
session_start();
include_once 'db.php';
include_once '../includes/class/SalaAluno.php';

$database = new Database();
$db = $database->conn;

$salaAluno = new SalaAluno($db);
$mensagem = '';

// Cadastrar aluno na sala
// Cadastrar aluno na sala
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_sa = $_POST['aluno_sa'];
    $sala_sa = $_POST['sala_sa'];
    $ativo_sa = $_POST['ativo_sa'];

    // Verificar se o aluno já está cadastrado na sala
    if ($salaAluno->alunoCadastradoNaSala($aluno_sa, $sala_sa)) {
        $mensagem = "Este aluno já está cadastrado nesta sala.";
    } else {
        if ($salaAluno->cadastrar($aluno_sa, $sala_sa, $ativo_sa)) {
            $mensagem = "Aluno cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar aluno.";
        }
    }
}


// Carregar alunos pelo nome
$alunos = [];
if (isset($_GET['nome'])) {
    $nome = $_GET['nome'];
    $alunos = $salaAluno->buscarAlunosPorNome($nome);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Aluno na Sala</title>
    <script>
        function buscarAlunos() {
            const nome = document.getElementById('nome_aluno').value;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'buscar_aluno.php?nome=' + nome, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('aluno_sa').innerHTML = this.responseText;
                }
            }
            xhr.send();
        }
    </script>
</head>
<body>
    <h1>Cadastrar Aluno na Sala</h1>
    <p><?= $mensagem; ?></p>

    <form method="POST" action="cadastrar_sala_aluno.php">
        <label for="nome_aluno">Nome do Aluno:</label>
        <input type="text" id="nome_aluno" name="nome_aluno" onkeyup="buscarAlunos()" required>
        
        <label for="aluno_sa">Selecione o Aluno:</label>
        <select name="aluno_sa" id="aluno_sa" required>
            <option value="">Selecione um aluno</option>
            <?php foreach ($alunos as $aluno): ?>
                <option value="<?= $aluno['id_aluno']; ?>"><?= $aluno['nome_aluno']; ?></option>
            <?php endforeach; ?>
        </select>

        <input type="hidden" name="sala_sa" value="<?= $_GET['id_sala']; ?>">

        <label for="ativo_sa">Situação:</label>
        <select name="ativo_sa" id="ativo_sa" required>
            <?php
            $situacoes = $salaAluno->buscarSituacoes();
            foreach ($situacoes as $situacao) {
                echo "<option value=\"{$situacao['id_situacao']}\">{$situacao['nome_situacao']}</option>";
            }
            ?>
        </select>

        <button type="submit">Cadastrar</button>
    </form>

    <a href="gerenciar_salas.php"><button>Voltar</button></a>
</body>
</html>

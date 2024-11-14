<?php
session_start();

include_once 'db.php';
include_once '../includes/class/Aluno.php';

$database = new Database();
$db = $database->conn;

$aluno = new Aluno($db);
$mensagem = '';
$alunoEdicao = null;
$situacoes = [];

// Verifica se o ID do aluno foi passado na URL
if (isset($_GET['id_aluno'])) {
    $id_aluno = $_GET['id_aluno'];
    $alunoEdicao = $aluno->buscarPorId($id_aluno);

    // Verifica se o aluno foi encontrado
    if (!$alunoEdicao) {
        $mensagem = "Aluno não encontrado.";
    }
}

// Recupera as opções de situação da tabela 'situacao'
$querySituacao = "SELECT id_situacao, nome_situacao FROM situacao";
$stmt = $db->prepare($querySituacao);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $situacoes[] = $row;
}

// Lógica para atualizar aluno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $id_aluno = $_POST['id_aluno'];
    $aluno->setNomeAluno($_POST['nome_aluno']);
    $aluno->setCpfAluno($_POST['cpf_aluno']);
    $aluno->setDataNascimentoAluno($_POST['data_nascimento_aluno']);
    $aluno->setSexoAluno($_POST['sexo_aluno']);
    $aluno->setSituacaoAluno($_POST['situacao_aluno']);
    $aluno->setContatoAluno($_POST['contato_aluno']);
    $aluno->setEmail($_POST['email']);

    if ($aluno->atualizar($id_aluno)) {
        $msg = "Aluno atualizado com sucesso!";
        echo "<script>
                alert('$msg');
                window.location.href = 'gerenciar_aluno.php';
              </script>";
    } else {
        $mensagem = "Erro ao atualizar aluno.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
</head>
<body>
    <h1>Editar Aluno</h1>

    <?php if ($mensagem) : ?>
        <p><?= $mensagem ?></p>
    <?php endif; ?>

    <?php if ($alunoEdicao) : ?>
        <form method="POST" action="editar_aluno.php">
            <input type="hidden" name="id_aluno" value="<?= $alunoEdicao['id_aluno']; ?>">
            
            <label for="nome_aluno">Nome:</label>
            <input type="text" id="nome_aluno" name="nome_aluno" value="<?= $alunoEdicao['nome_aluno']; ?>" required>
            
            <label for="cpf_aluno">CPF:</label>
            <input type="text" id="cpf_aluno" name="cpf_aluno" value="<?= $alunoEdicao['cpf_aluno']; ?>" required>
            
            <label for="data_nascimento_aluno">Data de Nascimento:</label>
            <input type="date" id="data_nascimento_aluno" name="data_nascimento_aluno" value="<?= $alunoEdicao['data_nascimento_aluno']; ?>" required>
            
            <label for="sexo_aluno">Sexo:</label>
            <input type="text" id="sexo_aluno" name="sexo_aluno" value="<?= $alunoEdicao['sexo_aluno']; ?>" required>
            
            <label for="situacao_aluno">Situação:</label>
            <select id="situacao_aluno" name="situacao_aluno" required>
                <?php foreach ($situacoes as $situacao) : ?>
                    <option value="<?= $situacao['id_situacao']; ?>" <?= $alunoEdicao['situacao_aluno'] == $situacao['id_situacao'] ? 'selected' : ''; ?>>
                        <?= $situacao['nome_situacao']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="contato_aluno">Contato:</label>
            <input type="text" id="contato_aluno" name="contato_aluno" value="<?= $alunoEdicao['contato_aluno']; ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $alunoEdicao['email']; ?>" required>

            <button type="submit" name="salvar">Salvar</button>
        </form>
    <?php else: ?>
        <p>Não foi possível encontrar os dados do aluno para edição.</p>
    <?php endif; ?>

    <br>
    <a href="gerenciar_aluno.php">Voltar</a>
</body>
</html>

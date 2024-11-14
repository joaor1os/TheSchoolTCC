<?php
session_start();
include_once 'db.php';

$database = new Database();
$db = $database->conn;

// Função para redirecionar com mensagem
function redirecionarComMensagem($mensagem, $url = 'gerenciar_salas.php') {
    echo "<script>
            alert('$mensagem');
            window.location.href = '$url';
          </script>";
    exit;
}

// Classe SalaAluno para manipular o cadastro de alunos em sala
class SalaAluno {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function alunoCadastradoNaSala($aluno_sa, $sala_sa) {
        $query = "SELECT id_sa FROM sala_alunos WHERE aluno_sa = ? AND sala_sa = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $aluno_sa, $sala_sa);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function cadastrarAluno($aluno_sa, $sala_sa, $ativo_sa) {
        $query = "INSERT INTO sala_alunos (aluno_sa, sala_sa, ativo_sa) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $aluno_sa, $sala_sa, $ativo_sa);
        return $stmt->execute();
    }

    public function cadastrarNota($aluno_sa, $sala_sa) {
        $query = "INSERT INTO notas (id_aluno_nota, id_sala_nota) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $aluno_sa, $sala_sa);
        return $stmt->execute();
    }
}

// Instância da classe SalaAluno
$salaAluno = new SalaAluno($db);

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_sa = isset($_POST['aluno_sa']) ? (int)$_POST['aluno_sa'] : null;
    $sala_sa = isset($_POST['sala_sa']) ? (int)$_POST['sala_sa'] : null;
    $ativo_sa = isset($_POST['ativo_sa']) ? (int)$_POST['ativo_sa'] : null;

    if (!$aluno_sa || !$sala_sa || !$ativo_sa) {
        redirecionarComMensagem('Parâmetros inválidos.');
    }

    // Verificar se o aluno já está cadastrado na sala
    if ($salaAluno->alunoCadastradoNaSala($aluno_sa, $sala_sa)) {
        redirecionarComMensagem('Este aluno já está cadastrado nesta sala.');
    } else {
        if ($salaAluno->cadastrarAluno($aluno_sa, $sala_sa, $ativo_sa)) {
            // Inserir o aluno na tabela 'notas' após o cadastro na sala
            if ($salaAluno->cadastrarNota($aluno_sa, $sala_sa)) {
                redirecionarComMensagem('Aluno cadastrado com sucesso!');
            } else {
                redirecionarComMensagem('Erro ao cadastrar nota.');
            }
        } else {
            redirecionarComMensagem('Erro ao cadastrar aluno.');
        }
    }
}

// Função para buscar as situações
function buscarSituacoes($db) {
    $query = "SELECT id_situacao, nome_situacao FROM situacao";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $situacoes = [];
    while ($situacao = $result->fetch_assoc()) {
        $situacoes[] = $situacao;
    }
    return $situacoes;
}

// Buscar alunos cadastrados na sala
$sala_id = $_GET['id_sala'] ?? 0;
$query_alunos_cadastrados = "
    SELECT a.id_aluno, a.nome_aluno, a.data_nascimento_aluno
    FROM aluno a
    JOIN sala_alunos sa ON a.id_aluno = sa.aluno_sa
    WHERE sa.sala_sa = ? AND sa.ativo_sa = 1
    ORDER BY a.nome_aluno ASC";
$stmt_alunos_cadastrados = $db->prepare($query_alunos_cadastrados);
$stmt_alunos_cadastrados->bind_param("i", $sala_id);
$stmt_alunos_cadastrados->execute();
$result_alunos_cadastrados = $stmt_alunos_cadastrados->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Aluno na Sala</title>
    <script>
        function buscarAlunos() {
            const nome = document.getElementById('nome_aluno').value;
            const anoSala = <?= json_encode($_GET['ano_sala'] ?? ''); ?>;

            if (nome.length > 0) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `buscar_aluno.php?nome=${nome}&ano_sala=${anoSala}`, true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('aluno_sa').innerHTML = this.responseText;
                    }
                }
                xhr.send();
            } else {
                document.getElementById('aluno_sa').innerHTML = '';
            }
        }
    </script>
</head>
<body>
    <h1>Cadastrar Aluno na Sala</h1>
    
    <form method="POST" action="cadastrar_sala_aluno.php">
        <label for="nome_aluno">Nome do Aluno:</label>
        <input type="text" id="nome_aluno" name="nome_aluno" onkeyup="buscarAlunos()" required>
        
        <label for="aluno_sa">Selecione o Aluno:</label>
        <select name="aluno_sa" id="aluno_sa" required>
            <option value="">Selecione um aluno</option>
        </select>

        <input type="hidden" name="sala_sa" value="<?= htmlspecialchars($_GET['id_sala']); ?>">

        <label for="ativo_sa">Situação:</label>
        <select name="ativo_sa" id="ativo_sa" required>
            <?php
            $situacoes = buscarSituacoes($db);
            foreach ($situacoes as $situacao) {
                echo "<option value=\"{$situacao['id_situacao']}\">{$situacao['nome_situacao']}</option>";
            }
            ?>
        </select>

        <button type="submit">Cadastrar</button>
    </form>

    <a href="gerenciar_salas.php"><button>Voltar</button></a>

    <h2>Alunos Já Cadastrados na Sala</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nome do Aluno</th>
                <th>Idade</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibe a lista de alunos já cadastrados na sala
            while ($aluno = $result_alunos_cadastrados->fetch_assoc()) {
                $data_nascimento = new DateTime($aluno['data_nascimento_aluno']);
                $idade = $data_nascimento->diff(new DateTime())->y;
                echo "<tr>
                        <td>{$aluno['nome_aluno']}</td>
                        <td>{$idade} anos</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

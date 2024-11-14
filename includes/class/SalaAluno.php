<?php
class SalaAluno {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buscarAlunos() {
        $query = "SELECT id_aluno, nome_aluno FROM aluno";
        $result = $this->conn->query($query);
        $alunos = [];
        while ($row = $result->fetch_assoc()) {
            $alunos[] = $row;
        }
        return $alunos;
    }

    public function buscarAlunoPorId($id_sa) {
        $query = "SELECT aluno_sa, ativo_sa FROM sala_alunos WHERE id_sa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_sa);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function buscarAlunosPorNome($nome) {
        $query = "SELECT id_aluno, nome_aluno, sobrenome_aluno FROM aluno WHERE nome_aluno LIKE ?";
        $stmt = $this->conn->prepare($query);
        $nome = "%$nome%";
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();
        $alunos = [];
        while ($row = $result->fetch_assoc()) {
            $alunos[] = $row;
        }
        return $alunos;
    }

    public function alunoCadastradoNaSala($aluno_sa, $sala_sa) {
        $query = "SELECT * FROM sala_alunos WHERE aluno_sa = ? AND sala_sa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $aluno_sa, $sala_sa);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function listarAlunosNaSala($sala_sa) {
        $query = "SELECT sa.id_sa, sa.aluno_sa, sa.ativo_sa, a.nome_aluno, s.nome_situacao 
                  FROM sala_alunos sa 
                  JOIN aluno a ON sa.aluno_sa = a.id_aluno 
                  JOIN situacao s ON sa.ativo_sa = s.id_situacao 
                  WHERE sa.sala_sa = ? 
                  ORDER BY a.nome_aluno ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $sala_sa);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function atualizar($id_sa, $aluno_sa, $ativo_sa) {
        $query = "UPDATE sala_alunos SET aluno_sa = ?, ativo_sa = ? WHERE id_sa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $aluno_sa, $ativo_sa, $id_sa);
        return $stmt->execute();
    }

    public function obterAnoSala($sala_id) {
        $query = "SELECT ano_sala FROM salas WHERE id_sala = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $sala_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['ano_sala'];
    }
    
    public function calcularIdade($dataNascimento) {
        $dataNasc = new DateTime($dataNascimento);
        $hoje = new DateTime();
        $idade = $hoje->diff($dataNasc)->y;
        return $idade;
    }

    public function buscarSituacoes() {
        $query = "SELECT id_situacao, nome_situacao FROM situacao";
        $result = $this->conn->query($query);
        $situacoes = [];
        while ($row = $result->fetch_assoc()) {
            $situacoes[] = $row;
        }
        return $situacoes;
    }

    // Método para cadastrar o aluno na sala e automaticamente inserir na tabela 'notas'
    public function cadastrar($aluno_sa, $sala_sa, $ativo_sa) {
        // Verifica se o aluno já está na sala
        if ($this->alunoCadastradoNaSala($aluno_sa, $sala_sa)) {
            return "Este aluno já está cadastrado na sala.";
        }

        // Insere o aluno na sala
        $query = "INSERT INTO sala_alunos (aluno_sa, sala_sa, ativo_sa) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $aluno_sa, $sala_sa, $ativo_sa);
        if ($stmt->execute()) {
            // Insere uma linha na tabela 'notas' após o aluno ser cadastrado na sala
            return $this->cadastrarNota($aluno_sa, $sala_sa) ? "Aluno cadastrado com sucesso!" : "Erro ao cadastrar a nota.";
        }
        return "Erro ao cadastrar aluno.";
    }

    // Método para inserir a nota do aluno automaticamente
    private function cadastrarNota($aluno_sa, $sala_sa) {
        $query = "INSERT INTO notas (id_aluno_nota, id_sala_nota) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $aluno_sa, $sala_sa);
        return $stmt->execute();
    }
}
?>

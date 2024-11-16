<?php
class SalaAluno {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para cadastrar o aluno na sala e automaticamente inserir na tabela 'notas'
    public function cadastrar($aluno_sa, $sala_sa, $ativo_sa) {
        if ($this->alunoCadastradoNaSala($aluno_sa, $sala_sa)) {
            return "Este aluno já está cadastrado na sala.";
        }

        $query = "INSERT INTO sala_alunos (aluno_sa, sala_sa, ativo_sa) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $aluno_sa, $sala_sa, $ativo_sa);
        if ($stmt->execute()) {
            // Após cadastrar o aluno na sala, insere as notas para ele
            $this->cadastrarNotasParaAluno($aluno_sa, $sala_sa);
            return true;
        }
        return false;
    }

    // Método para listar os alunos de uma sala
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

    public function cadastrarNotasParaAluno($aluno_sa, $sala_sa) {
        // Verifica se há disciplinas associadas à sala através da tabela 'serie'
        $queryDisciplinas = "SELECT d.id_disciplina 
                             FROM salas sa
                             JOIN serie s ON sa.serie_sala = s.id_serie
                             JOIN disciplinas d ON d.id_disciplina IN (s.disciplina1, s.disciplina2, s.disciplina3, s.disciplina4, s.disciplina5)
                             WHERE sa.id_sala = ?";
        $stmtDisciplinas = $this->conn->prepare($queryDisciplinas);
        $stmtDisciplinas->bind_param("i", $sala_sa);
        $stmtDisciplinas->execute();
        $resultDisciplinas = $stmtDisciplinas->get_result();
    
        // Verifica se há disciplinas associadas à sala
        if ($resultDisciplinas->num_rows == 0) {
            echo "Não há disciplinas associadas a esta sala.";
            return;
        }
    
        // Insere notas para o aluno nas disciplinas
        while ($disciplina = $resultDisciplinas->fetch_assoc()) {
            // Verifica se as notas para o aluno, disciplina e sala já existem para cada bimestre
            $queryVerificaNota = "SELECT * FROM notas WHERE aluno_nota = ? AND disciplina_nota = ? AND sala_nota = ? AND bimestre_nota = ?";
            $stmtVerificaNota = $this->conn->prepare($queryVerificaNota);
    
            for ($bimestre = 1; $bimestre <= 4; $bimestre++) {
                $stmtVerificaNota->bind_param("iiii", $aluno_sa, $disciplina['id_disciplina'], $sala_sa, $bimestre);
                $stmtVerificaNota->execute();
                $resultVerificaNota = $stmtVerificaNota->get_result();
    
                // Só insere a nota se não existir um registro para o aluno, disciplina, sala e bimestre
                if ($resultVerificaNota->num_rows == 0) {
                    $queryNota = "INSERT INTO notas (aluno_nota, disciplina_nota, sala_nota, bimestre_nota) 
                                  VALUES (?, ?, ?, ?)";
                    $stmtNota = $this->conn->prepare($queryNota);
                    $stmtNota->bind_param("iiii", $aluno_sa, $disciplina['id_disciplina'], $sala_sa, $bimestre);
                    $stmtNota->execute();
                }
            }
    
            // Verifica se já existe um registro de média final para o aluno, disciplina e sala
            $queryVerificaMedia = "SELECT * FROM mf_aluno WHERE aluno_mf = ? AND disciplina_mf = ? AND sala_mf = ?";
            $stmtVerificaMedia = $this->conn->prepare($queryVerificaMedia);
            $stmtVerificaMedia->bind_param("iii", $aluno_sa, $disciplina['id_disciplina'], $sala_sa);
            $stmtVerificaMedia->execute();
            $resultVerificaMedia = $stmtVerificaMedia->get_result();
    
            // Verifica se já existe um registro de média final
            if ($resultVerificaMedia->num_rows == 0) {
                // Define a variável stmtMediaFinal aqui para garantir que o close() funcione
                $queryMediaFinal = "INSERT INTO mf_aluno (aluno_mf, disciplina_mf, media_final, sala_mf, situacao_mf) 
                                    VALUES (?, ?, ?, ?, ?)";
                $stmtMediaFinal = $this->conn->prepare($queryMediaFinal);
    
                // Define a média inicial como 0.0 e a situação inicial 'Indefinida' (id_situacao = 1)
                $mediaInicial = 0.0;
                $situacaoInicial = 1;
    
                // Insere o registro de média final
                $stmtMediaFinal->bind_param("iidii", $aluno_sa, $disciplina['id_disciplina'], $mediaInicial, $sala_sa, $situacaoInicial);
                $stmtMediaFinal->execute();
            }
        }
    
        // Fechando as consultas (mesmo que o stmtMediaFinal não tenha sido executado, ele deve ser fechado)
        $stmtDisciplinas->close();
        $stmtVerificaNota->close();
        if (isset($stmtNota)) {
            $stmtNota->close();
        }
        $stmtVerificaMedia->close();
        if (isset($stmtMediaFinal)) {
            $stmtMediaFinal->close();  // Garante que o stmtMediaFinal só será fechado se estiver definido
        }
    }
    
    
    
    
    
    public function buscarAlunoPorId($id_sa) {
        $query = "SELECT aluno_sa, ativo_sa FROM sala_alunos WHERE id_sa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_sa);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function alunoCadastradoNaSala($aluno_sa, $sala_sa) {
        $query = "SELECT * FROM sala_alunos WHERE aluno_sa = ? AND sala_sa = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $aluno_sa, $sala_sa);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
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
}
?>

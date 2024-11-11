<?php
class SalaProfessor {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Busca os professores, associando com a tabela de funcionários para obter o nome
    public function buscarProfessores() {
        $query = "
            SELECT p.id_professor, f.nome_funcionario AS nome_professor, p.disciplina_professor 
            FROM professor p
            JOIN funcionario_instituicao f ON p.id_prof_func = f.id_funcionario
            ORDER BY f.nome_funcionario ASC
        ";
        $result = $this->conn->query($query);
        $professores = [];
        while ($row = $result->fetch_assoc()) {
            $professores[] = [
                'id_professor' => $row['id_professor'],
                'nome_professor' => $row['nome_professor'],
                'disciplina' => $this->buscarNomeDisciplina($row['disciplina_professor']), // Adiciona o nome da disciplina
            ];
        }
        return $professores;
    }
    
    public function buscarNomeDisciplina($id_disciplina) {
        $query = "SELECT nome_disciplina FROM disciplinas WHERE id_disciplina = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_disciplina);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['nome_disciplina'] ?? 'Disciplina não encontrada';
    }
    

    // Busca salas ativas
    public function buscarSalas() {
        $query = "
            SELECT s.id_sala, s.ano_sala, se.nome_serie 
            FROM salas s
            JOIN serie se ON s.serie_sala = se.id_serie
            JOIN situacao si ON s.ativa_sala = si.id_situacao
            WHERE si.nome_situacao = 'Ativo'
        ";
        $result = $this->conn->query($query);
        $salas = [];
        while ($row = $result->fetch_assoc()) {
            $salas[] = $row;
        }
        return $salas;
    }

    // Cadastra um professor em uma sala específica
    public function cadastrar($professor_sp, $sala_sp) {
        $query = "INSERT INTO sala_professor (professor_sp, sala_sp) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $professor_sp, $sala_sp);
        return $stmt->execute();
    }

    // Lista os professores na sala especificada
    public function listarProfessoresNaSala($sala_sp) {
        $query = "SELECT sp.id_sp, f.nome_funcionario as nome_professor, p.disciplina_professor 
                  FROM sala_professor sp 
                  JOIN professor p ON sp.professor_sp = p.id_professor 
                  JOIN funcionario_instituicao f ON p.id_prof_func = f.id_funcionario 
                  WHERE sp.sala_sp = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $sala_sp);
        $stmt->execute();
        $result = $stmt->get_result();
        $professores = [];
        while ($row = $result->fetch_assoc()) {
            $professores[] = [
                'id_sp' => $row['id_sp'],
                'nome_professor' => $row['nome_professor'],
                'disciplina' => $this->buscarNomeDisciplina($row['disciplina_professor']), // Adicione a função para buscar o nome da disciplina
            ];
        }
        return $professores;
    }
    
    public function buscarProfessoresPorDisciplina($disciplina_professor) {
        $query = "
            SELECT p.id_professor, f.nome_funcionario AS nome_professor
            FROM professor p
            JOIN funcionario_instituicao f ON p.id_prof_func = f.id_funcionario
            WHERE p.disciplina_professor = ?
            ORDER BY f.nome_funcionario ASC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $disciplina_professor);
        $stmt->execute();
        $result = $stmt->get_result();
        $professores = [];
        while ($row = $result->fetch_assoc()) {
            $professores[] = $row;
        }
        return $professores;
    }

    public function buscarProfessorPorId($id_sp) {
        $query = "
            SELECT sp.professor_sp, f.nome_funcionario, p.disciplina_professor 
            FROM sala_professor sp
            JOIN professor p ON sp.professor_sp = p.id_professor
            JOIN funcionario_instituicao f ON p.id_prof_func = f.id_funcionario
            WHERE sp.id_sp = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_sp);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    
    public function buscarSalasAtivasPorProfessor($professor_id) {
        $query = "
            SELECT s.id_sala, s.ano_sala, se.nome_serie
            FROM salas s
            JOIN sala_professor sp ON s.id_sala = sp.sala_sp
            JOIN serie se ON s.serie_sala = se.id_serie
            WHERE sp.professor_sp = ? AND s.ativa_sala = 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $professor_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Armazena os resultados em um array associativo
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    

    

    // Atualiza um professor em uma sala
    public function atualizarProfessorNaSala($id_sp, $professor_sp) {
        $query = "UPDATE sala_professor SET professor_sp = ? WHERE id_sp = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $professor_sp, $id_sp);
        return $stmt->execute();
    }
}

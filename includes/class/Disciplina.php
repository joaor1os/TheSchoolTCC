<?php

include_once 'db.php';

class Disciplina {
    private $conn; // Conexão ao banco de dados
    private $id_disciplina;
    private $nome_disciplina;

    // Construtor
    public function __construct($conn, $nome_disciplina = null) {
        $this->conn = $conn; // Armazena a conexão
        $this->nome_disciplina = $nome_disciplina;
    }

    // Getter e Setter para id_disciplina
    public function getIdDisciplina() {
        return $this->id_disciplina;
    }

    public function setIdDisciplina($id_disciplina) {
        $this->id_disciplina = $id_disciplina;
    }

    // Getter e Setter para nome_disciplina
    public function getNomeDisciplina() {
        return $this->nome_disciplina;
    }

    public function setNomeDisciplina($nome_disciplina) {
        $this->nome_disciplina = $nome_disciplina;
    }

    // Método para salvar disciplina no banco
    public function salvar() {
        $sql = "INSERT INTO disciplinas (nome_disciplina) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->nome_disciplina); // "s" indica que o parâmetro é uma string

        if ($stmt->execute()) {
            echo "Disciplina cadastrada com sucesso!";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close(); // Fecha o statement
    }

    // Método para listar disciplinas
    public function listarDisciplinas() {
        $sql = "SELECT id_disciplina, nome_disciplina FROM disciplinas";
        $result = $this->conn->query($sql);
        
        return $result; // Retorna o resultado
    }
}
?>

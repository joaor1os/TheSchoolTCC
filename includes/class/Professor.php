<?php
include_once 'db.php';

class Professor {
    private $id_funcionario;
    private $disciplina_professor;

    public function __construct($id_funcionario, $disciplina_professor) {
        $this->id_funcionario = $id_funcionario;
        $this->disciplina_professor = $disciplina_professor;
    }

    public function cadastrarProfessor() {
        $db = new Database();
        $conn = $db->conn;
    
        $sql = "INSERT INTO professor (id_prof_func, disciplina_professor) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $this->id_funcionario, $this->disciplina_professor);
    
        if ($stmt->execute()) {
            echo " Professor cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar professor: " . $stmt->error;
        }
    
        $stmt->close();
        $db->close();
    }
    
}
?>

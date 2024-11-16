<?php
class Notas {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Função para atualizar as notas de um aluno
    public function atualizarNotas($id_nota, $nota1, $nota2, $nota3, $bimestre, $sala_id, $disciplina_id) {
        // Calcula a média
        $media = ($nota1 + $nota2 + $nota3) / 3;

        // Prepara a consulta para atualizar as notas no banco de dados
        $query = "
            UPDATE notas 
            SET nota1 = ?, nota2 = ?, nota3 = ?, media = ? 
            WHERE id_nota = ? 
              AND sala_nota = ? 
              AND disciplina_nota = ? 
              AND bimestre_nota = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ddddiiii", $nota1, $nota2, $nota3, $media, $id_nota, $sala_id, $disciplina_id, $bimestre);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    // Função para obter as notas de uma sala e disciplina específicas por bimestre
    public function obterNotasPorBimestre($sala_id, $disciplina_id, $bimestre) {
        $query = "
            SELECT n.*, a.nome_aluno 
            FROM notas n
            JOIN aluno a ON n.aluno_nota = a.id_aluno
            WHERE n.sala_nota = ? AND n.disciplina_nota = ? AND n.bimestre_nota = ? 
            GROUP BY n.aluno_nota, n.bimestre_nota
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $sala_id, $disciplina_id, $bimestre);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>

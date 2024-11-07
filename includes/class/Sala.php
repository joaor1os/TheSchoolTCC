<?php
class Sala {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buscarSeries() {
        $query = "SELECT id_serie, nome_serie FROM serie";
        $result = $this->conn->query($query);
        $series = [];
        while ($row = $result->fetch_assoc()) {
            $series[] = $row;
        }
        return $series;
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

    public function cadastrar($ano_sala, $serie_sala, $ativa_sala) {
        $query = "INSERT INTO salas (ano_sala, serie_sala, ativa_sala) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $ano_sala, $serie_sala, $ativa_sala);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listarSalasAtivas() {
        $query = "SELECT s.id_sala, s.ano_sala, se.nome_serie, sit.nome_situacao
                  FROM salas s
                  JOIN serie se ON s.serie_sala = se.id_serie
                  JOIN situacao sit ON s.ativa_sala = sit.id_situacao
                  WHERE s.ativa_sala = 1";
        $result = $this->conn->query($query);
        $salasAtivas = [];
        while ($row = $result->fetch_assoc()) {
            $salasAtivas[] = $row;
        }
        return $salasAtivas;
    }

    public function buscarPorSerieEAno($serie, $ano) {
        $query = "SELECT s.id_sala, s.ano_sala, se.nome_serie, sit.nome_situacao
                  FROM salas s
                  JOIN serie se ON s.serie_sala = se.id_serie
                  JOIN situacao sit ON s.ativa_sala = sit.id_situacao
                  WHERE s.serie_sala = ? AND s.ano_sala = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $serie, $ano);
        $stmt->execute();
        $result = $stmt->get_result();
        $salas = [];
        while ($row = $result->fetch_assoc()) {
            $salas[] = $row;
        }
        return $salas;
    }

    public function buscarPorId($id_sala) {
        $query = "SELECT * FROM salas WHERE id_sala = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_sala);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Retorna a sala como array associativo
    }
}
?>

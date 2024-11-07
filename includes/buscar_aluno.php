<?php
include_once 'db.php';
$database = new Database();
$db = $database->conn;

$nome = $_GET['nome'] ?? '';

if ($nome) {
    $stmt = $db->prepare("SELECT id_aluno, nome_aluno FROM aluno WHERE nome_aluno LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<option value=\"{$row['id_aluno']}\">{$row['nome_aluno']}</option>";
    }
}
?>

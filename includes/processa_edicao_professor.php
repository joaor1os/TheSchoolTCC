<?php
include_once 'db.php';

$db = new Database();
$conn = $db->conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_professor = $_POST['id_professor'];
    $disciplina_professor = $_POST['disciplina_professor'];

    // Atualiza os dados do professor
    $query = "
        UPDATE professor 
        SET disciplina_professor = ?
        WHERE id_professor = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $disciplina_professor, $id_professor);

    if ($stmt->execute()) {
        echo "<script>
                alert('Dados atualizados com sucesso.');
                window.location.href = '../includes/gerenciar_professor.php';
              </script>";
    } else {
        echo "Erro ao atualizar dados: " . $stmt->error;
    }
}
?>

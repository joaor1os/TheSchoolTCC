<?php
// Incluir a classe Database para estabelecer a conexão
include 'db.php';

// Instanciando a classe Database
$database = new Database();
$db = $database->conn;

// Verificando se o formulário foi enviado
if (isset($_POST['alterar_ano'])) {
    $novo_ano = $_POST['ano_letivo'];

    // Atualiza o ano letivo
    $sql = "UPDATE ano_letivo SET ano_letivo = ? WHERE id_ano_letivo = 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $novo_ano);

    if ($stmt->execute()) {
        // Desativa as salas com ano diferente do novo ano letivo
        $sql_update_salas = "UPDATE salas SET ativa_sala = 2 WHERE ano_sala != ?";
        $stmt_update_salas = $db->prepare($sql_update_salas);
        $stmt_update_salas->bind_param("i", $novo_ano);
        $stmt_update_salas->execute();

        // Ativa as salas que possuem o ano letivo igual ao novo ano
        $sql_activate_salas = "UPDATE salas SET ativa_sala = 1 WHERE ano_sala = ?";
        $stmt_activate_salas = $db->prepare($sql_activate_salas);
        $stmt_activate_salas->bind_param("i", $novo_ano);
        $stmt_activate_salas->execute();

        $msg = "Ano letivo atualizado! Salas do ano letivo anterior desativadas!";
        echo "<script>
                alert('$msg');
                window.location.href = 'gerenciar_salas.php';
              </script>";
              
    } else {
        echo "Erro ao atualizar ano letivo.";
    }
}

// Consulta o ano letivo atual
$sql_ano = "SELECT ano_letivo FROM ano_letivo WHERE id_ano_letivo = 1";
$result = $db->query($sql_ano);
$row = $result->fetch_assoc();
$ano_atual = $row['ano_letivo'];

// Fechar a conexão
$database->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ano Letivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/room/editYear.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary">Alterar Ano Letivo</h1>
        <form method="POST" class="mt-4 p-4 shadow bg-white rounded">
            <div class="mb-3">
                <label for="ano_letivo" class="form-label">Ano Letivo:</label>
                <input type="number" id="ano_letivo" name="ano_letivo" value="<?php echo $ano_atual; ?>" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <button type="submit" name="alterar_ano" class="btn btn-success">Alterar</button>
                <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

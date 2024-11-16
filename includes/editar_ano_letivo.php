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
        echo "Ano letivo atualizado com sucesso!<br>";

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

        echo "Salas do ano letivo anterior desativadas e salas do ano letivo atual ativadas.";
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
</head>
<body>
    <h1>Alterar Ano Letivo</h1>
    <form method="POST">
        <label for="ano_letivo">Ano Letivo:</label>
        <input type="number" name="ano_letivo" value="<?php echo $ano_atual; ?>" required>
        <button type="submit" name="alterar_ano">Alterar</button>
    </form>
</body>
</html>

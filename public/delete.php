<?php
$mysqli = new mysqli("db", "usuario", "senha123", "crud");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// SQL para deletar um registro
$sql = "DELETE FROM people WHERE id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);

$id = $_POST['id'];
$stmt->execute();

$stmt->close();
$mysqli->close();

header("Location: /"); // Redireciona de volta para a página principal
exit();
?>

<?php
$mysqli = new mysqli("db", "usuario", "senha123", "crud");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Atualiza o registro
$sql = "UPDATE people SET first_name = ?, last_name = ?, phone = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssi", $first_name, $last_name, $phone, $id);

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$id = $_POST['id'];
$stmt->execute();

$stmt->close();
$mysqli->close();

header("Location: /"); // Redireciona de volta para a página principal
exit();
?>

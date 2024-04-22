<?php
ob_start(); // Inicia o buffer de saída para evitar erros de cabeçalho

// Conexão com o banco de dados
$mysqli = new mysqli("db", "usuario", "senha123", "crud");

// Verifica erro de conexão
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepara e vincula os parâmetros
$stmt = $mysqli->prepare("INSERT INTO people (first_name, last_name, phone) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $first_name, $last_name, $phone);

// Define os parâmetros e executa
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$stmt->execute();

echo "New record created successfully"; // Saída que será bufferizada

$stmt->close();
$mysqli->close();

header("Location: /"); // Redirecionamento
ob_end_flush(); // Envia o buffer de saída e desativa o buffer
exit(); // Encerra a execução do script para evitar envio de mais saída
?>

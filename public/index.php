<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>CRUD Simples</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclui o arquivo CSS -->
</head>
<body>
    <h1>CRUD Simples</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $mysqli = new mysqli("db", "usuario", "senha123", "crud");

            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            $sql = "SELECT id, first_name, last_name, phone FROM people";
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <form method='post' action='update.php'>
                            <td>{$row['id']}</td>
                            <td><input type='text' name='first_name' value='{$row['first_name']}' required></td>
                            <td><input type='text' name='last_name' value='{$row['last_name']}' required></td>
                            <td><input type='text' name='phone' value='{$row['phone']}'></td>
                            <td>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='submit' value='Salvar'>
                                <button formaction='delete.php' type='submit'>Deletar</button>
                            </td>
                            </form>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum resultado encontrado</td></tr>";
            }
            $mysqli->close();
            ?>
        </tbody>
        <tfoot>
            <tr>
                <form method='post' action='insert.php'>
                    <td>#</td>
                    <td><input type='text' name='first_name' required></td>
                    <td><input type='text' name='last_name' required></td>
                    <td><input type='text' name='phone'></td>
                    <td><input type='submit' value='Adicionar Pessoa'></td>
                </form>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php
// Conexão com o banco de dados
$mysqli = new mysqli("db", "usuario", "senha123", "crud");
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Falha na conexão com o banco de dados']);
    exit();
}

// Verifica se a rota manual está sendo solicitada
if (isset($_GET['manual'])) {
    // Verifica se o User-Agent indica um navegador
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== false) {
        // Responde com HTML se for um navegador
        header('Content-Type: text/html; charset=utf-8');
        echo "<!DOCTYPE html>
        <html lang='pt'>
        <head>
            <meta charset='UTF-8'>
            <title>API Manual</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
                h1 { color: #333; }
                p { margin: 5px 0; }
                code { background-color: #f4f4f4; padding: 2px 5px; }
            </style>
        </head>
        <body>
            <h1>API Manual</h1>
            <h2>Endpoints</h2>
            <p><strong>GET /api.php</strong> - Lista todos os registros.</p>
            <code>curl -X GET http://localhost/api.php</code>
            <p><strong>POST /api.php</strong> - Cria um novo registro. Campos: first_name, last_name, phone.</p>
            <code>curl -X POST http://localhost/api.php -H 'Content-Type: application/json' -d '{\"first_name\": \"João\", \"last_name\": \"Silva\", \"phone\": \"123456789\"}'</code>
            <p><strong>PUT /api.php</strong> - Atualiza um registro existente. Campos: id, first_name, last_name, phone.</p>
            <code>curl -X PUT http://localhost/api.php -H 'Content-Type: application/json' -d 'id=1&first_name=João&last_name=Silva&phone=987654321'</code>
            <p><strong>DELETE /api.php</strong> - Deleta um registro. Campo: id.</p>
            <code>curl -X DELETE http://localhost/api.php -H 'Content-Type: application/json' -d 'id=1'</code>
        </body>
        </html>";
        exit();
    } else {
        // Responde com JSON para outros clientes
        header('Content-Type: application/json');
        echo json_encode([
            "description" => "API Manual",
            "endpoints" => [
                "GET /api.php" => [
                    "description" => "Lista todos os registros.",
                    "curl_example" => "curl -X GET http://localhost/api.php"
                ],
                "POST /api.php" => [
                    "description" => "Cria um novo registro.",
                    "fields" => ["first_name" => "string", "last_name" => "string", "phone" => "string"],
                    "curl_example" => "curl -X POST http://localhost/api.php -H 'Content-Type: application/json' -d '{\"first_name\": \"João\", \"last_name\": \"Silva\", \"phone\": \"123456789\"}'"
                ],
                "PUT /api.php" => [
                    "description" => "Atualiza um registro existente.",
                    "fields" => ["id" => "int", "first_name" => "string", "last_name" => "string", "phone" => "string"],
                    "curl_example" => "curl -X PUT http://localhost/api.php -H 'Content-Type: application/json' -d 'id=1&first_name=João&last_name=Silva&phone=987654321'"
                ],
                "DELETE /api.php" => [
                    "description" => "Deleta um registro.",
                    "fields" => ["id" => "int"],
                    "curl_example" => "curl -X DELETE http://localhost/api.php -H 'Content-Type: application/json' -d 'id=1'"
                ]
            ]
        ]);
        exit();
    }
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // Listar todos os registros
        $result = $mysqli->query("SELECT id, first_name, last_name, phone FROM people");
        $people = [];
        while ($row = $result->fetch_assoc()) {
            $people[] = $row;
        }
        echo json_encode($people);
        break;

    case 'POST': // Criar novo registro
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(['error' => 'Dados inválidos']);
            exit();
        }
        $stmt = $mysqli->prepare("INSERT INTO people (first_name, last_name, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['first_name'], $data['last_name'], $data['phone']);
        $stmt->execute();
        echo json_encode(['message' => 'Registro criado com sucesso', 'id' => $mysqli->insert_id]);
        break;

    case 'PUT': // Atualizar um registro existente
        parse_str(file_get_contents("php://input"), $data);
        $stmt = $mysqli->prepare("UPDATE people SET first_name = ?, last_name = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data['first_name'], $data['last_name'], $data['phone'], $data['id']);
        $stmt->execute();
        echo json_encode(['message' => 'Registro atualizado com sucesso']);
        break;

    case 'DELETE': // Deletar um registro
        parse_str(file_get_contents("php://input"), $data);
        $stmt = $mysqli->prepare("DELETE FROM people WHERE id = ?");
        $stmt->bind_param("i", $data['id']);
        $stmt->execute();
        echo json_encode(['message' => 'Registro deletado com sucesso']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
        break;
}

$mysqli->close();
?>

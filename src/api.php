<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

require_once __DIR__ . '/db.php';

$conn->query("CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100)
)");

// LISTAR
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['delete'])) {
    $res = $conn->query("SELECT * FROM usuarios");
    $dados = [];

    while ($row = $res->fetch_assoc()) {
        $dados[] = $row;
    }

    echo json_encode($dados);
}

// INSERIR / ATUALIZAR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'] ?? '';
    $nome = $conn->real_escape_string($data['nome']);
    $email = $conn->real_escape_string($data['email']);

    if (empty($id)) {
        $conn->query("INSERT INTO usuarios (nome, email) VALUES ('$nome','$email')");
    } else {
        $conn->query("UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id");
    }

    echo json_encode(["status" => "ok"]);
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM usuarios WHERE id=$id");

    echo json_encode(["status" => "deletado"]);
}

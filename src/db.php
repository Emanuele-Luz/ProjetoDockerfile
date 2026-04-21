<?php

// No Docker, defina MYSQL_HOST=db no compose. Fora do Docker (XAMPP etc.), use 127.0.0.1 e o mesmo banco/senha.
$host = getenv('MYSQL_HOST') ?: '127.0.0.1';
$user = getenv('MYSQL_USER') ?: 'root';
$pass = getenv('MYSQL_PASSWORD') ?: 'root';
$db = getenv('MYSQL_DATABASE') ?: 'crud_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
<?php
require_once __DIR__ . '/db.php';

// Criar tabela
$conn->query("CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100)
)");

// ========================
// INSERIR OU ATUALIZAR
// ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id    = $_POST['id'] ?? '';
    $nome  = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);

    if (empty($id)) {
        $conn->query("INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')");
    } else {
        $conn->query("UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id");
    }

    header("Location: index.php");
    exit;
}

// ========================
// DELETAR
// ========================
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM usuarios WHERE id=$id");
    header("Location: index.php");
    exit;
}

// ========================
// EDITAR
// ========================
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $resultEdit = $conn->query("SELECT * FROM usuarios WHERE id=$id");
    $edit = $resultEdit->fetch_assoc();
}

// LISTAR
$result = $conn->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP + MySQL</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            background: #f4f4f4;
        }
        h2 { color: #333; }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        input {
            padding: 10px;
            margin: 5px;
            width: 200px;
        }
        button {
            padding: 10px;
            cursor: pointer;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        a {
            text-decoration: none;
            margin: 5px;
        }
    </style>
</head>
<body>

<h2>Cadastro de Usuários</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

    <input type="text" name="nome" placeholder="Nome"
        value="<?= $edit['nome'] ?? '' ?>" required>

    <input type="email" name="email" placeholder="Email"
        value="<?= $edit['email'] ?? '' ?>" required>

    <button type="submit">
        <?= $edit ? 'Atualizar' : 'Cadastrar' ?>
    </button>
</form>

<h2>Lista de Usuários</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Ações</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td><?= $row['email'] ?></td>
        <td>
            <a href="?edit=<?= $row['id'] ?>">✏️ Editar</a>
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Excluir?')">🗑️ Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
<?php
$host = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = 'projeto_estagios_2';

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die('Erro de ligação à base de dados: ' . $conn->connect_error);
}

$erro = null;

if (isset($_POST['submit'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $nome = $_POST['nome'];

    $stmt_check = $conn->prepare("SELECT 1 FROM utilizador WHERE login = ? LIMIT 1");
    $stmt_check->bind_param("s", $login);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $erro = "O login '$login' já existe. Escolha outro.";
    } else {
        $result = $conn->query("SELECT MAX(utilizador_id) AS max_id FROM utilizador");
        $row = $result->fetch_assoc();
        $novo_id = ($row['max_id'] ?? 0) + 1;

        $tipo = "aluno";
        $stmt = $conn->prepare("INSERT INTO utilizador (utilizador_id, login, tipo, nome, password) VALUES (?, ?, ?, ?, ?)");
        $stmt -> bind_param('issss', $novo_id, $login, $tipo, $nome, $password);

        if ($stmt->execute()) {
            echo "<p>Utilizador aluno criado com sucesso! ID: " . $novo_id. "</p>";
        } else {
            $erro = "Erro ao criar utilizador: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>SiEstagios</title>
            <link
            href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="../../php-css/style-admin.css">
    </head>
    <body>
        <h1>Criar Novo Utilizador (Aluno)</h1>

        <?php if ($erro): ?>
            <p style="color:red; font-weight:bold;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Login:</label>
            <input type="text" name="login" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <label>Nome:</label>
            <input type="text" name="nome" required><br>

            <button type="submit" name="submit">Criar utilizador</button>

            <p>
                <div class="form-footers">
                    <a href="adicionar_aluno.php">Registar aluno</a>
                </div>
            </p>
        </form>

    </body>
</html>

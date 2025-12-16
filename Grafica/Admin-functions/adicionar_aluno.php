<?php
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'projeto_estagios_2';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Erro de ligação à base de dados.');
    }

    $erro = null;
    $sucesso = null;

    if (isset($_POST['submit'])) {
        $utilizador_id = $_POST['utilizador_id'];
        $turma_id = $_POST['turma_id'];
        $numero = $_POST['numero'] ?: null;
        $observacoes = $_POST['observacoes'] ?: null;

        $stmt = $conn->prepare("SELECT 1 FROM utilizador WHERE utilizador_id = ? LIMIT 1");
        $stmt->bind_param("i", $utilizador_id);
        $stmt->execute();
        $stmt->store_result();

        $stmt = $conn->prepare("SELECT 1 FROM utilizador WHERE utilizador_id = ? LIMIT 1");
        $stmt->bind_param("i", $utilizador_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $erro = "O utilizador com ID $utilizador_id não existe. <a href='criar_utilizador.php'>Criar utilizador</a>";
        } else {
            $stmt2 = $conn->prepare("INSERT INTO aluno (utilizador_id, turma_id, numero, observacoes) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("iiis", $utilizador_id, $turma_id, $numero, $observacoes);

            try {
                $stmt2->execute();
                $sucesso = "Aluno registado com sucesso!";
            } catch (mysqli_sql_exception $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $erro = "O aluno com ID $utilizador_id já está registado.";
                } else {
                    $erro = "Erro ao registar aluno: " . $e->getMessage();
                }
            }
        }
    }

    $turmas_result = $conn->query("SELECT turma_id, sigla, ano FROM turma ORDER BY ano, sigla");
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
        <h1>Registar Novo Aluno</h1>

        <?php if ($erro): ?>
            <p style="color:red; font-weight:bold;"><?= $erro ?></p>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <p style="color:green; font-weight:bold;"><?= $sucesso ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="form-row">
                <label>Utilizador ID:</label>
                <input type="number" name="utilizador_id" required><br>
            </div>

            <div class="form-row">
                <label>Turma:</label>
                <select name="turma_id" required>
                    <option value="">Selecione uma turma</option>
                    <?php while($turma = $turmas_result->fetch_assoc()): ?>
                        <option value="<?= $turma['turma_id'] ?>">
                            <?= htmlspecialchars($turma['sigla'] . ' (' . $turma['ano'] . ')') ?>
                        </option>
                    <?php endwhile; ?>
                </select><br>
            </div>

            <div class="form-row">
                <label>Número:</label>
                <input type="number" name="numero"><br>
            </div>

            <div class="form-row">
                <label>Observações:</label>
                <input type="text" name="observacoes"><br>
            </div>

            <button type="submit" name="submit">Registar Aluno</button>
        </form>

        <p>
            <div class="form-footers">
                <a href="../portal_administrador.html">Voltar ao Portal</a>
            </div>

            <div class="form-footers">
                <a href="criar_utilizador.php">Criar utilizador(aluno)</a>
            </div>
        </p>
    </body>
</html>

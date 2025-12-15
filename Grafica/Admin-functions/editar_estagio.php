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

    $empresa_id = $_GET['empresa_id'] ?? null;
    $estabelecimento_id = $_GET['estabelecimento_id'] ?? null;
    $aluno_id = $_GET['aluno_id'] ?? null;

    if (!$empresa_id || !$estabelecimento_id || !$aluno_id) {
        $erro = "Parâmetros inválidos.";
    }

    if (isset($_POST['submit'])) {
        $formador_id = $_POST['formador_id'];
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'] ?: null;
        $nota_empresa = $_POST['nota_empresa'] ?: null;
        $nota_escola = $_POST['nota_escola'] ?: null;
        $nota_relatorio = $_POST['nota_relatorio'] ?: null;
        $nota_procura = $_POST['nota_procura'] ?: null;
        $nota_final = $_POST['nota_final'] ?: null;
        $classificacao = $_POST['classificacao'] ?: null;

        $stmt = $conn->prepare("
            UPDATE estagio SET
                formador_id = ?,
                data_inicio = ?,
                data_fim = ?,
                nota_empresa = ?,
                nota_escola = ?,
                nota_relatorio = ?,
                nota_procura = ?,
                nota_final = ?,
                classificacao = ?
            WHERE
                estabelecimento_empresa_id = ? AND
                estabelecimento_id = ? AND
                aluno_id = ?
        ");

        $stmt->bind_param(
            "issdddddiiii",
            $formador_id, $data_inicio, $data_fim,
            $nota_empresa, $nota_escola, $nota_relatorio,
            $nota_procura, $nota_final, $classificacao,
            $empresa_id, $estabelecimento_id, $aluno_id
        );

        try {
            if ($stmt->execute()) {
                header("Location: verificar_estagios.php");
                exit();
            } else {
                $erro = "Erro ao atualizar o estágio: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
    
            $erro = "Erro ao atualizar: valor inválido para algum campo.";
        }
    }

    $stmt = $conn->prepare("
        SELECT * FROM estagio
        WHERE estabelecimento_empresa_id = ? AND estabelecimento_id = ? AND aluno_id = ?
    ");

    $stmt->bind_param("iii", $empresa_id, $estabelecimento_id, $aluno_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $estagio = $result->fetch_assoc();

    if (!$estagio) {
        $erro = "Estágio não encontrado.";
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
        <link rel="stylesheet" href="../php-css/style-admin.css">
    </head>
    <body>
        <h1>Editar Estágio</h1>

        <?php if ($erro): ?>
            <p style="color:red; font-weight:bold;">
                <?= htmlspecialchars($erro) ?>
            </p>
        <?php endif; ?>

        <?php if (!$erro): ?>

            <form method="post">
                <label>Formador ID:</label>
                <input type="number" name="formador_id" value="<?= htmlspecialchars($estagio['formador_id']) ?>" required><br>

                <label>Data Início:</label>
                <input type="date" name="data_inicio" value="<?= htmlspecialchars($estagio['data_inicio']) ?>" required><br>

                <label>Data Fim:</label>
                <input type="date" name="data_fim" value="<?= htmlspecialchars($estagio['data_fim']) ?>"><br>

                <label>Nota Empresa:</label>
                <input type="number" step="0.1" name="nota_empresa" value="<?= htmlspecialchars($estagio['nota_empresa']) ?>"><br>

                <label>Nota Escola:</label>
                <input type="number" step="0.1" name="nota_escola" value="<?= htmlspecialchars($estagio['nota_escola']) ?>"><br>

                <label>Nota Relatório:</label>
                <input type="number" step="0.1" name="nota_relatorio" value="<?= htmlspecialchars($estagio['nota_relatorio']) ?>"><br>

                <label>Nota Procura:</label>
                <input type="number" step="0.1" name="nota_procura" value="<?= htmlspecialchars($estagio['nota_procura']) ?>"><br>

                <label>Nota Final:</label>
                <input type="number" step="0.1" name="nota_final" value="<?= htmlspecialchars($estagio['nota_final']) ?>"><br>

                <label>Classificação:</label>
                <input type="number" name="classificacao" value="<?= htmlspecialchars($estagio['classificacao']) ?>"><br>

                <button type="submit" name="submit">Salvar Alterações</button>
            </form>
        <?php endif; ?>
        <p><a href="verificar_estagios.php">Voltar</a></p>
    </body>
</html>

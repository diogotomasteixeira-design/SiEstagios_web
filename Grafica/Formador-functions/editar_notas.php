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

    $empresa_id = $_GET['empresa_id'] ?? null;
    $estabelecimento_id = $_GET['estabelecimento_id'] ?? null;
    $aluno_id = $_GET['aluno_id'] ?? null;

    if (!$empresa_id || !$estabelecimento_id || !$aluno_id) {
        $erro = "Parâmetros inválidos.";
    }

    if (!$erro && isset($_POST['submit'])) {
        $nota_empresa = $_POST['nota_empresa'] ?: null;
        $nota_escola = $_POST['nota_escola'] ?: null;
        $nota_relatorio = $_POST['nota_relatorio'] ?: null;
        $nota_procura = $_POST['nota_procura'] ?: null;

        $notas = array_filter([$nota_empresa, $nota_escola, $nota_relatorio, $nota_procura], fn($n) => $n !== null);
        $nota_final = !empty($notas) ? round(array_sum($notas) / count($notas)) : null;

        $stmt = $conn->prepare("
            UPDATE estagio SET
                nota_empresa = ?,
                nota_escola = ?,
                nota_relatorio = ?,
                nota_procura = ?,
                nota_final = ?
            WHERE
                estabelecimento_empresa_id = ? AND
                estabelecimento_id = ? AND
                aluno_id = ?
        ");

        $stmt->bind_param(
            "ddddiiii",
            $nota_empresa, $nota_escola, $nota_relatorio, $nota_procura, $nota_final,
            $empresa_id, $estabelecimento_id, $aluno_id
        );

        try {
            if ($stmt->execute()) {
                header("Location: registar_notas.php");
                exit();
            } else {
                $erro = "Erro ao atualizar notas: " . $stmt->error;
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

    $stmt = $conn->prepare("
        SELECT e.*, u.nome AS nome_aluno
        FROM estagio e
        JOIN utilizador u ON e.aluno_id = u.utilizador_id
        WHERE e.estabelecimento_empresa_id = ? AND e.estabelecimento_id = ? AND e.aluno_id = ?
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
        <link rel="stylesheet" href="../../php-css/style-formador.css">
    </head>
    <body>
        <h1>
            Editar Notas do Estágio de <?= htmlspecialchars($estagio['nome_aluno']) ?>
        </h1>

        <?php if ($erro): ?>
            <p style="color:red; font-weight:bold;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <?php if (!$erro): ?>
            <form method="post">
                <div class="form-row">
                    <label>Nota Empresa:</label>
                    <input type="number" step="0.1" name="nota_empresa" value="<?= htmlspecialchars($estagio['nota_empresa']) ?>"><br>
                </div>

                <div class="form-row">
                    <label>Nota Escola:</label>
                    <input type="number" step="0.1" name="nota_escola" value="<?= htmlspecialchars($estagio['nota_escola']) ?>"><br>
                </div>

                <div class="form-row">
                    <label>Nota Relatório:</label>
                    <input type="number" step="0.1" name="nota_relatorio" value="<?= htmlspecialchars($estagio['nota_relatorio']) ?>"><br>
                </div>

                <div class="form-row">
                    <label>Nota Procura:</label>
                    <input type="number" step="0.1" name="nota_procura" value="<?= htmlspecialchars($estagio['nota_procura']) ?>"><br>
                </div>

                <div class="form-row">
                    <label>Nota Final (calculada automaticamente):</label>
                    <input type="number" step="0.1" name="nota_final" value="<?= htmlspecialchars($estagio['nota_final']) ?>" readonly><br>
                </div>

                <button type="submit" name="submit">Salvar Notas</button>
            </form>
        <?php endif; ?>

        <p><a href="registar_notas.php">Voltar</a></p>
    </body>
</html>


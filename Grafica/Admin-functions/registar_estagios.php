<?php
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'projeto_estagios_2';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Erro de ligação à base de dados.');
    }

    function existe($conn, $tabela, $coluna, $valor) {
        $stmt = $conn->prepare("SELECT 1 FROM $tabela WHERE $coluna = ? LIMIT 1");
        $stmt->bind_param("i", $valor);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    $erro = null;
    if (isset($_POST['submit'])) {

        $empresa_id = $_POST['estabelecimento_empresa_id'];
        $estabelecimento_id = $_POST['estabelecimento_id'];
        $aluno_id = $_POST['aluno_id'];
        $formador_id = $_POST['formador_id'];
        $data_inicio = $_POST['data_inicio'];

        if (!existe($conn, 'empresa', 'empresa_id', $empresa_id)) {
            $erro = "Empresa inválida.";
        }
        elseif (!existe($conn, 'estabelecimento', 'estabelecimento_id', $estabelecimento_id)) {
            $erro = "Estabelecimento inválido.";
        }
        elseif (!existe($conn, 'aluno', 'utilizador_id', $aluno_id)) {
            $erro = "Aluno inválido.";
        }
        elseif (!existe($conn, 'formador', 'utilizador_id', $formador_id)) {
            $erro = "Formador inválido.";
        }

        if ($erro === null) {
            $data_fim = $_POST['data_fim'] ?: null;
            $nota_empresa = $_POST['nota_empresa'] ?: null;
            $nota_escola = $_POST['nota_escola'] ?: null;
            $nota_relatorio = $_POST['nota_relatorio'] ?: null;
            $nota_procura = $_POST['nota_procura'] ?: null;
            $nota_final = $_POST['nota_final'] ?: null;
            $classificacao = $_POST['classificacao'] ?: null;

            $stmt = $conn->prepare("
                INSERT INTO estagio (
                    estabelecimento_empresa_id,
                    estabelecimento_id,
                    aluno_id,
                    formador_id,
                    data_inicio,
                    data_fim,
                    nota_empresa,
                    nota_escola,
                    nota_relatorio,
                    nota_procura,
                    nota_final,
                    classificacao
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "iiiissdddddi",
                $empresa_id,
                $estabelecimento_id,
                $aluno_id,
                $formador_id,
                $data_inicio,
                $data_fim,
                $nota_empresa,
                $nota_escola,
                $nota_relatorio,
                $nota_procura,
                $nota_final,
                $classificacao
            );
  
            if ($stmt->execute()) {
                header("Location: verificar_estagios.php");
                exit();
            } else {
                echo "<p>Erro ao registar estágio: " . $stmt->error . "</p>";
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
        <link rel="stylesheet" href="../php-css/style-admin.css">
    </head>
    <body>

        <h1>Registar Novo Estágio</h1>

        <?php if ($erro): ?>
            <p style="color:red; font-weight:bold;">
                <?= htmlspecialchars($erro) ?>
            </p>
        <?php endif; ?>

        <form method="post">

            <label>Empresa ID:</label>
            <input type="number" name="estabelecimento_empresa_id" required><br>

            <label>Estabelecimento ID:</label>
            <input type="number" name="estabelecimento_id" required><br>

            <label>Aluno ID:</label>
            <input type="number" name="aluno_id" required><br>

            <label>Formador ID:</label>
            <input type="number" name="formador_id" required><br>

            <label>Data Início:</label>
            <input type="date" name="data_inicio" required><br>

            <label>Data Fim:</label>
            <input type="date" name="data_fim"><br>

            <label>Nota Empresa:</label>
            <input type="number" step="0.01" name="nota_empresa"><br>

            <label>Nota Escola:</label>
            <input type="number" step="0.01" name="nota_escola"><br>

            <label>Nota Relatório:</label>
            <input type="number" step="0.01" name="nota_relatorio"><br>

            <label>Nota Procura:</label>
            <input type="number" step="0.01" name="nota_procura"><br>

            <label>Nota Final:</label>
            <input type="number" step="0.01" name="nota_final"><br>

            <label>Classificação:</label>
            <input type="number" name="classificacao"><br>

            <button type="submit" name="submit">Registar Estágio</button>

        </form>

        <p><a href="verificar_estagios.php">Cancelar</a></p>

    </body>
</html>
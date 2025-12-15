<?php

    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'projeto_estagios_2';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn -> connect_error){
        die('Erro de ligação à base de dados.');
    }

    if (isset($_GET['delete_empresa_id'], $_GET['delete_estabelecimento_id'], $_GET['delete_aluno_id'])) {
        $empresa_id = $_GET['delete_empresa_id'];
        $estabelecimento_id = $_GET['delete_estabelecimento_id'];
        $aluno_id = $_GET['delete_aluno_id'];
        
        $conn->query("DELETE FROM estagio 
                    WHERE estabelecimento_empresa_id = $empresa_id 
                    AND estabelecimento_id = $estabelecimento_id 
                    AND aluno_id = $aluno_id");
    }

    $result = $conn->query("
        SELECT 
            s.estabelecimento_empresa_id,
            s.estabelecimento_id,
            s.aluno_id,
            s.formador_id,
            s.data_inicio,
            s.data_fim,
            nome_estabelecimento(s.estabelecimento_id, s.estabelecimento_empresa_id) AS estabelecimento_nome,
            nome_empresa(s.estabelecimento_empresa_id) AS empresa_nome,
            nome_aluno(s.aluno_id) AS aluno_nome,
            nome_formador(s.formador_id) AS formador_nome
        FROM estagio s
        ORDER BY s.data_inicio DESC
    ");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
    <meta http-equiv="Content-Type" content="text/html:charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SiEstagios</title>
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="../../php-css/style-admin-estagios.css">
    </head>

    <body>
        <div class="container">
            <h1>Estágios</h1>
            <table border="1" cellpadding="10">
            <tr>
                <th>Estabelecimento</th>
                <th>Empresa</th>
                <th>Data Início</th>
                <th>Aluno</th>
                <th>Formador</th>
                <th>Ações</th>
            </tr>

            <?php while($row = $result->fetch_assoc()): ?>

            <tr>
                <td><?= htmlspecialchars($row['estabelecimento_nome']) ?></td>
                <td><?= htmlspecialchars($row['empresa_nome']) ?></td>
                <td><?= $row['data_inicio'] ?></td>
                <td><?= htmlspecialchars($row['aluno_nome']) ?></td>
                <td><?= htmlspecialchars($row['formador_nome']) ?></td>
                <td>
                    <?php if (is_null($row['data_fim']) || strtotime($row['data_fim']) >= time()): ?>
                        <a href="editar_estagio.php?empresa_id=<?= $row['estabelecimento_empresa_id'] ?>&estabelecimento_id=<?= $row['estabelecimento_id'] ?>&aluno_id=<?= $row['aluno_id'] ?>&formador_id=<?= $row['formador_id'] ?>">Editar</a> |
                        <a href="?delete_empresa_id=<?= $row['estabelecimento_empresa_id'] ?>&delete_estabelecimento_id=<?= $row['estabelecimento_id'] ?>&delete_aluno_id=<?= $row['aluno_id'] ?>" onclick="return confirm('Tem a certeza?')">Apagar</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>

            </tr>

            <?php endwhile; ?>

        </table>

        <p class="form-footer-login">
            <a href="registar_estagios.php" class="portal-btn">Registar Novo Estágio</a>
        </p>

    </body>
</html>
<?php
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'projeto_estagios_2';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Erro de ligação à base de dados.');
    }

    $empresa_id = $_GET['empresa_id'] ?? null;
    if (!$empresa_id) {
        die('Empresa inválida.');
    }

    $result = $conn->query("
        SELECT
            est.estabelecimento_id,
            est.nome_comercial,
            est.morada AS morada_estabelecimento,
            est.localidade AS localidade_estabelecimento,

            r.nome AS responsavel_nome,
            r.cargo,
            r.telemovel,
            r.email,

            e.firma,
            e.morada_sede,
            e.localidade AS localidade_empresa,
            e.telefone,

            ra.descricao AS ramo_atividade
        FROM estabelecimento est
        JOIN empresa e ON est.empresa_id = e.empresa_id
        JOIN responsavel r ON est.responsavel_id = r.responsavel_id
        JOIN trabalha t ON e.empresa_id = t.empresa_id
        JOIN ramo_atividade ra ON t.ramo_atividade_id = ra.ramo_atividade_id
        WHERE e.empresa_id = $empresa_id
          AND est.aceitou_estagiarios = 'sim'
    ");
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
        <link rel="stylesheet" href="../../php-css/style-aluno.css">
    </head>

    <body>
        <div class="container">
            <h1>Estágios da Empresa</h1>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>

                    <div class="estagio-card">

                        <h3><?= htmlspecialchars($row['nome_comercial']) ?></h3>
                        <p>
                            <strong>Morada:</strong>
                            <?= htmlspecialchars($row['morada_estabelecimento']) ?>,
                            <?= htmlspecialchars($row['localidade_estabelecimento']) ?>
                        </p>

                        <p>
                            <strong>Responsável:</strong>
                            <?= htmlspecialchars($row['responsavel_nome']) ?><br>
                            <strong>Cargo:</strong> <?= htmlspecialchars($row['cargo']) ?><br>
                            <strong>Telemóvel:</strong> <?= htmlspecialchars($row['telemovel'] ?? '-') ?><br>
                            <strong>Email:</strong> <?= htmlspecialchars($row['email'] ?? '-') ?>
                        </p>

                        <p>
                            <strong>Empresa:</strong> <?= htmlspecialchars($row['firma']) ?><br>
                            <strong>Ramo de Atividade:</strong> <?= htmlspecialchars($row['ramo_atividade']) ?><br>
                            <strong>Sede:</strong>
                            <?= htmlspecialchars($row['morada_sede']) ?>,
                            <?= htmlspecialchars($row['localidade_empresa']) ?><br>
                            <strong>Telefone:</strong> <?= htmlspecialchars($row['telefone']) ?>
                        </p>

                        <p>
                            <strong>Transportes disponíveis:</strong><br>
                            <?php
                                $transportes = $conn->query("
                                    SELECT t.meio_transporte, t.linha
                                    FROM servido s
                                    JOIN transporte t ON s.transporte_id = t.transporte_id
                                    WHERE s.estabelecimento_empresa_id = $empresa_id
                                    AND s.estabelecimento_id = {$row['estabelecimento_id']}
                                ");

                                if ($transportes->num_rows > 0):
                                    while ($t = $transportes->fetch_assoc()):
                                        echo "- " . htmlspecialchars($t['meio_transporte']);
                                        if ($t['linha']) echo " ({$t['linha']})";
                                        echo "<br>";
                                    endwhile;
                                else:
                                    echo "Sem informação de transportes.";
                                endif;
                            ?>
                        </p>

                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p>Esta empresa não tem estágios disponíveis.</p>
            <?php endif; ?>

            <p class="form-footer">
                <a href="consultar_empresas.php">Voltar às empresas</a>
            </p>
        </div>
    </body>
</html>

<?php
    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'projeto_estagios_2';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Erro de ligação à base de dados.');
    }

    $ano_atual = date('Y');

    $ramo = $_GET['ramo'] ?? '';
    $localidade = $_GET['localidade'] ?? '';

    $query = "
        SELECT DISTINCT
            e.empresa_id,
            e.firma,
            e.tipo_organizacao,
            e.localidade,
            e.telefone,
            e.website
        FROM empresa e
        JOIN disponibilidade d ON e.empresa_id = d.empresa_id
        JOIN trabalha t ON e.empresa_id = t.empresa_id
        JOIN ramo_atividade r ON t.ramo_atividade_id = r.ramo_atividade_id
        WHERE d.ano = $ano_atual
    ";


    if (!empty($ramo)) {
        $query .= " AND r.ramo_atividade_id = $ramo";
    }

    if (!empty($localidade)) {
        $query .= " AND e.localidade = '$localidade'";
    }

    $result = $conn->query($query);

    $ramos = $conn->query("SELECT ramo_atividade_id, descricao FROM ramo_atividade");
    $localidades = $conn->query("SELECT DISTINCT localidade FROM empresa");
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
            <h1>Empresas com Estágio Disponível -<?= $ano_atual ?></h1>

            <form method="get">
                <label>Ramo de Atividade:</label>
                    <select name="ramo">
                        <option value=""> Todos </option>
                            <?php while ($r = $ramos->fetch_assoc()): ?>
                                <option value="<?= $r['ramo_atividade_id'] ?>"
                                    <?= ($ramo == $r['ramo_atividade_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['descricao']) ?>
                                </option>
                            <?php endwhile; ?>
                    </select>

                <label>Localidade:</label>
                    <select name="localidade">
                        <option value=""> Todas </option>
                            <?php while ($l = $localidades->fetch_assoc()): ?>
                                <option value="<?= $l['localidade'] ?>"
                                    <?= ($localidade == $l['localidade']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($l['localidade']) ?>
                                </option>
                            <?php endwhile; ?>
                    </select>

                <button type="submit">Filtrar</button>
            </form>

            <table>
                <tr>
                    <th>Empresa</th>
                    <th>Tipo de Organização</th>
                    <th>Localidade</th>
                    <th>Telefone</th>
                    <th>Website</th>
                    <th>Estágios</th>

                </tr>

                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['firma']) ?></td>
                            <td><?= htmlspecialchars($row['tipo_organizacao']) ?></td>
                            <td><?= htmlspecialchars($row['localidade']) ?></td>
                            <td><?= htmlspecialchars($row['telefone']) ?></td>
                            <td>
                                <?= $row['website']
                                    ? "<a href='{$row['website']}' target='_blank'>Visitar</a>"
                                    : "-" ?>
                            </td>
                            <td>
                                <a href="estagios_empresa.php?empresa_id=<?= $row['empresa_id'] ?>">
                                    Ver Estágios
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhuma empresa encontrada.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </body>
</html>

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

// Atualizar notas se o form tiver sido submetido
if (isset($_POST['submit'])) {
    $empresa_id = $_POST['empresa_id'];
    $estabelecimento_id = $_POST['estabelecimento_id'];
    $aluno_id = $_POST['aluno_id'];

    $nota_empresa = $_POST['nota_empresa'] ?: 0;
    $nota_escola = $_POST['nota_escola'] ?: 0;
    $nota_relatorio = $_POST['nota_relatorio'] ?: 0;
    $nota_procura = $_POST['nota_procura'] ?: 0;

    // Calcula nota final
    $nota_final = ($nota_empresa + $nota_escola + $nota_relatorio + $nota_procura) / 4;

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
        "dddddiii",
        $nota_empresa, $nota_escola, $nota_relatorio, $nota_procura, $nota_final,
        $empresa_id, $estabelecimento_id, $aluno_id
    );

    if (!$stmt->execute()) {
        $erro = "Erro ao atualizar notas: " . $stmt->error;
    }
}

// Buscar todos os estágios finalizados
$stmt = $conn->prepare("
    SELECT est.estabelecimento_empresa_id, est.estabelecimento_id, est.aluno_id,
           u.nome AS aluno,
           est.data_inicio, est.data_fim,
           est.nota_empresa, est.nota_escola, est.nota_relatorio, est.nota_procura, est.nota_final
    FROM estagio est
    JOIN aluno a ON est.aluno_id = a.utilizador_id
    JOIN utilizador u ON a.utilizador_id = u.utilizador_id
    WHERE est.data_fim IS NOT NULL AND est.data_fim <= CURDATE()
");


$stmt->execute();
$result = $stmt->get_result();
$estagios = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>SiEstagios</title>
        <link rel="stylesheet" href="../../php-css/style-formador.css">
    </head>
    <body>
        <h1>Registar Notas - Estágios Finalizados</h1>

            <?php if ($erro): ?>
                <p style="color:red; font-weight:bold;"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Nota Empresa</th>
                    <th>Nota Escola</th>
                    <th>Nota Relatório</th>
                    <th>Nota Procura</th>
                    <th>Nota Final</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estagios as $estagio): ?>
                    <tr>
                        <td><?= htmlspecialchars($estagio['aluno']) ?></td>
                        <td><?= htmlspecialchars($estagio['data_inicio']) ?></td>
                        <td><?= htmlspecialchars($estagio['data_fim']) ?></td>
                        <td><?= htmlspecialchars($estagio['nota_empresa']) ?></td>
                        <td><?= htmlspecialchars($estagio['nota_escola']) ?></td>
                        <td><?= htmlspecialchars($estagio['nota_relatorio']) ?></td>
                        <td><?= htmlspecialchars($estagio['nota_procura']) ?></td>
                        <td><?= htmlspecialchars($estagio['nota_final']) ?></td>
                        <td>
                            <?php if (!is_null($estagio['data_fim']) && strtotime($estagio['data_fim']) < time()): ?>
                                <a href="editar_notas.php?empresa_id=<?= $estagio['estabelecimento_empresa_id'] ?>&estabelecimento_id=<?= $estagio['estabelecimento_id'] ?>&aluno_id=<?= $estagio['aluno_id'] ?>">Modificar Notas</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="../portal_formador.html">Voltar</a></p>
    </body>
</html>

<?php 

    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'projeto_estagios_2';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn -> connect_error){
        die('Connect Error ('.$conn -> connect_errno .') ' .$conn ->connect_error);
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("SELECT * FROM utilizador WHERE utilizador_id = ? AND nome = ? AND password = ?");
    $stmt->bind_param('iss', $id, $nome, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['utilizador_id'];
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['nome'] = $user['nome'];

        switch ($user['tipo']) {
            
            case 'aluno':
                header("Location: ../Grafica/portal_aluno.html");
                exit;

            case 'formador':
                header("Location: ../Grafica/portal_formador.html");
                exit;

            case 'administrativo':
                header("Location: ../Grafica/portal_administrador.html");
                exit;

            default:
                echo "Tipo de utilizador desconhecido.";
                exit;
        }
    } else {
        header("Location: ../Grafica/login_invalid.html?error=1");
        header("Location: ../Grafica/login_invalid.html?error=1");
        exit;
    }

    $stmt->close();
    $conn->close();
?>
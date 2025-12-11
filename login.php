<?php 

    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'siestagios_p2';

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

    if ($result->num_rows > 0) {
    // Utilizador existe
        $user = $result->fetch_assoc();
        echo "Bem-vindo, " . htmlspecialchars($user['nome']) . "!";
    } else {
        header("Location: login_invalid.html?error=1");
        exit;
    }

    $stmt->close();
    $conn->close();
?>
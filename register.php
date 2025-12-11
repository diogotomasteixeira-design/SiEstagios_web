
<?php 

    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'siestagios_p2';

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn -> connect_error){
        die('Connect Error ('.$conn -> connect_errno .') ' .$conn ->connect_error);
    } 

    $result = $conn->query("SELECT MAX(utilizador_id) AS max_id FROM utilizador");
    $row = $result->fetch_assoc();
    $id = ($row['max_id'] ?? 0) + 1;

    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
    $tipos_validos = ['aluno', 'formador', 'administrativo'];
    if (!in_array($tipo, $tipos_validos)) {
        die("Tipo inválido.");
    }

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $login = $nome;

    $stmt = $conn -> prepare ("INSERT INTO utilizador (utilizador_id, login, tipo, nome, password) VALUES (?, ?, ?, ?, ?)");

    if($stmt === false){
        die('Prepare failed: ' .$conn -> error);
    }
    $stmt -> bind_param('issss', $id, $login, $tipo, $nome, $password);

    if($stmt -> execute()){
        echo "You have successfully registered. Your ID is: $id";
    } else{
        echo 'Error; ' . $stmt ->error;
    }
    
    $stmt -> close();
    $conn -> close();
?>
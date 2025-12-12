
<?php 

    $host = 'localhost';
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = 'projeto_estagios_2';

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

        $_SESSION['user_id'] = $user['utilizador_id'];
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['nome'] = $user['nome'];

        switch ($tipo) {
            
            case 'aluno':
                header("Location: ../Grafica/portal_aluno.php");
                exit;

            case 'formador':
                header("Location: ../Grafica/portal_formador.php");
                exit;

            case 'administrativo':
                header("Location: ../Grafica/portal_administrador.php");
                exit;

            default:
                echo "Tipo de utilizador desconhecido.";
                exit;
        }
    } else{
        header("Location: ../Grafica/register_invalid.html?error=1");
        exit;
    }
    
    $stmt -> close();
    $conn -> close();
?>
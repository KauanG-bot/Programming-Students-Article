<?php  
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $userEmail = 'CloudPHP';
    $userPassword = 'Log64602608';

    $dbBanco = 'articleprogrammingstudents.database.windows.net';
    $dbName = 'article';

    try {
        $conexao = new PDO(
            "sqlsrv:Server=$dbBanco;Database=$dbName",
            $userEmail,
            $userPassword,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );

        $query = "INSERT INTO usuario (Nome, Usuario, Email, Senha) VALUES (:nome, :usuario, :email, :senha)";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        if ($stmt->execute()) {
            header("Location: index.html");
        } else {
            echo "Falha ao cadastrar: " . $stmt->errorInfo()[2];
        }

    } catch (PDOException $e) {
        echo "Erro de conexão: " . $e->getMessage();
    }
} else {
    header("Location: index.html");
    exit();
}
?>

<?php  
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Credenciais do usuário
    $userEmail = 'CloudPHP';
    $userPassword = 'Log64602608';

    // Configurações do banco de dados
    $dbBanco = 'articleprogrammingstudents.database.windows.net';
    $dbName = 'article';

    try {
        // Conexão PDO usando autenticação de usuário do Azure AD
        $conexao = new PDO(
            "sqlsrv:Server=$dbBanco;Database=$dbName",
            $userEmail,
            $userPassword,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );

        // Prepara a query para evitar SQL Injection
        $query = "INSERT INTO usuario (Nome, Usuario, Email, Senha) VALUES (:nome, :usuario, :email, :senha)";
        $stmt = $conexao->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        // Executa a query
        if ($stmt->execute()) {
            // Redireciona para a página de sucesso
            header("Location: index.html");
        } else {
            // Exibe mensagem de erro
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

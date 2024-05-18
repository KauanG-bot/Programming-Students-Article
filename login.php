<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['username']) && isset($_POST['senha'])) {

        // Credenciais do usuário
        $userEmail = 'CloudPHP';
        $userPassword = 'Log64602608';

        // Configurações do banco de dados
        $dbBanco = 'articleprogrammingstudents.database.windows.net';
        $dbName = 'article';

        try {
            // Conexão PDO usando autenticação de usuário do Azure AD
            $conn = new PDO(
                "sqlsrv:Server=$dbBanco;Database=$dbName",
                $userEmail,
                $userPassword,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

            // Prevenção contra injeção de SQL usando instruções preparadas
            $query = "SELECT * FROM usuario WHERE Usuario = ? AND Senha = ?";
            $stmt = $conn->prepare($query);

            // Verifica se a preparação da consulta foi bem-sucedida
            if (!$stmt) {
                die("Preparação da consulta falhou. " . $conn->error);
            }

            $username = $_POST['username'];
            $senha = $_POST['senha'];

            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $senha, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Login bem-sucedido, redireciona para a página de destino
                header("Location: postagem.html");
                exit();
            } else {
                // Credenciais incorretas
                echo "Usuário ou senha incorretos.";
            }

        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    } else {
        echo "Usuário e senha não foram fornecidos!";
    }
} else {
    // Redireciona se a requisição não for POST
    header("Location: postagem.html");
    exit();
}

?>

<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['username']) && isset($_POST['senha'])) {

        $userEmail = 'CloudPHP';
        $userPassword = 'Log64602608';

        $dbBanco = 'articleprogrammingstudents.database.windows.net';
        $dbName = 'article';

        try {
            $conn = new PDO(
                "sqlsrv:Server=$dbBanco;Database=$dbName",
                $userEmail,
                $userPassword,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

            $query = "SELECT * FROM usuario WHERE Usuario = ? AND Senha = ?";
            $stmt = $conn->prepare($query);

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
                header("Location: postagem.html");
                exit();
            } else {
                echo "Usuário ou senha incorretos.";
            }

        } catch (PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    } else {
        echo "Usuário e senha não foram fornecidos!";
    }
} else {
    header("Location: postagem.html");
    exit();
}

?>

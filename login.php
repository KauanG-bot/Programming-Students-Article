<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['username']) && isset($_POST['senha'])) {

        $username = $_POST['username'];
        $senha = $_POST['senha'];

        // Conexão com o banco de dados
        $dbBanco = 'localhost';
        $dbUserName = 'root';
        $dbPassword = '';
        $dbName = 'dadosusuario';

        $conn = new mysqli($dbBanco, $dbUserName, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die("Conexão falhou. " . $conn->connect_error);
        }

        // Prevenção contra injeção de SQL usando instruções preparadas
        $query = "SELECT * FROM usuario WHERE usuario = ? AND senha = ?";
        $stmt = $conn->prepare($query);

        // Verifica se a preparação da consulta foi bem-sucedida
        if (!$stmt) {
            die("Preparação da consulta falhou. " . $conn->error);
        }

        $stmt->bind_param("ss", $username, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login bem-sucedido, redireciona para a página de destino
            header("Location: teste.html");
            exit();
        } else {
            // Credenciais incorretas
            echo "Usuário ou senha incorretos.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Usuário e senha não foram fornecidos!";
    }
} else {
    // Redireciona se a requisição não for POST
    header("Location: index.html");
    exit();
}

?>

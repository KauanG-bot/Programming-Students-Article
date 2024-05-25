<?php

class Postagem {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function criarPostagem($titulo, $texto, $imagem_nome, $imagem_tipo, $imagem_dados) {
        $sql = "INSERT INTO data_publicacao (titulo, texto, imagem_nome, imagem_tipo, imagem_dados) VALUES (:titulo, :texto, :imagem_nome, :imagem_tipo, :imagem_dados)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':texto', $texto);
        $stmt->bindParam(':imagem_nome', $imagem_nome);
        $stmt->bindParam(':imagem_tipo', $imagem_tipo);
        // Codificar dados binários como base64
        $imagem_dados_base64 = base64_encode($imagem_dados);
        $stmt->bindParam(':imagem_dados', $imagem_dados_base64);
        return $stmt->execute();
    }

    public function recuperarPostagens() {
        $sql = "SELECT * FROM data_publicacao ORDER BY id DESC";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $postagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Decodificar dados base64 de imagem de cada postagem
        foreach ($postagens as &$postagem) {
            $postagem['imagem_dados'] = base64_decode($postagem['imagem_dados']);
        }

        return $postagens;
    }
}

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
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
        )
    );

    $postagem = new Postagem($conexao);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = $_POST['titulo'] ?? '';
        $texto = $_POST['texto'] ?? '';

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem_tmp = $_FILES['imagem']['tmp_name'];
            $imagem_nome = $_FILES['imagem']['name'];
            $imagem_tipo = $_FILES['imagem']['type'];
            
            // Lendo o conteúdo da imagem
            $imagem_dados = file_get_contents($imagem_tmp);
            
            // Tente salvar a postagem
            if ($postagem->criarPostagem($titulo, $texto, $imagem_nome, $imagem_tipo, $imagem_dados)) {
                echo "Postagem criada com sucesso!";
            } else {
                echo "Falha ao criar a postagem.";
            }
        } else {
            echo "Erro no envio da imagem.";
        }
    }
    
    // Recuperando todas as postagens
    $todasPostagens = $postagem->recuperarPostagens();

    // HTML para exibir as postagens...
    echo "<!DOCTYPE html>";
    echo "<html lang='pt-br'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">';
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<link href=\"postagem.css\" rel=\"stylesheet\"/>";
    echo "<title>Postagens</title>";
    echo "</head>";
    echo "<body>";
    echo "<div class=\"tela\">
    <div class=\"Cabecalho\">
        <a href=\"index.html\" class=\"Home\">Home</a>
        <a href=\"ArtigoPython.html\"  class=\"Artigos\">Artigos</a>
        <a class=\"Sobre\">Sobre n&oacute;s</a>
        <p class=\"Kode\">KodeStudy</p>
        <img src=\"Imagens/image.png\" class=\"Kodeimage\">
    </div>
</div>";


    foreach ($todasPostagens as $post) {
        echo "<div class='postagem' style='text-align:center;'>";
        echo "<h2 style='text-align:center; margin-bottom: 20px; margin-top: 40px;'>" . (isset($post['titulo']) && !empty($post['titulo']) ? htmlspecialchars($post['titulo']) : 'Título não disponível') . "</h2>";
        echo "<p style='text-align:center;'>" . (isset($post['texto']) && !empty($post['texto']) ? htmlspecialchars($post['texto']) : 'Texto não disponível') . "</p>";
        if (!empty($post['imagem_dados']) && !empty($post['imagem_tipo'])) {
            echo "<img src='data:{$post['imagem_tipo']};base64," . base64_encode($post['imagem_dados']) . "' alt='Imagem da postagem' style='display:block; margin: 0 auto;'>";
        } else {
            echo "<p style='text-align:center;'>Imagem não disponível</p>";
        }
        echo "</div>";
    }
    
    echo "</body>";
    echo "</html>";

} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
}

?>

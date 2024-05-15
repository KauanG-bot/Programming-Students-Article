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
        $stmt->bindParam(':imagem_dados', $imagem_dados, PDO::PARAM_LOB);
        return $stmt->execute();
    }

    public function recuperarPostagens() {
        $sql = "SELECT * FROM data_publicacao ORDER BY id DESC";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$dbBanco = 'localhost';
$dbUserName = 'root';
$dbPasword = '';
$dbName = 'usuario'; 
$dsn = "mysql:host=$dbBanco;dbname=$dbName";
$usuario = $dbUserName;
$senha = $dbPasword;

try {
    $conexao = new PDO($dsn, $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $postagem = new Postagem($conexao);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = $_POST['titulo'] ?? '';
        $texto = $_POST['texto'] ?? '';

        if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem_tmp = $_FILES['imagem']['tmp_name'];
            $imagem_nome = $_FILES['imagem']['name'];
            $imagem_tipo = $_FILES['imagem']['type'];
            $imagem_dados = file_get_contents($imagem_tmp);
            
            $postagem->criarPostagem($titulo, $texto, $imagem_nome, $imagem_tipo, $imagem_dados);
        } else {
            echo "Erro no envio da imagem.";
        }
    }
    
  
    $todasPostagens = $postagem->recuperarPostagens();


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

    echo "<h1 class=\"postagenscenter\">Postagens</h1>";

    
 foreach ($todasPostagens as $post) {
    echo "<div class='postagem'>";
    // Use isset() para verificar se o título e o texto estão definidos e não vazios
    echo "<h2 class>" . (isset($post['Titulo']) && !empty($post['Titulo']) ? $post['Titulo'] : 'Título não disponível') . "</h2>";
    echo "<p>" . (isset($post['Texto']) && !empty($post['Texto']) ? $post['Texto'] : 'Texto não disponível') . "</p>";
    if (!empty($post['imagem_dados']) && !empty($post['imagem_tipo'])) {
        echo "<img src='data:{$post['imagem_tipo']};base64," . base64_encode($post['imagem_dados']) . "' alt='Imagem da postagem'>";
    } else {
        echo "<p>Imagem não disponível</p>";
    }
    echo "</div>";
}



    
    echo "</body>";
    echo "</html>";

} catch(PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
}

?>

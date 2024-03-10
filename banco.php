<?php  
  if($_SERVER["REQUEST_METHOD"] =="POST"){

    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $senha= password_hash($_POST["senha"],PASSWORD_DEFAULT);
  

    $dbBanco = 'localhost';
    $dbUserName = 'root';
    $dbPasword = '';
    $dbName = 'dadosusuario';
    
     $coon = new mysqli($dbBanco,$dbUserName, $dbPasword, $dbName);
    
     if($coon ->connect_error){
       die("Conexão falhou. " .$coon->connect_error);
     }

$nome = $coon->real_escape_string($nome);
$usuario = $coon->real_escape_string($usuario);
$email = $coon->real_escape_string($email);

$query = "INSERT INTO usuario (nome, usuario, email, senha) VALUES ('$nome', '$usuario', '$email', '$senha')";

if($coon->query($query) === true){
    //mudar o local do logi Aqui!
    header("Location: login.html");
}
else{
    echo "Falha ao cadastrar" .$coon->error; 
}

$coon->close();
}
else{
    header("Location:index.html");
    exit();
}
?>


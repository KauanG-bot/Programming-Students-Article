<?php  

  if($_SERVER["REQUEST_METHOD"] =="POST"){

    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $senha= ($_POST["senha"]);
  

    $dbBanco = 'localhost';
    $dbUserName = 'root';
    $dbPasword = '';
    $dbName = 'usuario';
    
     $coon = new mysqli($dbBanco,$dbUserName, $dbPasword, $dbName);
    
     if($coon ->connect_error){
       die("Conexão falhou. " .$coon->connect_error);
     }

$nome = $coon->real_escape_string($nome);
$usuario = $coon->real_escape_string($usuario);
$email = $coon->real_escape_string($email);

$query = "INSERT INTO usuario (Nome, Usuario, Email, Senha) VALUES ('$nome', '$usuario', '$email', '$senha')";

if($coon->query($query) === true){
    //mudar o local do login Aqui!
    header("Location: teste.html");
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


<?php

if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
  $user = $_POST["email"];
  $pass = $_POST["pass"];

  require_once "src/FuncionarioDAO.php";

  $bd = new FuncionarioDAO();
  
  
  if( count($bd->listarLogin($user)) > 0 )  {
    //Testando se o nome de usuário é igual ao guardado no banco de dados
    if( $bd->listarLogin($user)[0][2] == $user ) {
        if( $bd->listarLogin($user)[0][4] == md5($pass) ) {
            $_SESSION["user"] = $bd->listarLogin($user);
            
            header("location: estoque.php");
            } else {
                echo "<script>
                    alert('Acesso negado!')
                </script>";  
            }
        } 
    } else {
        echo "<script>
            alert('Acesso negado!')
        </script>";
    }
    //var_dump( md5($pass) );
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <main>
        <img src="logo-removebg-preview.png" alt="Logo da empresa" id="logo">
        <h1>Bem Vindo</h1>
        <form action="#" method="post">
            <input type="email" name="email" id="email" placeholder="Digite seu email" required>
            <br><br>
            <input type="password" name="pass" id="pass" placeholder="Digite sua senha" required>
            <br><br>
           <a href="estoque.php"><input type="submit" value="ENTRAR"></a>
            <a href="cadastro.php"><input type="button" value="CADASTRE-SE." id="btn_cadastro"></a>
        </form>
        <footer>
            <small>Nenhum direito reservado &copy;</small>
        </footer>
    </main>
</body>
</html>

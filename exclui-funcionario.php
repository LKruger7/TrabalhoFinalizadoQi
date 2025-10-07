<?php 

if( isset($_GET["id"])) {
    require_once("src/FuncionarioDAO.php");
    $bd = new FuncionarioDAO();
    $id = intval($_GET["id"]);

    try {
        $bd->apagar($id);
         echo "<script>
                alert('✅ Funcionário(a) excluido(a)!');
                window.location.replace('cadastro.php');
            </script>";
    } catch(Exception $erro) {
        echo "<script>
                alert('❌ Ocorreu algum erro...');
                window.location.replace('cadastro.php');
            </script>";
    }

} else {
    header("location: cadastro.php");
}
    
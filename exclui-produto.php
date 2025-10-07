<?php

if( isset($_GET["id"]) ) {
    require_once "src/ProdutoDAO.php";
    $bd = new ProdutoDAO();
    $id = intval( $_GET["id"] );
    
    try {
        $bd->apagar($id);
        echo "<script>
                alert('✅ Produto excluido!');
                window.location.replace('estoque.php');
            </script>";
    } catch(Exception $erro) {
        echo "<script>
                alert('❌ Ocorreu algum erro...');
                window.location.replace('estoque.php');
            </script>";
    }

} else {
    header("location: index.php");
}
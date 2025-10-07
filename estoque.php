<?php 

require_once("src/ProdutoDAO.php");
require_once("src/Produto.php");

$bd = new ProdutoDAO();


session_start();

if(isset($_SESSION["estoque"])) {
    $_SESSION["estoque"] = null;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto = $_POST["produto"];
    $data_hora = $_POST["data_hora"] ?? "";
    $quantidade = intval($_POST["quantidade"]);
    $preco = floatval($_POST["preco"]);

    $objProduto = new Produto(
        produto: $produto,
        data_hora: $data_hora,
        quantidade: $quantidade,
        preco: $preco
    );

    try {
        if ($_POST["id"] != null || $_POST["id"] != "") {
            $id = $_POST["id"];
            $result = $bd->editar(intval($id), $objProduto);
            $_SESSION["estoque"] = "Produto Editado!";
    } else {
    $bd->salvar($objProduto);
    $_SESSION["estoque"] = "Produto Registrado!";
    }
} catch(Exception $erro) {
    //$_SESSION["estoque"] = "Ocorreu algum erro...";
    $_SESSION["estoque"] = $erro;
}

//var_dump($_SESSION["estoque"]);
//var_dump($data_hora);

echo "<script> 
        alert('{$_SESSION["estoque"]}');
    </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_estoque.css">
    <title>ESTOQUE</title>
</head>
<body>
      <header>
  <img src="WhatsApp_Image_2025-09-17_at_20.56.56-removebg-preview.png" alt="Logo do site" class="logo">
  <h2>Controle de Estoque:</h2>
</header>

<main>
        <h1 id="titulo">Registrar Produto:</h1>
    <form action="#" method="post">
        <div id="box">
            <div>
                <label for="produto">Produto:</label>
                <input type="text" name="produto" id="produto" required>
            </div>

            <div>
                <label for="data_hora">Data e hora: </label>
                <input type="datetime-local" name="data_hora" id="data_hora">
            </div>
            <div>
                <label for="quantidade">Quantidade:</label>
                <input type="number" name="quantidade" id="quantidade" min="1" required>
                <div>
                    <label for="preco">Preço:</label>
                    <input type="number" name="preco" id="preco" min="0.01" step="0.01"  required>

                </div>
            </div>
        </div>
        <input type="hidden" name="id" id="id">
        <input type="submit" id="btn-submit" value="Registrar produto">
        <button type="button" id="btn-cancelar" onclick="restaurar()">Cancelar</button>

    </form>

     <hr>

    <section id="lista">
    <h3>Lista de produtos:</h3>

    <table>
        <thead>
            <th>ITEM</th>
            <th>Produto</th>
            <th>DATA/HORA</th>
            <th>QUANTIDADE</th>
            <th>PREÇO</th>
            <th></th>
            <th></th>
            <table>
                 </thead>
        <tbody>
            <?php foreach ( $bd->listarTodos() as $pd) : ?>
                <tr>
                    <td> <?= $pd[0] ?> </td>
                    <td> <?= $pd[1] ?> </td>
                    <td> <?= date('d/m/Y - h:i', strtotime($pd[2])) ?> </td>
                    <td> <?= $pd[3] ?> </td>
                    <td> <?= $pd[4] ?> </td>
                    <td>
                        <button onclick="editar(
                                        <?= $pd[0] ?>,
                                        '<?= $pd[1] ?>',
                                        '<?= date('Y-m-d\T\h:i', strtotime($pd[2])) ?>',
                                        <?= $pd[3] ?>,
                                        <?= $pd[4] ?>
                                      )">Alterar</button>
                    </td>
                    <td>
                        <button onclick="excluir(<?= $pd[0] ?>, '<?= $pd[1] ?>')">Excluir</button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
            </table>
    </section>

    <script>
         const titulo = document.getElementById("titulo");
         const campoId = document.getElementById("id");
        const campoProduto = document.getElementById("produto");
        const campoData = document.getElementById("data_hora");
        const campoQuantidade = document.getElementById("quantidade");
        const campoPreco = document.getElementById("preco");
        const btnSubmit = document.getElementById("btn-submit");
        const btnAlterar = document.getElementById("btn-alterar");
        const btnCancelar = document.getElementById("btn-cancelar");
        const lista = document.getElementById("lista");


        btnCancelar.style.display = "none";
            
        function editar(id, produto, data_hora, quantidade, preco){
        btnCancelar.style.display = "inline";
        titulo.innerHTML = "Editar produto";
        btnSubmit.value = "Atualizar";
        campoId.value = id;
        campoProduto.value = produto;
        campoData.value = data_hora;
        campoQuantidade.value = quantidade;
        campoPreco.value = preco;
        }

        function restaurar() {
            window.location.reload();
        }

        function excluir(id, produto) {
            if( confirm("Excluir o produto "+ produto +"?") ) {
                window.location.replace("exclui-produto.php?id=" + id)
            }
        }


    </script>
</main>
</body>
</html>

        
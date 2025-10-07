<?php

require_once ("src/FuncionarioDAO.php");
require_once ("src/Funcionario.php");

$bd = new FuncionarioDAO();


session_start();

if(isset($_SESSION["estoque"])) {
    $_SESSION["estoque"] = null;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];
    $senha = md5($_POST["senha"]);

    $objFuncionario = new Funcionario(
        nome : $nome,
        email: $email,
        cpf: $cpf,
        senha: $senha
    );

    try {
        if ($_POST["id"] != null || $_POST["id"] != "") {
            $id = $_POST["id"];
            $result = $bd->editar(intval($id), $objFuncionario);
            $_SESSION["estoque"] = "Funcionário(a) Editado(a)!";
    } else {
    $bd->salvar($objFuncionario);
    $_SESSION["estoque"] = "Funcionário(a) Cadastrado(a) ";
}
} catch(Exception $erro) {
    $_SESSION["estoque"] = $erro;
}
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
    <title>CADASTRO</title>
    <link rel="stylesheet" href="e">
</head>
<body>
    <main>
        <img src="logo-removebg-preview.png" alt="Logo da empresa" id="logo_cadastro">
        <h1 id="titulo">Novo Usuário</h1>
        <form action="#" method="post">
            <div id="box">
                <div>

                </div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome_cadastro" placeholder="Digite seu nome" required>
                </div>  
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Digite seu email" required>
                </div>

                <div>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" placeholder="Digite seu CPF" min="1" max="16" required>
                </div>
                <div>
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>
                </div>
                <input type="hidden" name="id" id="id">
                <input type="submit" id="btn-submit" value="Registrar Usuário">
                <button type="button" id="btn-cancelar" onclick="restaurar()">Cancelar</button>
        </form>

        <hr>

         <section id="lista">
    <h3>Lista de cadastrados:</h3>

    <table>
        <thead>
            <th>NOME</th>
            <th>EMAIL</th>
            <th>CPF</th>
            <th>SENHA</th>
            <th></th>
            <th></th>
                 </thead>
        <tbody>
            <?php foreach ( $bd->listarTodos() as $fn ) : ?>
                <tr>
                    <td> <?= $fn[0] ?></td>
                    <td> <?= $fn[1] ?></td>
                    <td> <?= $fn[2] ?></td>
                    <td> <?= $fn[3] ?></td>
                    <td>
                        <button onclick="editar(
                        <?= $fn[0] ?>,
                        '<?= $fn[1] ?>',
                        '<?= $fn[2] ?>',
                        '<?= $fn[3] ?>'
                        )">Alterar</button>
                    </td>
                    <td>
                        <button onclick="excluir(<?= $fn[0] ?>, '<?= $fn[1] ?>')">Excluir</button>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
    </table>
         </section>

         <script>

         const titulo = document.getElementById("titulo");
         const campoId = document.getElementById("id");
        const campoNome = document.getElementById("nome");
        const campoEmail = document.getElementById("email");
        const campoCpf = document.getElementById("cpf");
        const campoSenha = document.getElementById("senha");
        const btnSubmit = document.getElementById("btn-submit");
        const btnCancelar = document.getElementById("btn-cancelar");
        const btnAlterar = document.getElementById("btn-alterar");
        const lista = document.getElementById("lista");

        btnCancelar.style.display = "none";

        function editar(id, nome, email, cpf, senha) {
            btnCancelar.style.display = "inline";
            titulo.innerHTML = "Editar Funcionário(a)";
            btnSubmit.value = "Atualizar";
            campoId.value = id;
            campoNome.value = nome;
            campoEmail.value = email;
            campoCpf.value = cpf;
            campoSenha.value = senha;
        }

            function restaurar() {
                window.location.reload();
            }
            function excluir(id, nome) {
                 if( confirm("Excluir o(a) funcionario(a) "+ nome +"?") ) {
                window.location.replace("exclui-funcionario.php?id=" + id)
            }
        }
            

         </script>
    </main>
</body>
</html>
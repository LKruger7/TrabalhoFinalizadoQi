<?php

require_once "Conexao.php";

class FuncionarioDAO {
    private $con;
    private $table = "usuarios";
    private $id = "id_usuario";

     private function getCon() {
        $bd = new Conexao();
        $this->con = $bd->getMysqli();
        return $this->con;
    }

    public function salvar (Funcionario $funcionario) {
        $sql = "INSERT INTO {$this->table}(nome, email, cpf, senha)
        VALUES(
        '{$funcionario->getNome()}',
        '{$funcionario->getEmail()}',
        '{$funcionario->getCpf()}',
        '{$funcionario->getSenha()}'
        )";

        $status = $this->getCon()->query($sql);
        $this->getCon()->close();

        return $status;
    }

    public function listarTodos()
    {
        $sql = "SELECT * FROM {$this->table}";

        $lista = $this->getCon()->query($sql)->fetch_all();

        $this->getCon()->close();

        return $lista;
    }

    public function listarLogin($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = '$email' ";

        $user = $this->getCon()->query($sql)->fetch_all();

        $this->getCon()->close();

        return $user;
    }

      public function apagar($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->id} = $id";

        $result = $this->getCon()->query($sql);

        $this->getCon()->close();

        return $result;
    }

    public function editar(int $id, Funcionario $funcionario)
    {
        $sql = "UPDATE {$this->table} SET
                nome = '{$funcionario->getNome()}',
                email = '{$funcionario->getEmail()}',
                cpf = '{$funcionario->getCpf()}',
                senha = '{$funcionario->getSenha()}' WHERE
                {$this->id} = $id";

                $status = $this->getCon()->query($sql);
                $this->getCon()->close();

                return $status;
    }


}
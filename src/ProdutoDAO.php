<?php 

require_once "Conexao.php";

class ProdutoDAO{
    private $con;
    private $table = "produtos";
    private $id = "id_produto";

    private function getCon() {
        $bd = new Conexao ();
        $this->con = $bd->getMysqli();
        return $this->con;
    }

    public function salvar (Produto $produtos)
    {
        $sql = "INSERT INTO {$this->table}(produto, data_hora, quantidade, preco )
        VALUES(
        '{$produtos->getProduto()}',
        '{$produtos->getData_Hora()}',
        '{$produtos->getQuantidade()}',
        '{$produtos->getPreco()}'
        )";

        $status = $this->getCon()->query($sql);

        $this->getCon()->close();
        
        return $status;
    }

    public function listarTodos ()
    {
                $sql = "SELECT * FROM {$this->table}";

        $lista = $this->getCon()->query($sql)->fetch_all();

        $this->getCon()->close();

        return $lista;


    }

    public function apagar ($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->id} = $id";
        $status = $this->getCon()->query($sql);
        $this->getCon()->close();
        return $status;
    }

    public function editar(int $id, Produto $produtos) {
        $sql = "UPDATE {}$this->table}SET
        marca = '{$produtos->getProduto()}',
        data_hora = '{$produtos->getData_hora()}',
        quantidade = {$produtos->getQuantidade()},
        preco = {$produtos->getPreco()} WHERE
        {$this->id} = $id";

        $status = $this->getCon()->query($sql);
        $this->getCon()->close();
        return $status;
    }
}
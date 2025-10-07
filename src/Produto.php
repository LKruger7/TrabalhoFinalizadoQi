<?php

class Produto {
    private $produto;
    private $data_hora;
    private $quantidade;
    private $preco;

    public function __construct(
        $produto = "Genérica",
        $data_hora = 1,
        $quantidade = 1,
        $preco = 1
    )
    {
        $this->produto = $produto;
        $this->data_hora = $data_hora;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
    }
    public function getProduto()
    {
        return $this->produto;
    }
    public function setProduto($produto)
    {
        $this->produto = $produto;
    }

    public function getData_hora()
    {
        return $this->data_hora;
    }
    public function setData_hora($data_hora)
    {
        $this->data_hora = $data_hora;
    }
    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    public function __tostring(){
        return "<hr>
                <ul>
                <li>PRODUTO: {$this->produto}</li> 
                <li>DATA/HORA: {$this->data_hora}</li> 
                <li>QUANTIDADE: {$this->quantidade}</li> 
                <li>PREÇO: {$this->preco}</li> 
                </ul>";
    }
}
<?php
class Cliente{
    private $nome, $obeservacao, $idTelefone;

    public function __construct($nome, $obeservacao){
        $this->nome = $nome;
        $this->obeservacao = $obeservacao;
    }
    public function getnome(){
        return $this->nome;
    }
    public function getObeservacao(){
        return $this->obeservacao;
    }
    public function setnome($nome){
        $this->nome = $nome;
    }
    public function setObeservacao($obeservacao){
        $this->obeservacao = $obeservacao;
    }
}
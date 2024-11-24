<?php
require 'conexao.class.php';

class Categorias{
    private $id;
    private $name;
    private $descricao;
    private $con;

    public function __construct(){
        $this->con = new Conexao();
    }

    private function existeCategoria($nome){
        $sql = $this->con->conectar()->prepare("SELECT id FROM categorias WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();

        if( $sql->rowCount() > 0){
            $array = $sql->fetch();
    }else{
        $array = array();
    }
    return $array;
}

public function adicionar($nome, $descricao){
    $existeCategoria = $this->existeCategoria($nome);
    if(count( $existeCategoria) == 0){
        try{
            $this->nome = $nome;
            $this->descricao = $descricao;
            $sql = $this->con()->prepare("INSERT INTO categorias(nome, descricao) VALUES ( :nome, :descricao)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            $sql->execute();
            return TRUE;
        }catch(PDOException $ex){
            return "ERRO: ".$ex->getMessage();
        }
    }else{
        return FALSE;
    }
}

public function listar(){
    try{
        $sql = $this->con->conectar()->prepare('SELECT * FROM categorias');
        $sql->execute();
        return $sql->fetchAll();
    }catch(PDOException $ex){
        echo "ERRO: ".$ex->getMessage();
    }
}

public function buscar($id){
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM categorias WHERE id = id");
        $sql->bindValue('id', $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $sql->fetch();
        }else{
            return array;
        }
    }catch(PDOException $ex){
        echo 'ERRO: '.$ex->getMessage();
    }
}

public function editar($nome, $descricao, $id){
    $categoriaExistente = $this->categoriaExistente($nome);
    if(count($categoriaExistente) > 0 && $categoriaExistente['id'] != $id){
        return FALSE;
    }else{
        try{
            $sql = $this->con->conectar()->prepare("UPDATE categorias SET nome = :nome, descricao = :descricao WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue("id", $id);
            $sql->execute();
        }catch(PDOException $ex){
            echo 'ERRO: '.$ex->getMessage();
        }
    }
}

public function deletar($id){
    $sql = $this->con->conectar()->prepare("DELETE FROM categorias WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
}
}
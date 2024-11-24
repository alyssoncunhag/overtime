<?php
require 'conexao.class.php';

class Torneios{
    private $id;
    private $nome;
    private $id_jogo;
    private $descricao;
    private $data_inicio;
    private $data_fim;
    private $imagem;

    private $con;

    public function __construct(){
        $this->con = new Conexao();
    }

    private function existeTorneio($nome){
        $sql = $this->con->conectar()->prepare("SELECT id FROM torneios WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();

        if( $sql->rowCount() > 0){
            $array = $sql->fetch();
    }else{
        $array = array();
    }
    return $array;
}

public function adicionar($nome, $id_jogo, $descricao, $data_inicio, $data_fim, $imagem){
    $existeTorneio = $this->existeTorneio($nome);
    if(count( $existeTorneio) == 0){
        try{
            $this->nome = $nome;
            $this->id_jogo = $id_jogo;
            $this->descricao = $descricao;
            $this->$data_inicio = $data_inicio;
            $this->$data_fim = $data_fim;
            $this->imagem = $imagem;
            $sql = $this->con()->prepare("INSERT INTO torneios(nome, id_jogo, descricao, data_inicio, data_fim, imagem) VALUES ( :nome, :id_jogo :descricao, :data_inicio, :data_fim, :imagem)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $sql->bindParam(":id_jogo", $this->$id_jogo, PDO::PARAM_STR);
            $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            $sql->bindParam(":data_inicio", $this->data_inicio, PDO::PARAM_STR);
            $sql->bindParam(":data_fim", $this->$data_fim, PDO::PARAM_STR);
            $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
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
        $sql = $this->con->conectar()->prepare("SELECT * FROM torneios");
        $sql->execute();
        return $sql->fetchAll();
    }catch(PDOException $ex){
        echo "ERRO: ".$ex->getMessage();
    }
}

public function buscar($id){
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM torneios WHERE id = id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            return $sql->fetch();
        }else{
            return array();
        }
    }catch(PDOException $ex){
        echo 'ERRO: '.$ex->getMessage();
    }
}

public function editar($nome, $id_jogo, $descricao, $data_inicio, $data_fim, $imagem, $id){
    $torneioExistente = $this->existeTorneio($nome);
    if(count($torneioExistente) > 0 && $torneioExistente['id'] != $id){
        return FALSE;
    }else{
        try{
            $sql = $this->con->conectar()->prepare("UPDATE torneios SET nome = :nome, id_jogo, descricao = :descricao, data_inicio = :data_inicio, data_fim = :data_fim WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":id_jogo", $id_jogo);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":data_inicio", $data_inicio);
            $sql->bindValue(":data_fim", $data_fim);
            $sql->bindValue("id", $id);
            $sql->execute();

            if(count($imagem) > 0){
                for($q=0; $q < count($imagem['tmp_name']); $q++){
                    $tipo = $imagem['type'][$q];
                    if(in_array($tipo, array('image/jpeg', 'image/png'))){
                        $tmpname = md5(time().rand(0, 9999)).'.jpg';
                        move_uploaded_file($imagem['tmp_name'][$q], 'img/torneios/'.$tmpname);
                        list($width_orig, $height_orig) = getimagesize('img/torneios/'.$tmpname);
                        $ratio = $width_orig/$height_orig;

                        $width = 500;
                        $height = 500;

                        if($width/$height > $ratio){
                            $width = $width*$ratio;
                        }else{
                            $height = $width/$ratio;
                        }

                        $img = imagecreatetruecolor($width, $height);
                        if($tipo === 'image/torneios'){
                            $origi = imagecreatefromjpeg('img/torneios/'.$tmpname);
                        }elseif($tipo === 'image/png'){
                            $origi = imagecreatefromgif(''.$tmpname);
                        }
                        imagecopyresampled($img, $origi, $width, $height, $width_orig, $height_orig);
                        imagejpeg($img, 'img/torneios/'.$tmpname, 80);
                        $sql = $this->con->conectar()->prepare("INSERT INTO imagem_torneio SET id_torneio = :id_torneio, url = :url");
                        $sql->bindValue(":id_torneio", $id);
                        $sql->bindValue(":url", $tmpname);
                        $sql->execute();
                    }
                }

            }
            return TRUE;
        }catch(PDOException $ex){
            echo 'ERRO: '.$ex->getMessage();
        }
    }
}

public function deletar($id){
    $sql = $this->con->conectar()->prepare("DELETE FROM torneios WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
}
}
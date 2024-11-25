<?php
require 'conexao.class.php';

class Jogos{
    private $id;
    private $nome;
    private $descricao;
    private $data_lancamento;
    private $imagem;

    private $con;

    public function __construct(){
        $this->con = new Conexao();
        $this->permissoes = [];
    }

    private function existeJogo($nome){
        $sql = $this->con->conectar()->prepare("SELECT id FROM jogos WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
        } else {
            $array = array();
        }
        return $array;
    }
    

public function adicionar($nome, $descricao, $data_lancamento, $imagem){
    $existeJogo = $this->existeJogo($nome);
    if(count($existeJogo) == 0){
        try{
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->data_lancamento = $data_lancamento; // Corrigido
            $this->imagem = $imagem;
            $sql = $this->con->conectar()->prepare("INSERT INTO jogos (nome, descricao, data_lancamento, imagem) VALUES (:nome, :descricao, :data_lancamento, :imagem)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            $sql->bindParam(":data_lancamento", $this->data_lancamento, PDO::PARAM_STR);
            $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $sql->execute();
            return TRUE;
        } catch(PDOException $ex){
            return "ERRO: " . $ex->getMessage();
        }
    } else {
        return FALSE;
    }
}


public function listar() {
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM jogos");
        $sql->execute();
        return $sql->fetchAll();
    }catch(PDOException $ex){
        echo "ERRO: ".$ex->getMessage();
    }
}

public function buscar($id){
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM jogos WHERE id = id");
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

public function editar($nome, $descricao, $data_lancamento, $imagem, $id){
    $jogoExistente = $this->existeJogo($nome);
    if(count($jogoExistente) > 0 && $jogoExistente['id'] != $id){
        return FALSE;
    }else{
        try{
            $sql = $this->con->conectar()->prepare("UPDATE jogos SET nome = :nome, descricao = :descricao, data_lancamento = :data_lancamento WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":data_lancamento", $data_lancamento);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if(count($imagem) > 0){
                for($q=0; $q < count($imagem['tmp_name']); $q++){
                    $tipo = $imagem['type'][$q];
                    if(in_array($tipo, array('image/jpeg', 'image/png'))){
                        $tmpname = md5(time().rand(0, 9999)).'.jpg';
                        move_uploaded_file($imagem['tmp_name'][$q], 'img/jogos/'.$tmpname);
                        list($width_orig, $height_orig) = getimagesize('img/jogos/'.$tmpname);
                        $ratio = $width_orig/$height_orig;

                        $width = 500;
                        $height = 500;

                        if($width/$height > $ratio){
                            $width = $width*$ratio;
                        }else{
                            $height = $width/$ratio;
                        }

                        $img = imagecreatetruecolor($width, $height);
                        if($tipo === 'image/jpeg'){
                            $origi = imagecreatefromjpeg('img/jogos/'.$tmpname);
                        }elseif($tipo === 'image/png'){
                            $origi = imagecreatefromgif(''.$tmpname);
                        }
                        imagecopyresampled($img, $origi, $width, $height, $width_orig, $height_orig);
                        imagejpeg($img, 'img/jogos/'.$tmpname, 80);
                        $sql = $this->con->conectar()->prepare("INSERT INTO imagem_jogo SET id_jogo = :id_jogo, url = :url");
                        $sql->bindValue(":id_jogo", $id);
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
    $sql = $this->con->conectar()->prepare("DELETE FROM jogos WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
}
}
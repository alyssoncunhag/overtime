<?php
require 'conexao.class.php';

class Times{
    private $id;
    private $nome;
    private $pais;
    private $descricao;
    private $imagem;

    private $con;

    public function __construct(){
        $this->con = new Conexao();
    }

    private function existeTime($nome){
        $sql = $this->con->conectar()->prepare("SELECT id FROM times WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();

        if( $sql->rowCount() > 0){
            $array = $sql->fetch();
    }else{
        $array = array();
    }
    return $array;
}

public function adicionar($nome, $pais, $descricao, $imagem){
    // Verificando se o time já existe
    $existeTime = $this->existeTime($nome);
    if (count($existeTime) == 0) {
        try {
            $this->nome = $nome;
            $this->pais = $pais;
            $this->descricao = $descricao;
            $this->imagem = $imagem;  // Armazenando o nome do arquivo de imagem

            // Inserindo o time no banco de dados
            $sql = $this->con->conectar()->prepare("INSERT INTO times(nome, pais, descricao, imagem) VALUES (:nome, :pais, :descricao, :imagem)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $sql->bindParam(":pais", $this->pais, PDO::PARAM_STR);
            $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);  // Salvando o nome da imagem
            $sql->execute();

            return TRUE;
        } catch(PDOException $ex) {
            return "ERRO: ".$ex->getMessage();
        }
    }
    return FALSE;
}


public function listar(){
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM times");
        $sql->execute();
        return $sql->fetchAll();
    }catch(PDOException $ex){
        echo "ERRO: ".$ex->getMessage();
    }
}

public function buscar($id){
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM times WHERE id = id");
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

public function editar($nome, $pais, $descricao, $imagem, $id){
    $timeExistente = $this->existeTime($nome);
    if(count($timeExistente) > 0 && $timeExistente['id'] != $id){
        return FALSE;
    }else{
        try{
            $sql = $this->con->conectar()->prepare("UPDATE times SET nome = :nome, pais = :pais, descricao = :descricao, imagem = :imagem WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":pais", $pais);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":imagem", $imagem);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if(count($imagem) > 0){
                for($q=0; $q < count($imagem['tmp_name']); $q++){
                    $tipo = $imagem['type'][$q];
                    if(in_array($tipo, array('image/jpeg', 'image/png'))){
                        $tmpname = md5(time().rand(0, 9999)).'.jpg';
                        move_uploaded_file($imagem['tmp_name'][$q], 'img/times/'.$tmpname);
                        list($width_orig, $height_orig) = getimagesize('img/times/'.$tmpname);
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
                            $origi = imagecreatefromjpeg('img/times/'.$tmpname);
                        }elseif($tipo === 'image/png'){
                            $origi = imagecreatefromgif(''.$tmpname);
                        }
                        imagecopyresampled($img, $origi, $width, $height, $width_orig, $height_orig);
                        imagejpeg($img, 'img/times/'.$tmpname, 80);
                        $sql = $this->con->conectar()->prepare("INSERT INTO imagem_time SET id_time = :id_time, url = :url");
                        $sql->bindValue(":id_time", $id);
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
    $sql = $this->con->conectar()->prepare("DELETE FROM times WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
}
}
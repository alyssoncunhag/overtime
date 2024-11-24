<?php
require 'conexao.class.php';

class Noticias{
    private $id;
    private $titulo;
    private $conteudo;
    private $imagem;
    private $id_categoria;
    private $id_autor;
    private $data_publicacao;

    private $con;

    public function __construct(){
        $this->con = new Conexao();
    }

    private function existeNoticia($titulo){
        $sql = $this->con->conectar()->prepare("SELECT id FROM noticias WHERE titulo = :titulo");
        $sql->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $sql->execute();

        if( $sql->rowCount() > 0){
            $array = $sql->fetch();
    }else{
        $array = array();
    }
    return $array;
}

public function adicionar($titulo, $conteudo, $imagem, $id_categoria, $id_autor, $data_publicacao){
    $existeNoticia = $this->existeNoticia($titulo);
    if(count( $existeNoticia) == 0){
        try{
            $this->titulo = $titulo;
            $this->conteudo = $conteudo;
            $this->imagem = $imagem;
            $this->id_categoria = $id_categoria;
            $this->id_autor = $id_autor;
            $this->data_publicacao = $data_publicacao;
            $sql = $this->con()->prepare("INSERT INTO noticias(titulo, conteudo, imagem, id_categoria, id_autor, data_publicacao) VALUES ( :titulo, :conteudo, :imagem, :id_categoria, :id_autor, :data_publicacao)");
            $sql->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
            $sql->bindParam(":conteudo", $this->conteudo, PDO::PARAM_STR);
            $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $sql->bindParam(":id_categoria", $this->id_categoria, PDO::PARAM_STR);
            $sql->bindParam(":id_autor", $this->id_autor, PDO::PARAM_STR);
            $sql->bindParam(":data_publicacao", $this->data_publicacao, PDO::PARAM_STR);
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
        $sql = $this->con->conectar()->prepare("SELECT * FROM noticias");
        $sql->execute();
        return $sql->fetchAll();
    }catch(PDOException $ex){
        echo "ERRO: ".$ex->getMessage();
    }
}

public function buscar($id){
    try{
        $sql = $this->con->conectar()->prepare("SELECT * FROM noticias WHERE id = id");
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

public function editar($titulo, $conteudo, $imagem, $id_categoria, $id_autor, $data_publicacao, $id){
    $noticiaExistente = $this->existeNoticia($titulo);
    if(count($noticiaExistente) > 0 && $noticiaExistente['id'] != $id){
        return FALSE;
    }else{
        try{
            $sql = $this->con->conectar()->prepare("UPDATE noticia SET titulo = :titulo, conteudo = :conteudo, id_categoria, :id_autor, data_publicacao = :data_publicacao WHERE id = :id");
            $sql->bindValue(":titulo", $titulo);
            $sql->bindValue(":conteudo", $conteudo);
            $sql->bindValue(":id_categoria", $id_categoria);
            $sql->bindValue(":id_autor", $id_autor);
            $sql->bindValue(":data_publicacao", $data_publicacao);
            $sql->bindValue("id", $id);
            $sql->execute();

            if(count($imagem) > 0){
                for($q=0; $q < count($imagem['tmp_name']); $q++){
                    $tipo = $imagem['type'][$q];
                    if(in_array($tipo, array('image/jpeg', 'image/png'))){
                        $tmpname = md5(time().rand(0, 9999)).'.jpg';
                        move_uploaded_file($imagem['tmp_name'][$q], 'img/noticias/'.$tmpname);
                        list($width_orig, $height_orig) = getimagesize('img/noticias/'.$tmpname);
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
                            $origi = imagecreatefromjpeg('img/noticias/'.$tmpname);
                        }elseif($tipo === 'image/png'){
                            $origi = imagecreatefromgif(''.$tmpname);
                        }
                        imagecopyresampled($img, $origi, $width, $height, $width_orig, $height_orig);
                        imagejpeg($img, 'img/noticias/'.$tmpname, 80);
                        $sql = $this->con->conectar()->prepare("INSERT INTO imagem_noticia SET id_noticia = :id_noticia, url = :url");
                        $sql->bindValue(":id_noticia", $id);
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
    $sql = $this->con->conectar()->prepare("DELETE FROM noticias WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
}
}
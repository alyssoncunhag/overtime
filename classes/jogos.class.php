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

    private function existeJogo($id_jogo) {
        $sql = $this->con->conectar()->prepare("SELECT id FROM jogos WHERE id = :id");
        $sql->bindParam(':id', $id_jogo, PDO::PARAM_INT);
        $sql->execute();
        
        return $sql->rowCount() > 0;
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
        $sql = $this->con->conectar()->prepare("SELECT * FROM jogos WHERE id = :id");
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

public function editar($nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem, $id) {
    // Verificar se o ID do jogo é válido
    if (!$this->existeJogo($id_jogos)) {
        echo "Erro: O jogo com o ID $id_jogos não foi encontrado na tabela 'jogos'.";
        return false;
    }

    $torneioExistente = $this->existeTorneio($nome);
    if ($torneioExistente && $torneioExistente['id'] != $id) {
        return false; // Torneio com esse nome já existe
    } else {
        try {
            $sql = $this->con->conectar()->prepare("UPDATE torneios SET nome = :nome, id_jogos = :id_jogos, descricao = :descricao, data_inicio = :data_inicio, data_fim = :data_fim, imagem = :imagem WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":id_jogos", $id_jogos);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":data_inicio", $data_inicio);
            $sql->bindValue(":data_fim", $data_fim);
            $sql->bindValue(":imagem", $imagem);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if ($imagem && isset($imagem['tmp_name']) && count($imagem['tmp_name']) > 0) {
                // Processamento da imagem e inserção no banco (aqui você mantém o código para manipulação da imagem)
                for ($q = 0; $q < count($imagem['tmp_name']); $q++) {
                    $tipo = $imagem['type'][$q];
                    if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                        $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
                        move_uploaded_file($imagem['tmp_name'][$q], 'img/torneios/' . $tmpname);
                        list($width_orig, $height_orig) = getimagesize('img/torneios/' . $tmpname);
                        $ratio = $width_orig / $height_orig;

                        $width = 500;
                        $height = 500;

                        if ($width / $height > $ratio) {
                            $width = $width * $ratio;
                        } else {
                            $height = $width / $ratio;
                        }

                        $img = imagecreatetruecolor($width, $height);
                        if ($tipo === 'image/jpeg') {
                            $origi = imagecreatefromjpeg('img/torneios/' . $tmpname);
                        } elseif ($tipo === 'image/png') {
                            $origi = imagecreatefrompng('img/torneios/' . $tmpname);
                        }
                        imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                        imagejpeg($img, 'img/torneios/' . $tmpname, 80);

                        $sql = $this->con->conectar()->prepare("INSERT INTO imagem_torneio SET id_torneio = :id_torneio, url = :url");
                        $sql->bindValue(":id_torneio", $id);
                        $sql->bindValue(":url", $tmpname);
                        $sql->execute();
                    }
                }
            }
            return true;
        } catch (PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();
        }
    }
}


public function deletar($id) {
    try {
        // Primeiro, excluir dependentes da tabela torneios
        $sql = $this->con->conectar()->prepare("DELETE FROM torneios WHERE id_jogos = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        // Depois, excluir o jogo
        $sql = $this->con->conectar()->prepare("DELETE FROM jogos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        return true;
    } catch (PDOException $ex) {
        echo 'ERRO: ' . $ex->getMessage();
        return false;
    }
}

}
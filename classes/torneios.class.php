<?php
require 'conexao.class.php';

class Torneios {
    private $id;
    private $nome;
    private $id_jogos;
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

        if($sql->rowCount() > 0){
            return true; // Torneio já existe
        } else {
            return false; // Torneio não existe
        }
    }

    public function adicionar($nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem = null) {
        if (!$this->existeTorneio($nome)) {
            try {
                $this->nome = $nome;
                $this->id_jogos = $id_jogos;
                $this->descricao = $descricao;
                $this->data_inicio = $data_inicio;
                $this->data_fim = $data_fim;
                $this->imagem = $imagem;
    
                // Adicionando o torneio no banco de dados
                $sql = $this->con->conectar()->prepare("
                    INSERT INTO torneios (nome, id_jogos, descricao, data_inicio, data_fim, imagem) 
                    VALUES (:nome, :id_jogo, :descricao, :data_inicio, :data_fim, :imagem)
                ");
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
                $sql->bindParam(":id_jogo", $this->id_jogos, PDO::PARAM_INT);
                $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
                $sql->bindParam(":data_inicio", $this->data_inicio, PDO::PARAM_STR);
                $sql->bindParam(":data_fim", $this->data_fim, PDO::PARAM_STR);
                $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);  // A imagem agora é opcional
    
                $sql->execute();
                return true;
            } catch (PDOException $ex) {
                echo "Erro ao adicionar torneio: " . $ex->getMessage();
                return false;
            }
        } else {
            return false; // Torneio já existe
        }
    }

    // Métodos de listagem e edição continuam os mesmos
    public function listar() {
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM torneios");
            $sql->execute();
            return $sql->fetchAll();
        } catch(PDOException $ex) {
            echo "ERRO: ".$ex->getMessage();
        }
    }

    public function buscar($id){
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM torneios WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                return $sql->fetch();
            }else{
                return array();
            }
        } catch(PDOException $ex){
            echo 'ERRO: '.$ex->getMessage();
        }
    }

    public function editar($nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem, $id){
        $torneioExistente = $this->existeTorneio($nome);
        if($torneioExistente && $torneioExistente['id'] != $id){
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

                if($imagem && isset($imagem['tmp_name']) && count($imagem['tmp_name']) > 0){
                    // Processamento da imagem e inserção no banco
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
                                $width = $width * $ratio;
                            } else {
                                $height = $width / $ratio;
                            }

                            $img = imagecreatetruecolor($width, $height);
                            if($tipo === 'image/jpeg'){
                                $origi = imagecreatefromjpeg('img/torneios/'.$tmpname);
                            } elseif($tipo === 'image/png'){
                                $origi = imagecreatefrompng('img/torneios/'.$tmpname);
                            }
                            imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                            imagejpeg($img, 'img/torneios/'.$tmpname, 80);

                            $sql = $this->con->conectar()->prepare("INSERT INTO imagem_torneio SET id_torneio = :id_torneio, url = :url");
                            $sql->bindValue(":id_torneio", $id);
                            $sql->bindValue(":url", $tmpname);
                            $sql->execute();
                        }
                    }
                }
                return true;
            } catch(PDOException $ex) {
                echo 'ERRO: '.$ex->getMessage();
            }
        }
    }

    public function deletar($id) {
        $sql = $this->con->conectar()->prepare("DELETE FROM torneios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}
?>


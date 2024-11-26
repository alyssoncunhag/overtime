<?php
require 'conexao.class.php';

class Jogos {
    private $id;
    private $nome;
    private $descricao;
    private $data_lancamento;
    private $imagem;

    private $con;

    public function __construct() {
        $this->con = new Conexao();
    }

    private function existeJogo($id_jogo) {
        $sql = $this->con->conectar()->prepare("SELECT id FROM jogos WHERE id = :id");
        $sql->bindParam(':id', $id_jogo, PDO::PARAM_INT);
        $sql->execute();
        return $sql->rowCount() > 0;
    }

    public function adicionar($nome, $descricao, $data_lancamento, $imagem) {
        try {
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->data_lancamento = $data_lancamento;

            if ($imagem && isset($imagem['tmp_name']) && $imagem['tmp_name'] !== '') {
                $nomeImagem = md5(time() . rand(0, 9999)) . '.jpg'; // Gera um nome único para a imagem
                move_uploaded_file($imagem['tmp_name'], 'uploads/' . $nomeImagem); // Move a imagem para a pasta 'uploads'
                $this->imagem = $nomeImagem;
            } else {
                $this->imagem = NULL; // Caso não haja imagem
            }

            $sql = $this->con->conectar()->prepare("INSERT INTO jogos (nome, descricao, data_lancamento, imagem) VALUES (:nome, :descricao, :data_lancamento, :imagem)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            $sql->bindParam(":data_lancamento", $this->data_lancamento, PDO::PARAM_STR);
            $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $sql->execute();
            return true;
        } catch (PDOException $ex) {
            echo "ERRO: " . $ex->getMessage();
            return false;
        }
    }

    public function listar() {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM jogos");
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $ex) {
            echo "ERRO: " . $ex->getMessage();
            return [];
        }
    }

    public function buscar($id) {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM jogos WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch();
            } else {
                return [];
            }
        } catch (PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();
            return [];
        }
    }

    public function editar($nome, $descricao, $data_lancamento, $imagem, $id) {
        try {
            // Atualizar nome, descrição e data de lançamento
            $sql = $this->con->conectar()->prepare("UPDATE jogos SET nome = :nome, descricao = :descricao, data_lancamento = :data_lancamento WHERE id = :id");
            $sql->bindValue(":nome", $nome, PDO::PARAM_STR);
            $sql->bindValue(":descricao", $descricao, PDO::PARAM_STR);
            $sql->bindValue(":data_lancamento", $data_lancamento, PDO::PARAM_STR);
            $sql->bindValue(":id", $id, PDO::PARAM_INT);
            $sql->execute();
    
            // Verificar se uma nova imagem foi enviada
            if ($imagem && isset($imagem['tmp_name']) && !empty($imagem['tmp_name'])) {
                // Deletar imagem anterior (opcional)
                $jogoAtual = $this->buscar($id);  // Buscar o jogo atual para pegar o nome da imagem
                if (!empty($jogoAtual['imagem'])) {
                    unlink('uploads/' . $jogoAtual['imagem']);  // Deleta a imagem antiga
                }
    
                // Gerar um nome único para a nova imagem
                $nomeImagem = md5(time() . rand(0, 9999)) . '.jpg';
                move_uploaded_file($imagem['tmp_name'], 'uploads/' . $nomeImagem);  // Move a imagem para a pasta 'uploads'
    
                // Atualizar a imagem no banco
                $sql = $this->con->conectar()->prepare("UPDATE jogos SET imagem = :imagem WHERE id = :id");
                $sql->bindValue(":imagem", $nomeImagem, PDO::PARAM_STR);
                $sql->bindValue(":id", $id, PDO::PARAM_INT);
                $sql->execute();
            }
    
            return true;
        } catch (PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();
            return false;
        }
    }
    
    
    

    public function deletar($id) {
        try {
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
?>

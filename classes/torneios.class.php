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

    public function __construct() {
        $this->con = new Conexao();
    }

    private function existeTorneio($nome) {
        $sql = $this->con->conectar()->prepare("SELECT id FROM torneios WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();

        return $sql->rowCount() > 0;
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

    public function listar() {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM torneios");
            $sql->execute();
            return $sql->fetchAll();
        } catch(PDOException $ex) {
            echo "ERRO: ".$ex->getMessage();
        }
    }

    public function buscar($id) {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM torneios WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch();
            } else {
                return array();
            }
        } catch(PDOException $ex) {
            echo 'ERRO: '.$ex->getMessage();
        }
    }

    public function editar($id, $nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem = null) {
        try {
            // Verificar se o id_jogos é válido
            $sql = $this->con->conectar()->prepare("SELECT id FROM jogos WHERE id = :id_jogos");
            $sql->bindValue(":id_jogos", $id_jogos);
            $sql->execute();
    
            if ($sql->rowCount() == 0) {
                echo "Erro: O jogo com o ID $id_jogos não foi encontrado na tabela 'jogos'.";
                return false;
            }
    
            // Atualizar o torneio no banco de dados
            $sql = $this->con->conectar()->prepare("UPDATE torneios SET nome = :nome, id_jogos = :id_jogos, descricao = :descricao, data_inicio = :data_inicio, data_fim = :data_fim, imagem = :imagem WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":id_jogos", $id_jogos);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":data_inicio", $data_inicio);
            $sql->bindValue(":data_fim", $data_fim);
            $sql->bindValue(":imagem", $imagem ? $imagem['name'] : null); // Verifique se a imagem existe
            $sql->bindValue(":id", $id);
    
            if ($sql->execute()) {
                // Processando a imagem
                if ($imagem && isset($imagem['tmp_name']) && $imagem['tmp_name']) {
                    $tipo = $imagem['type'];
                    if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                        $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
                        move_uploaded_file($imagem['tmp_name'], 'img/torneios/' . $tmpname);
                        // Aqui você pode adicionar a lógica para redimensionar a imagem ou algo que seja necessário.
    
                        // Atualizar o banco de dados com a nova imagem
                        $sql = $this->con->conectar()->prepare("UPDATE torneios SET imagem = :imagem WHERE id = :id");
                        $sql->bindValue(":imagem", $tmpname);
                        $sql->bindValue(":id", $id);
                        $sql->execute();
                    }
                }
    
                return true;
            } else {
                echo "Erro na execução da query de atualização!";
                return false;
            }
    
        } catch (PDOException $ex) {
            echo 'Erro ao atualizar: ' . $ex->getMessage();
            return false;
        }
    }
    

    public function deletar($id) {
        $sql = $this->con->conectar()->prepare("DELETE FROM torneios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}
?>

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
        // Prepara a consulta SQL para verificar se já existe um jogo com esse id
        $sql = $this->con->conectar()->prepare("SELECT id FROM jogos WHERE id = :id");
        $sql->bindParam(':id', $id_jogo, PDO::PARAM_INT); // Faz o bind do parâmetro id
        $sql->execute(); // Executa a consulta
        return $sql->rowCount() > 0; // Se encontrar, retorna TRUE
    }

    public function adicionar($nome, $descricao, $data_lancamento, $imagem) {
        try {
            $this->nome = $nome; 
            $this->descricao = $descricao; 
            $this->data_lancamento = $data_lancamento; 

            // Verifica se uma imagem foi enviada
            if ($imagem && isset($imagem['tmp_name']) && $imagem['tmp_name'] !== '') {
                // Cria um nome único para a imagem usando md5 e o timestamp
                $nomeImagem = md5(time() . rand(0, 9999)) . '.jpg'; 
                move_uploaded_file($imagem['tmp_name'], 'uploads/' . $nomeImagem); // Move a imagem pra pasta 'uploads'
                $this->imagem = $nomeImagem; // Atribui o nome da imagem ao objeto
            } else {
                $this->imagem = NULL; // Se não tiver imagem, coloca NULL
            }

            // Prepara a consulta SQL para inserir o novo jogo
            $sql = $this->con->conectar()->prepare("INSERT INTO jogos (nome, descricao, data_lancamento, imagem) VALUES (:nome, :descricao, :data_lancamento, :imagem)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR); // Faz o bind dos parâmetros
            $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            $sql->bindParam(":data_lancamento", $this->data_lancamento, PDO::PARAM_STR);
            $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $sql->execute(); // Executa a consulta
            return true; // Se deu certo, retorna true
        } catch (PDOException $ex) {
            echo "ERRO: " . $ex->getMessage(); // Se der erro, mostra o erro
            return false; // Retorna false
        }
    }

    public function listar() {
        try {
            // Prepara a consulta SQL para pegar todos os jogos
            $sql = $this->con->conectar()->prepare("SELECT * FROM jogos");
            $sql->execute(); // Executa a consulta
            return $sql->fetchAll(); // Retorna todos os jogos
        } catch (PDOException $ex) {
            echo "ERRO: " . $ex->getMessage(); // Se der erro, exibe a mensagem
            return []; // Retorna um array vazio
        }
    }

    public function buscar($id) {
        try {
            // Prepara a consulta SQL para pegar o jogo pelo ID
            $sql = $this->con->conectar()->prepare("SELECT * FROM jogos WHERE id = :id");
            $sql->bindValue(':id', $id); // Faz o bind do parâmetro ID
            $sql->execute(); // Executa a consulta
            if ($sql->rowCount() > 0) {
                return $sql->fetch(); // Se achar, retorna os dados do jogo
            } else {
                return []; // Se não achar, retorna um array vazio
            }
        } catch (PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage(); // Se der erro, exibe a mensagem
            return []; // Retorna um array vazio
        }
    }

    public function editar($nome, $descricao, $data_lancamento, $imagem, $id) {
        try {
            // Atualiza as informações do jogo no banco
            $sql = $this->con->conectar()->prepare("UPDATE jogos SET nome = :nome, descricao = :descricao, data_lancamento = :data_lancamento WHERE id = :id");
            $sql->bindValue(":nome", $nome, PDO::PARAM_STR);
            $sql->bindValue(":descricao", $descricao, PDO::PARAM_STR);
            $sql->bindValue(":data_lancamento", $data_lancamento, PDO::PARAM_STR);
            $sql->bindValue(":id", $id, PDO::PARAM_INT);
            $sql->execute(); // Executa a consulta

            // Se o usuário enviou uma nova imagem
            if ($imagem && isset($imagem['tmp_name']) && !empty($imagem['tmp_name'])) {
                // Deleta a imagem antiga (caso exista)
                $jogoAtual = $this->buscar($id); // Busca os dados do jogo atual
                if (!empty($jogoAtual['imagem'])) {
                    unlink('uploads/' . $jogoAtual['imagem']); // Deleta a imagem antiga
                }

                // Cria um nome único para a nova imagem
                $nomeImagem = md5(time() . rand(0, 9999)) . '.jpg';
                move_uploaded_file($imagem['tmp_name'], 'uploads/' . $nomeImagem); // Move a nova imagem pra pasta 'uploads'

                // Atualiza a imagem no banco
                $sql = $this->con->conectar()->prepare("UPDATE jogos SET imagem = :imagem WHERE id = :id");
                $sql->bindValue(":imagem", $nomeImagem, PDO::PARAM_STR);
                $sql->bindValue(":id", $id, PDO::PARAM_INT);
                $sql->execute();
            }

            return true; // Se tudo correr bem, retorna true
        } catch (PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage(); // Se der erro, exibe o erro
            return false; // Retorna false
        }
    }

    public function deletar($id) {
        try {
            // Prepara a consulta SQL para deletar o jogo
            $sql = $this->con->conectar()->prepare("DELETE FROM jogos WHERE id = :id");
            $sql->bindValue(":id", $id); // Faz o bind do parâmetro ID
            $sql->execute(); // Executa a consulta
            return true; // Se deu certo, retorna true
        } catch (PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage(); // Se der erro, mostra a mensagem
            return false; // Retorna false
        }
    }
}
?>

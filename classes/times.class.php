<?php
require 'conexao.class.php';

class Times {
    private $id;
    private $nome;
    private $pais;
    private $descricao;
    private $imagem;

    private $con;

    // Construtor da classe, inicializa a conexão com o banco de dados
    public function __construct() {
        $this->con = new Conexao();  // Cria a instância da classe de conexão
    }

    // Função privada para verificar se o time já existe no banco pelo nome
    private function existeTime($nome) {
        $sql = $this->con->conectar()->prepare("SELECT id FROM times WHERE nome = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();  // Se encontrar o time, retorna os dados
        } else {
            $array = array();  // Caso contrário, retorna um array vazio
        }
        return $array;
    }

    // Função pública para adicionar um novo time no banco
    public function adicionar($nome, $pais, $descricao, $imagem) {
        // Verifica se o time já existe
        $existeTime = $this->existeTime($nome);
        if (count($existeTime) == 0) {  // Se não existir, prossegue com a adição
            try {
                // Atribui os valores recebidos nos parâmetros aos atributos da classe
                $this->nome = $nome;
                $this->pais = $pais;
                $this->descricao = $descricao;
                $this->imagem = $imagem;  // Armazena o nome do arquivo de imagem

                // Prepara e executa a query para inserir o novo time no banco de dados
                $sql = $this->con->conectar()->prepare("INSERT INTO times(nome, pais, descricao, imagem) VALUES (:nome, :pais, :descricao, :imagem)");
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
                $sql->bindParam(":pais", $this->pais, PDO::PARAM_STR);
                $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
                $sql->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);  // Salva o nome da imagem
                $sql->execute();

                return TRUE;  // Retorna verdadeiro se a inserção foi bem-sucedida
            } catch(PDOException $ex) {
                return "ERRO: " . $ex->getMessage();  // Retorna a mensagem de erro caso ocorra algum problema
            }
        }
        return FALSE;  // Retorna falso se o time já existir
    }

    // Função para listar todos os times do banco
    public function listar() {
        try {
            // Prepara e executa a query para buscar todos os times no banco de dados
            $sql = $this->con->conectar()->prepare("SELECT * FROM times");
            $sql->execute();
            return $sql->fetchAll();  // Retorna todos os registros encontrados
        } catch(PDOException $ex) {
            echo "ERRO: " . $ex->getMessage();  // Exibe erro caso ocorra algum problema
        }
    }

    public function buscar($id) {
        try {
            // Prepara a query para buscar um time específico pelo seu ID
            $sql = $this->con->conectar()->prepare("SELECT * FROM times WHERE id = :id");
            $sql->bindValue(':id', $id);  // Vincula o parâmetro ID
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return $sql->fetch();  // Retorna os dados do time
            } else {
                return array();  // Retorna um array vazio se não encontrar o time
            }
        } catch(PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();  // Exibe erro caso ocorra algum problema
        }
    }

    public function editar($nome, $pais, $descricao, $imagem, $id) {
        // Verifica se o nome do time já está sendo utilizado por outro time
        $timeExistente = $this->existeTime($nome);
        if (count($timeExistente) > 0 && $timeExistente['id'] != $id) {
            return FALSE;  // Retorna falso se o nome já estiver em uso por outro time
        } else {
            try {
                // Atualiza os dados do time no banco
                $sql = $this->con->conectar()->prepare("UPDATE times SET nome = :nome, pais = :pais, descricao = :descricao WHERE id = :id");
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":pais", $pais);
                $sql->bindValue(":descricao", $descricao);
                $sql->bindValue(":id", $id);
                $sql->execute();

                // Se houver uma imagem, somente atualiza o campo imagem
        // Executa a consulta de atualização
        if ($sql->execute()) {
            // Se houver uma imagem nova, processa e move a imagem para o diretório
            if ($imagem && isset($imagem['tmp_name']) && $imagem['tmp_name']) {
                $tipo = $imagem['type'];
                if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                    // Gera um nome único para a imagem e move para o diretório adequado
                    $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
                    move_uploaded_file($imagem['tmp_name'], 'img/times/' . $tmpname);

                    // Atualiza a imagem no banco de dados
                    $sql = $this->con->conectar()->prepare("UPDATE times SET imagem = :imagem WHERE id = :id");
                    $sql->bindValue(":imagem", $tmpname);  // Atualiza com o novo nome da imagem
                    $sql->bindValue(":id", $id);
                    $sql->execute();
                }
            }

            return true;  // Retorna true se a atualização for bem-sucedida
        } else {
            // Exibe erro se a consulta não for executada corretamente
            echo "Erro na execução da query de atualização!";
            return false; // Retorna false se ocorrer erro
        }

    } catch (PDOException $ex) {
        // Exibe erro caso ocorra algum problema durante a atualização
        echo 'Erro ao atualizar: ' . $ex->getMessage();
        return false;  // Retorna false em caso de erro
    }
}
    }

    public function deletar($id) {
        // Prepara e executa a query para deletar o time pelo ID
        $sql = $this->con->conectar()->prepare("DELETE FROM times WHERE id = :id");
        $sql->bindValue(":id", $id);  // Vincula o ID
        $sql->execute();
    }
}
?>

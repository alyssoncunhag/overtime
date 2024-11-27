<?php
require 'conexao.class.php';
class Categorias {
    private $id; 
    private $nome; 
    private $descricao; 
    private $con; 
    public function __construct() {
        $this->con = new Conexao(); 
    }

    private function existeCategoria($nome) {
        // Remove os espaços extras e coloca tudo em minúsculo pra garantir que a comparação seja exata
        $nome = trim(strtolower($nome));
        
        // Prepara a consulta SQL para verificar se já existe uma categoria com o mesmo nome (ignorando maiúsculas/minúsculas)
        $sql = $this->con->conectar()->prepare("SELECT id FROM categorias WHERE LOWER(nome) = :nome");
        $sql->bindParam(':nome', $nome, PDO::PARAM_STR); // Faz o bind do parâmetro
        $sql->execute(); // Executa a consulta
        
        return $sql->rowCount() > 0; // Se o número de resultados for maior que 0, retorna TRUE (categoria já existe)
    }

    public function adicionar($nome, $descricao) {
        // Primeiro, verifica se a categoria já existe
        if ($this->existeCategoria($nome)) {
            return "Categoria já cadastrada!"; // Se já existir, retorna mensagem de erro
        } else {
            try {
                $this->nome = $nome; // Atribui o nome da categoria
                $this->descricao = $descricao; // Atribui a descrição

                // Prepara a consulta SQL para inserir a nova categoria
                $sql = $this->con->conectar()->prepare("INSERT INTO categorias(nome, descricao) VALUES (:nome, :descricao)");
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR); // Faz o bind dos parâmetros
                $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
                $sql->execute(); // Executa a consulta

                return TRUE; // Se deu tudo certo, retorna TRUE
            } catch(PDOException $ex) {
                return "ERRO: " . $ex->getMessage(); // Se der erro, retorna a mensagem de erro
            }
        }
    }

    public function listar() {
        try {
            // Prepara a consulta SQL para pegar todas as categorias
            $sql = $this->con->conectar()->prepare('SELECT * FROM categorias');
            $sql->execute(); // Executa a consulta
            return $sql->fetchAll(); // Retorna todas as categorias encontradas
        } catch(PDOException $ex) {
            echo "ERRO: " . $ex->getMessage(); // Se der erro, imprime o erro
        }
    }

    public function buscar($id) {
        try {
            // Prepara a consulta SQL para pegar uma categoria pelo ID
            $sql = $this->con->conectar()->prepare("SELECT * FROM categorias WHERE id = :id");
            $sql->bindValue(':id', $id); // Faz o bind do parâmetro id
            $sql->execute(); // Executa a consulta
            if ($sql->rowCount() > 0) {
                return $sql->fetch(); // Se achar, retorna os dados da categoria
            } else {
                return array(); // Se não achar, retorna um array vazio
            }
        } catch(PDOException $ex) {
            echo 'ERRO: '.$ex->getMessage(); // Se der erro, imprime o erro
        }
    }

    public function editar($id, $nome, $descricao) {
        try {
            // Prepara a consulta SQL para atualizar os dados da categoria no banco
            $sql = $this->con->conectar()->prepare("UPDATE categorias SET nome = :nome, descricao = :descricao WHERE id = :id");
            $sql->bindValue(":nome", $nome); // Faz o bind dos parâmetros
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":id", $id);
            $sql->execute(); // Executa a consulta

            return TRUE; // Se deu certo, retorna TRUE
        } catch(PDOException $ex) {
            return 'ERRO: ' . $ex->getMessage(); // Se der erro, retorna a mensagem de erro
        }
    }

    // Função que retorna os dados de uma categoria pelo ID
    public function getCategoria($id) {
        $array = array(); // Cria um array vazio
        // Prepara a consulta SQL para pegar a categoria pelo ID
        $sql = $this->con->conectar()->prepare("SELECT * FROM categorias WHERE id = :id");
        $sql->bindValue(":id", $id); // Faz o bind do parâmetro id
        $sql->execute(); // Executa a consulta
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(); // Se achar, preenche o array com os dados
        }
        return $array; // Retorna o array (com ou sem dados)
    }

    // Função que deleta uma categoria pelo ID
    public function deletar($id) {
        try {
            // Prepara a consulta SQL para deletar a categoria pelo ID
            $sql = $this->con->conectar()->prepare("DELETE FROM categorias WHERE id = :id");
            $sql->bindValue(":id", $id); // Faz o bind do parâmetro id
            $sql->execute(); // Executa a consulta
        } catch(PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage(); // Se der erro, imprime o erro
        }
    }
}
?>

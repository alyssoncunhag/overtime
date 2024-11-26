<?php
require_once 'conexao.class.php';  // Inclui a classe de conexão com o banco de dados

class Usuarios {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $permissoes;
    private $con;

    // Construtor da classe: Cria a conexão com o banco e inicializa as permissões como um array vazio
    public function __construct() {
        $this->con = new Conexao();
        $this->permissoes = []; // Garantir que permissoes seja sempre um array
    }

    // Método para verificar se um email já existe no banco de dados
    public function existeEmail($email){
        $sql = $this->con->conectar()->prepare("SELECT id FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();  // Retorna os dados do usuário caso o email exista
        }
        return false;  // Retorna false caso o email não exista
    }

    // Método para verificar se o usuário tem uma permissão específica
    public function temPermissoes($permissao) {
        return in_array($permissao, $this->permissoes); // Verifica se a permissão existe no array de permissões
    }

    // Método para adicionar um novo usuário ao banco de dados
    public function adicionar($nome, $email, $senha, $permissoes){
        // Verifica se permissões é uma string e, se for, converte para array
        if (is_string($permissoes)) {
            $permissoes = explode(',', $permissoes);  // Converte string de permissões para array
        }

        // Verifica se o e-mail já está cadastrado
        $emailExistente = $this->existeEmail($email);
        if($emailExistente === false){  // Se o e-mail não existir
            try{
                // Criptografa a senha antes de salvar no banco
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

                // Atribui os valores às propriedades da classe
                $this->nome = $nome;
                $this->email = $email;
                $this->senha = $senhaCriptografada; // Armazena a senha criptografada
                $this->permissoes = $permissoes;  // Armazena as permissões

                // Prepara a consulta SQL para inserir os dados do usuário
                $sql = $this->con->conectar()->prepare("INSERT INTO usuarios (nome, email, senha, permissoes) VALUES (:nome, :email, :senha, :permissoes)");
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":email", $email);
                $sql->bindValue(":senha", $senhaCriptografada); // Insere a senha criptografada
                $sql->bindValue(":permissoes", implode(',', $permissoes));  // Converte o array de permissões em uma string separada por vírgulas
                $sql->execute();  // Executa a consulta

                return TRUE;  // Retorna true se o usuário for adicionado com sucesso
            }catch(PDOException $ex){
                return 'ERRO: '.$ex->getMessage();  // Retorna mensagem de erro em caso de falha
            }
        }else{
            return FALSE;  // Retorna false se o e-mail já existir
        }
    }

    // Método para realizar o login do usuário
    public function fazerLogin($email, $senha) {
        $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $usuario = $sql->fetch();
    
            // Verifica a senha utilizando a função password_verify
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['logado'] = $usuario['id'];  // Define o ID do usuário na sessão
                $this->setUsuario($usuario['id']); // Define os dados do usuário na classe
                return TRUE;
            }
        }
        return FALSE;  // Retorna false se a senha estiver incorreta ou o e-mail não existir
    }

    // Método para salvar o token de recuperação de senha no banco de dados
    public function salvarTokenSenha($email, $token) {
        $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));  // O token expira em 1 hora

        $sql = $this->con->conectar()->prepare("UPDATE usuarios SET token_senha = :token, token_expiracao = :expiracao WHERE email = :email");
        $sql->bindValue(':token', $token);
        $sql->bindValue(':expiracao', $expiracao);
        $sql->bindValue(':email', $email);
        
        return $sql->execute();  // Executa a consulta e retorna o resultado
    }

    // Método para verificar o token de recuperação de senha
    public function verificarTokenSenha($token) {
        $sql = $this->con->conectar()->prepare("SELECT id, token_expiracao FROM usuarios WHERE token_senha = :token");
        $sql->bindValue(':token', $token);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $usuario = $sql->fetch();
            $expiracao = strtotime($usuario['token_expiracao']);
            $agora = time();
    
            if ($agora <= $expiracao) {
                return $usuario['id'];  // Retorna o ID do usuário se o token for válido
            }
        }
        return false;  // Retorna false se o token for inválido ou expirado
    }
    
    // Método para limpar o token de recuperação de senha após a redefinição
    public function limparTokenSenha($id) {
        $sql = $this->con->conectar()->prepare("UPDATE usuarios SET token_senha = NULL, token_expiracao = NULL WHERE id = :id");
        $sql->bindValue(':id', $id);
        return $sql->execute();  // Executa a consulta para limpar o token
    }

    // Método para redefinir a senha do usuário
    public function redefinirSenha($id, $novaSenha) {
        $novaSenhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);  // Criptografa a nova senha

        // Atualiza a senha do usuário no banco de dados e limpa os tokens
        $sql = $this->con->conectar()->prepare("UPDATE usuarios SET senha = :senha, token_senha = NULL, token_expiracao = NULL WHERE id = :id");
        $sql->bindValue(':senha', $novaSenhaCriptografada);
        $sql->bindValue(':id', $id);
        
        return $sql->execute();  // Executa a consulta para redefinir a senha
    }

    // Método para listar todos os usuários
    public function listar() {
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios");
            $sql->execute();
            return $sql->fetchAll();  // Retorna todos os registros de usuários
        }catch(PDOException $ex){
            echo "ERRO: ".$ex->getMessage();  // Exibe mensagem de erro em caso de falha
        }
    }

    // Método para editar os dados de um usuário
    public function editar($nome, $email, $senha, $permissoes, $id){
        // Verifica se o e-mail já existe, mas não no mesmo usuário
        $emailExistente = $this->existeEmail($email);
        if($emailExistente !== false && $emailExistente['id'] != $id){
            return FALSE;  // Retorna false se o e-mail já existir para outro usuário
        }else{
            try{
                // Criptografa a senha antes de atualizar
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    
                // Converte permissões para array se for uma string
                if (is_string($permissoes)) {
                    $permissoes = explode(',', $permissoes);  // Converte a string em array
                }
    
                // Atualiza os dados do usuário no banco de dados
                $sql = $this->con->conectar()->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, permissoes = :permissoes WHERE id = :id");
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':email', $email);
                $sql->bindValue(':senha', $senhaCriptografada);
                $sql->bindValue(':permissoes', implode(',', $permissoes));  // Converte o array de permissões de volta para string
                $sql->bindValue(':id', $id);
                $sql->execute();  // Executa a consulta para atualizar o usuário
    
                return TRUE;  // Retorna true em caso de sucesso
            }catch(PDOException $ex){
                echo 'ERRO '.$ex->getMessage();  // Exibe mensagem de erro em caso de falha
            }
        }
    }

    // Método para excluir um usuário
    public function deletar($id){
        $sql = $this->con->conectar()->prepare("DELETE FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();  // Executa a consulta para excluir o usuário
    }

    // Método para obter os dados de um usuário específico
    public function getUsuario($id){
        $array = array();
        $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetch();  // Retorna os dados do usuário se encontrado
        }
        return $array;
    }

    // Método para setar os dados do usuário na classe
    public function setUsuario($id) {
        $usuario = $this->getUsuario($id);  // Pega os dados do usuário no banco
        if ($usuario) {
            $this->id = $usuario['id'];
            $this->nome = $usuario['nome'];
            $this->email = $usuario['email'];
            $this->permissoes = explode(',', $usuario['permissoes']);  // Converte a string de permissões de volta para um array
        }
    }
}
?>

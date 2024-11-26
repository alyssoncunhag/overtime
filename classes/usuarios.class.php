<?php
require_once 'conexao.class.php';

class Usuarios {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $permissoes;
    private $con;

    public function __construct() {
        $this->con = new Conexao();
        $this->permissoes = []; // Garantir que permissoes seja sempre um array
    }

    // Verifica se o email já existe no banco de dados
    public function existeEmail($email){
        $sql = $this->con->conectar()->prepare("SELECT id FROM usuarios WHERE email = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }
        return false;
    }

    public function temPermissoes($permissao) {
        return in_array($permissao, $this->permissoes); // Verifica se a permissão existe no array de permissões
    }

    // Adiciona um novo usuário no banco
    public function adicionar($nome, $email, $senha, $permissoes){
        // Verificar se permissões é uma string e se for, converte para array
        if (is_string($permissoes)) {
            $permissoes = explode(',', $permissoes); // Convertendo string de permissões para array
        }

        // Verifica se o e-mail já existe
        $emailExistente = $this->existeEmail($email);
        if($emailExistente === false){  // Se o email não existir
            try{
                // Criptografando a senha antes de salvar no banco de dados
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

                $this->nome = $nome;
                $this->email = $email;
                $this->senha = $senhaCriptografada; // Armazenando a senha criptografada
                $this->permissoes = $permissoes;  // Garantir que seja um array

                // Agora convertendo o array de permissões para string antes de salvar no banco
                $sql = $this->con->conectar()->prepare("INSERT INTO usuarios (nome, email, senha, permissoes) VALUES (:nome, :email, :senha, :permissoes)");
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":email", $email);
                $sql->bindValue(":senha", $senhaCriptografada); // Salvando a senha criptografada
                $sql->bindValue(":permissoes", implode(',', $permissoes));  // Convertendo array em string separada por vírgulas
                $sql->execute();

                return TRUE;
            }catch(PDOException $ex){
                return 'ERRO: '.$ex->getMessage();
            }
        }else{
            return FALSE;  // Email já existe
        }
    }

    // Método de login
    public function fazerLogin($email, $senha) {
        $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $usuario = $sql->fetch();
    
            // Verificar a senha utilizando password_verify
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['logado'] = $usuario['id'];
                $this->setUsuario($usuario['id']); // Agora funciona corretamente
                return TRUE;
            }
        }
        return FALSE;
    }

    // Método para salvar o token de recuperação de senha
    public function salvarTokenSenha($email, $token) {
        $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour')); // O token expira em 1 hora

        $sql = $this->con->conectar()->prepare("UPDATE usuarios SET token_senha = :token, token_expiracao = :expiracao WHERE email = :email");
        $sql->bindValue(':token', $token);
        $sql->bindValue(':expiracao', $expiracao);
        $sql->bindValue(':email', $email);
        
        return $sql->execute();
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
                return $usuario['id']; // Retorna o ID do usuário se o token for válido
            }
        }
        return false; // Token inválido ou expirado
    }
    
    public function limparTokenSenha($id) {
        $sql = $this->con->conectar()->prepare("UPDATE usuarios SET token_senha = NULL, token_expiracao = NULL WHERE id = :id");
        $sql->bindValue(':id', $id);
        return $sql->execute();
    }
    

    // Método para redefinir a senha
    public function redefinirSenha($id, $novaSenha) {
        $novaSenhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = $this->con->conectar()->prepare("UPDATE usuarios SET senha = :senha, token_senha = NULL, token_expiracao = NULL WHERE id = :id");
        $sql->bindValue(':senha', $novaSenhaCriptografada);
        $sql->bindValue(':id', $id);
        
        return $sql->execute();
    }

    // Métodos para listagem, edição e exclusão de usuários
    public function listar() {
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios");
            $sql->execute();
            return $sql->fetchAll();
        }catch(PDOException $ex){
            echo "ERRO: ".$ex->getMessage();
        }
    }

    public function editar($nome, $email, $senha, $permissoes, $id){
        // Verifica se o e-mail já existe, mas não no mesmo usuário
        $emailExistente = $this->existeEmail($email);
        if($emailExistente !== false && $emailExistente['id'] != $id){
            return FALSE;
        }else{
            try{
                // Criptografando a senha antes de atualizar no banco
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    
                // Garantir que $permissoes seja um array antes de usar implode
                if (is_string($permissoes)) {
                    $permissoes = explode(',', $permissoes);  // Converte string em array se necessário
                }
    
                $sql = $this->con->conectar()->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, permissoes = :permissoes WHERE id = :id");
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':email', $email);
                $sql->bindValue(':senha', $senhaCriptografada);
                $sql->bindValue(':permissoes', implode(',', $permissoes));  // Agora $permissoes é sempre um array
                $sql->bindValue(':id', $id);
                $sql->execute();
    
                return TRUE;
            }catch(PDOException $ex){
                echo 'ERRO '.$ex->getMessage();
            }
        }
    }
    

    public function deletar($id){
        $sql = $this->con->conectar()->prepare("DELETE FROM usuarios WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function getUsuario($id){
        $array = array();
        $sql = $this->con->conectar()->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetch();
        }
        return $array;
    }

    // Método para setar os dados do usuário
    public function setUsuario($id) {
        $usuario = $this->getUsuario($id); // Pega os dados do usuário no banco
        if ($usuario) {
            $this->id = $usuario['id'];
            $this->nome = $usuario['nome'];
            $this->email = $usuario['email'];
            $this->permissoes = explode(',', $usuario['permissoes']); // Converte a string de permissões de volta para um array
        }
    }
}
?>

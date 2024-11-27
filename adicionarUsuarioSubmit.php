<?php
include 'classes/usuarios.class.php';

$usuario = new Usuarios();

// Verifica se o campo 'email' foi preenchido no formulário
if (!empty($_POST['email'])) {
    // Recupera os dados enviados no formulário
    $nome = $_POST['nome'];        
    $email = $_POST['email'];        
    $senha = $_POST['senha'];        
    $permissoes = $_POST['permissoes']; 

    // Verifica se o e-mail já existe no banco de dados chamando o método 'existeEmail'
    if ($usuario->existeEmail($email)) {
        // Se o e-mail já estiver cadastrado, exibe uma mensagem de erro usando JavaScript
        echo '<script type="text/javascript">
                alert("Este e-mail já está cadastrado. Por favor, use outro e-mail.");
                window.location.href = "adicionarUsuario.php"; // Volta para o formulário de adicionar usuário
              </script>';
    } else {
        // Caso o e-mail não exista, tenta adicionar o usuário ao banco de dados
        if ($usuario->adicionar($nome, $email, $senha, $permissoes)) {
            // Se o usuário for adicionado com sucesso, redireciona para a página inicial
            header('Location: index.php');
            exit; 
        } else {
            echo '<script type="text/javascript">
                    alert("Erro ao adicionar usuário. Tente novamente.");
                    window.location.href = "adicionarUsuario.php";  // Volta para o formulário de adicionar usuário
                  </script>';
        }
    }
}
?>

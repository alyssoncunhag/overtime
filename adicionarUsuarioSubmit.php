<?php
// Inclui o arquivo da classe 'Usuarios', onde estão os métodos relacionados ao gerenciamento de usuários
include 'classes/usuarios.class.php';

// Instancia um objeto da classe 'Usuarios'
$usuario = new Usuarios();

// Verifica se o campo 'email' foi preenchido no formulário
if (!empty($_POST['email'])) {
    // Recupera os dados enviados no formulário
    $nome = $_POST['nome'];          // Nome do usuário
    $email = $_POST['email'];        // Email do usuário
    $senha = $_POST['senha'];        // Senha do usuário
    $permissoes = $_POST['permissoes']; // Permissões do usuário

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
            exit;  // Certifica-se de que o código não continuará executando após o redirecionamento
        } else {
            // Caso ocorra algum erro ao tentar adicionar o usuário, exibe uma mensagem de erro usando JavaScript
            echo '<script type="text/javascript">
                    alert("Erro ao adicionar usuário. Tente novamente.");
                    window.location.href = "adicionarUsuario.php";  // Volta para o formulário de adicionar usuário
                  </script>';
        }
    }
}
?>

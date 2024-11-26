<?php
session_start(); // Inicia a sessão, permitindo que as variáveis de sessão sejam acessadas
include 'classes/usuarios.class.php'; // Inclui o arquivo da classe 'Usuarios' que manipula as operações de usuários no banco de dados

// Verifica se o usuário está logado. Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['logado'])) {
    header("Location: login.php"); // Redireciona para a página de login caso o usuário não esteja logado
    exit; // Interrompe a execução do script
}

$usuario = new Usuarios(); // Cria uma instância da classe 'Usuarios' para manipular os usuários
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva para diferentes dispositivos -->
    <title>Gestão de Usuários - OVERTIME</title> <!-- Título da página exibido na aba do navegador -->
    <link rel="stylesheet" href="css/gestaoUsuario.css"> <!-- Link para o arquivo CSS de estilo -->
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <h1>Gestão de Usuários</h1> <!-- Título principal da página -->
    </header>
    
    <!-- Botão para adicionar um novo usuário -->
    <div class="button-container">
        <a href="adicionarUsuario.php" class="button">ADICIONAR</a> <!-- Link que leva à página para adicionar um novo usuário -->
    </div>

    <hr> <!-- Linha horizontal para separar o conteúdo -->

    <!-- Tabela de usuários -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Cabeçalho da coluna ID -->
                    <th>Nome</th> <!-- Cabeçalho da coluna Nome -->
                    <th>Email</th> <!-- Cabeçalho da coluna Email -->
                    <th>Senha</th> <!-- Cabeçalho da coluna Senha -->
                    <th>Permissões</th> <!-- Cabeçalho da coluna Permissões -->
                    <th>Ações</th> <!-- Cabeçalho da coluna Ações -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Chama o método 'listar' da classe 'Usuarios' para obter todos os usuários cadastrados no banco de dados
                $lista = $usuario->listar();
                // Itera sobre cada usuário da lista e exibe os dados na tabela
                foreach($lista as $item):
                ?>
                    <tr>
                        <!-- Exibe os dados de cada usuário nas células da tabela -->
                        <td><?php echo $item['id']; ?></td> <!-- Exibe o ID do usuário -->
                        <td><?php echo $item['nome']; ?></td> <!-- Exibe o nome do usuário -->
                        <td><?php echo $item['email']; ?></td> <!-- Exibe o email do usuário -->
                        <td><?php echo $item['senha']; ?></td> <!-- Exibe a senha do usuário (não recomendado exibir senhas em texto claro) -->
                        <td><?php echo $item['permissoes']; ?></td> <!-- Exibe as permissões do usuário -->
                        <td>
                            <!-- Link para editar o usuário, passando o ID como parâmetro na URL -->
                            <a href="editarUsuario.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <!-- Link para excluir o usuário, passando o ID como parâmetro na URL -->
                            <a href="excluirUsuario.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Finaliza o loop que exibe todos os usuários -->
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
session_start(); // Inicia a sessão, permitindo o uso de variáveis de sessão
include 'classes/categorias.class.php'; // Inclui a classe 'Categorias' que será usada para manipular as categorias no banco de dados

// Verifica se o usuário não está logado. Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['logado'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}

$categoria = new Categorias(); // Cria uma instância da classe 'Categorias' para manipulação das categorias
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Tornando o site responsivo para diferentes tamanhos de tela -->
    <title>Gestão de Categorias - OVERTIME</title> <!-- Título da página exibido na aba do navegador -->
    <link rel="stylesheet" href="css/gestaoCategoria.css"> <!-- Link para o arquivo CSS que estiliza a página -->
</head>
<body>
    <header>
        <h1>Gestão de Categorias</h1> <!-- Título principal da página -->
    </header>

    <div class="button-container">
        <a href="index.php" class="button">VOLTAR AO INICIO</a> <!-- Link que leva à página inicial -->
    </div>
    
    <div class="button-container">
        <a href="adicionarCategoria.php" class="button">ADICIONAR</a> <!-- Link para a página de adição de categorias -->
    </div>

    <hr> <!-- Linha horizontal para separar a seção de adição da tabela -->

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Cabeçalho da coluna ID -->
                    <th>Nome</th> <!-- Cabeçalho da coluna Nome -->
                    <th>Descrição</th> <!-- Cabeçalho da coluna Descrição -->
                    <th>Ações</th> <!-- Cabeçalho da coluna Ações (Editar/Excluir) -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Chama o método 'listar' da classe Categorias para obter todas as categorias no banco de dados
                $lista = $categoria->listar();
                // Itera sobre cada categoria da lista e exibe os dados na tabela
                foreach($lista as $item):
                ?>
                    <tr>
                        <!-- Exibe os dados de cada categoria nas células da tabela -->
                        <td><?php echo $item['id']; ?></td> <!-- Exibe o ID da categoria -->
                        <td><?php echo $item['nome']; ?></td> <!-- Exibe o Nome da categoria -->
                        <td><?php echo $item['descricao']; ?></td> <!-- Exibe a Descrição da categoria -->
                        <td>
                            <!-- Link para editar a categoria, passando o ID como parâmetro na URL -->
                            <a href="editarCategoria.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <!-- Link para excluir a categoria, passando o ID como parâmetro na URL -->
                            <a href="excluirCategoria.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Finaliza o loop que exibe todas as categorias -->
            </tbody>
        </table>
    </div>
</body>
</html>

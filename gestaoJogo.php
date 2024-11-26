<?php
session_start(); // Inicia a sessão, permitindo o uso de variáveis de sessão
include 'classes/jogos.class.php'; // Inclui a classe 'Jogos' que será usada para manipular os jogos no banco de dados

// Verifica se o usuário não está logado. Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['logado'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}

$jogo = new Jogos(); // Cria uma instância da classe 'Jogos' para manipulação dos jogos
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Tornando o site responsivo para diferentes tamanhos de tela -->
    <title>Gestão de Jogos - OVERTIME</title> <!-- Título da página exibido na aba do navegador -->
    <link rel="stylesheet" href="css/gestaoJogo.css"> <!-- Link para o arquivo CSS que estiliza a página -->
</head>
<body>
    <header>
        <h1>Gestão de Jogos</h1> <!-- Título principal da página -->
    </header>
    
    <div class="button-container">
        <a href="adicionarJogo.php" class="button">ADICIONAR</a> <!-- Link para a página de adição de jogos -->
    </div>

    <hr> <!-- Linha horizontal para separar a seção de adição da tabela -->

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Cabeçalho da coluna ID -->
                    <th>Nome</th> <!-- Cabeçalho da coluna Nome -->
                    <th>Descrição</th> <!-- Cabeçalho da coluna Descrição -->
                    <th>Data de Lançamento</th> <!-- Cabeçalho da coluna Data de Lançamento -->
                    <th>Imagem</th> <!-- Cabeçalho da coluna Imagem -->
                    <th>Ações</th> <!-- Cabeçalho da coluna Ações (Editar/Excluir) -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Chama o método 'listar' da classe Jogos para obter todos os jogos no banco de dados
                $lista = $jogo->listar();
                // Itera sobre cada jogo da lista e exibe os dados na tabela
                foreach($lista as $item):
                ?>
                    <tr>
                        <!-- Exibe os dados de cada jogo nas células da tabela -->
                        <td><?php echo $item['id']; ?></td> <!-- Exibe o ID do jogo -->
                        <td><?php echo $item['nome']; ?></td> <!-- Exibe o Nome do jogo -->
                        <td><?php echo $item['descricao']; ?></td> <!-- Exibe a Descrição do jogo -->
                        <td><?php echo $item['data_lancamento']; ?></td> <!-- Exibe a Data de Lançamento do jogo -->
                        <td><img src="<?php echo $item['imagem']; ?>" alt="Imagem do jogo" class="game-image"></td> <!-- Exibe a Imagem do jogo -->
                        <td>
                            <!-- Link para editar o jogo, passando o ID como parâmetro na URL -->
                            <a href="editarJogo.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <!-- Link para excluir o jogo, passando o ID como parâmetro na URL -->
                            <a href="excluirJogo.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Finaliza o loop que exibe todos os jogos -->
            </tbody>
        </table>
    </div>
</body>
</html>

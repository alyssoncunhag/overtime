<?php
session_start(); // Inicia a sessão, permitindo o uso de variáveis de sessão
include 'classes/times.class.php'; // Inclui a classe 'Times' para manipulação dos times no banco de dados

// Verifica se o usuário está logado. Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['logado'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}

$time = new Times(); // Cria uma instância da classe 'Times' para manipulação dos times
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva em diferentes dispositivos -->
    <title>Gestão de Times - OVERTIME</title> <!-- Título da página exibido na aba do navegador -->
    <link rel="stylesheet" href="css/gestaoTime.css"> <!-- Link para o arquivo CSS que estiliza a página -->
</head>
<body>
    <header>
        <h1>Gestão de Times</h1> <!-- Título principal da página -->
    </header>
    
    <div class="button-container">
        <a href="adicionarTime.php" class="button">ADICIONAR</a> <!-- Link para adicionar um novo time -->
    </div>

    <hr> <!-- Linha horizontal para separar a seção de adição da tabela -->

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Cabeçalho da coluna ID -->
                    <th>Nome</th> <!-- Cabeçalho da coluna Nome -->
                    <th>País</th> <!-- Cabeçalho da coluna País -->
                    <th>Descrição</th> <!-- Cabeçalho da coluna Descrição -->
                    <th>Imagem</th> <!-- Cabeçalho da coluna Imagem -->
                    <th>Ações</th> <!-- Cabeçalho da coluna Ações (Editar/Excluir) -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Chama o método 'listar' da classe Times para obter todos os times do banco de dados
                $lista = $time->listar();
                // Itera sobre cada time da lista e exibe os dados na tabela
                foreach($lista as $item):
                ?>
                    <tr>
                        <!-- Exibe os dados de cada time nas células da tabela -->
                        <td><?php echo $item['id']; ?></td> <!-- Exibe o ID do time -->
                        <td><?php echo $item['nome']; ?></td> <!-- Exibe o Nome do time -->
                        <td><?php echo $item['pais']; ?></td> <!-- Exibe o País do time -->
                        <td><?php echo $item['descricao']; ?></td> <!-- Exibe a Descrição do time -->
                        <td><img src="<?php echo $item['imagem']; ?>" alt="Imagem do time" class="team-image"></td> <!-- Exibe a Imagem do time -->
                        <td>
                            <!-- Link para editar o time, passando o ID como parâmetro na URL -->
                            <a href="editarTime.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <!-- Link para excluir o time, passando o ID como parâmetro na URL -->
                            <a href="excluirTime.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Finaliza o loop que exibe todos os times -->
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
session_start(); // Inicia a sessão, permitindo o uso de variáveis de sessão
include 'classes/torneios.class.php'; // Inclui a classe 'Torneios' para manipulação dos torneios no banco de dados

// Verifica se o usuário está logado. Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['logado'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}

$torneio = new Torneios(); // Cria uma instância da classe 'Torneios' para manipulação dos torneios
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva em diferentes dispositivos -->
    <title>Gestão de Torneios - OVERTIME</title> <!-- Título da página exibido na aba do navegador -->
    <link rel="stylesheet" href="css/gestaoTorneio.css"> <!-- Link para o arquivo CSS que estiliza a página -->
</head>
<body>
    <header>
        <h1>Gestão de Torneios</h1> <!-- Título principal da página -->
    </header>
    
    <!-- Botão para adicionar torneio -->
    <div class="button-container">
        <a href="adicionarTorneio.php" class="button">ADICIONAR</a> <!-- Link para adicionar um novo torneio -->
    </div>

    <hr> <!-- Linha horizontal para separar a seção de adição da tabela -->

    <!-- Tabela de torneios -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Cabeçalho da coluna ID -->
                    <th>Nome</th> <!-- Cabeçalho da coluna Nome -->
                    <th>ID Jogo</th> <!-- Cabeçalho da coluna ID do Jogo -->
                    <th>Descrição</th> <!-- Cabeçalho da coluna Descrição -->
                    <th>Data Início</th> <!-- Cabeçalho da coluna Data de Início -->
                    <th>Data Fim</th> <!-- Cabeçalho da coluna Data de Fim -->
                    <th>Imagem</th> <!-- Cabeçalho da coluna Imagem -->
                    <th>Ações</th> <!-- Cabeçalho da coluna Ações (Editar/Excluir) -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Chama o método 'listar' da classe Torneios para obter todos os torneios cadastrados no banco de dados
                $lista = $torneio->listar();
                // Itera sobre cada torneio da lista e exibe os dados na tabela
                foreach($lista as $item):
                    $imagem_url = ''; // Valor padrão para a imagem
                    // Verifica se há uma imagem associada ao torneio
                    if (isset($item['imagem']) && !empty($item['imagem'])) {
                        $imagem_url = 'img/torneios/' . $item['imagem'];  // Caminho da imagem
                    }
                ?>
                    <tr>
                        <!-- Exibe os dados de cada torneio nas células da tabela -->
                        <td><?php echo $item['id']; ?></td> <!-- Exibe o ID do torneio -->
                        <td><?php echo $item['nome']; ?></td> <!-- Exibe o Nome do torneio -->
                        <td><?php echo $item['id_jogos']; ?></td> <!-- Exibe o ID do Jogo relacionado ao torneio -->
                        <td><?php echo $item['descricao']; ?></td> <!-- Exibe a Descrição do torneio -->
                        <td><?php echo $item['data_inicio']; ?></td> <!-- Exibe a Data de Início do torneio -->
                        <td><?php echo $item['data_fim']; ?></td> <!-- Exibe a Data de Fim do torneio -->
                        <td>
                            <?php if ($imagem_url): ?>
                                <!-- Exibe a Imagem do torneio se houver uma URL válida -->
                                <img src="<?php echo $imagem_url; ?>" alt="Imagem do Torneio" width="100">
                            <?php else: ?>
                                <!-- Caso não haja imagem associada, exibe uma mensagem de "Sem imagem" -->
                                <span>Sem imagem</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Link para editar o torneio, passando o ID como parâmetro na URL -->
                            <a href="editarTorneio.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <!-- Link para excluir o torneio, passando o ID como parâmetro na URL -->
                            <a href="excluirTorneio.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Finaliza o loop que exibe todos os torneios -->
            </tbody>
        </table>
    </div>
</body>
</html>

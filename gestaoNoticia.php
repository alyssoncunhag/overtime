<?php
session_start(); // Inicia a sessão, permitindo o uso de variáveis de sessão
include 'classes/noticias.class.php'; // Inclui a classe 'Noticias' para manipular as notícias no banco de dados

// Verifica se o usuário está logado. Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['logado'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit; // Interrompe a execução do script
}

$noticia = new Noticias(); // Cria uma instância da classe 'Noticias' para manipulação das notícias
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva em diferentes dispositivos -->
    <title>Gestão de Notícias - OVERTIME</title> <!-- Título da página exibido na aba do navegador -->
    <link rel="stylesheet" href="css/gestaoNoticia.css"> <!-- Link para o arquivo CSS que estiliza a página -->
</head>
<body>
    <header>
        <h1>Gestão de Notícias</h1> <!-- Título principal da página -->
    </header>

    <div class="button-container">
        <a href="index.php" class="button">VOLTAR AO INICIO</a> <!-- Link que leva à página inicial -->
    </div>
    
    <div class="button-container">
        <a href="adicionarNoticia.php" class="button">ADICIONAR</a> <!-- Link para adicionar uma nova notícia -->
    </div>

    <hr> <!-- Linha horizontal para separar a seção de adição da tabela -->

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th> <!-- Cabeçalho da coluna ID -->
                    <th>Título</th> <!-- Cabeçalho da coluna Título -->
                    <th>Conteúdo</th> <!-- Cabeçalho da coluna Conteúdo -->
                    <th>Imagem</th> <!-- Cabeçalho da coluna Imagem -->
                    <th>Categoria</th> <!-- Cabeçalho da coluna Categoria -->
                    <th>Autor</th> <!-- Cabeçalho da coluna Autor -->
                    <th>Data de Publicação</th> <!-- Cabeçalho da coluna Data de Publicação -->
                    <th>Ações</th> <!-- Cabeçalho da coluna Ações (Editar/Excluir) -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Chama o método 'listar' da classe Noticias para obter todas as notícias do banco de dados
                $lista = $noticia->listar();
                // Itera sobre cada notícia da lista e exibe os dados na tabela
                foreach($lista as $item):
                ?>
                    <tr>
                        <!-- Exibe os dados de cada notícia nas células da tabela -->
                        <td><?php echo $item['id']; ?></td> <!-- Exibe o ID da notícia -->
                        <td><?php echo $item['titulo']; ?></td> <!-- Exibe o Título da notícia -->
                        <td><?php echo $item['conteudo']; ?></td> <!-- Exibe o Conteúdo da notícia -->
                        <td><img src="<?php echo $item['imagem']; ?>" alt="Imagem da notícia" class="news-image"></td> <!-- Exibe a Imagem da notícia -->
                        <td><?php echo $item['id_categorias']; ?></td> <!-- Exibe o ID da Categoria associada à notícia -->
                        <td><?php echo $item['id_autor']; ?></td> <!-- Exibe o ID do Autor da notícia -->
                        <td><?php echo $item['data_publicacao']; ?></td> <!-- Exibe a Data de Publicação da notícia -->
                        <td>
                            <!-- Link para editar a notícia, passando o ID como parâmetro na URL -->
                            <a href="editarNoticia.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <!-- Link para excluir a notícia, passando o ID como parâmetro na URL -->
                            <a href="excluirNoticia.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Finaliza o loop que exibe todas as notícias -->
            </tbody>
        </table>
    </div>
</body>
</html>

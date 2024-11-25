<?php
session_start();
include 'classes/noticias.class.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$noticia = new Noticias();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Notícias - OVERTIME</title>
    <link rel="stylesheet" href="css/gestaoNoticia.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>Gestão de Notícias</h1>
    </header>
    
    <div class="button-container">
        <a href="adicionarNoticia.php" class="button">ADICIONAR</a>
    </div>

    <hr>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Conteúdo</th>
                    <th>Imagem</th>
                    <th>Categoria</th>
                    <th>Autor</th>
                    <th>Data de Publicação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $lista = $noticia->listar();
                foreach($lista as $item):
                ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['titulo']; ?></td>
                        <td><?php echo $item['conteudo']; ?></td>
                        <td><img src="<?php echo $item['imagem']; ?>" alt="Imagem da notícia" class="news-image"></td>
                        <td><?php echo $item['id_categoria']; ?></td>
                        <td><?php echo $item['id_autor']; ?></td>
                        <td><?php echo $item['data_publicacao']; ?></td>
                        <td>
                            <a href="editarNoticia.php?id=<?php echo $item['id']; ?>" class="action-button">Editar</a>
                            <a href="excluirNoticia.php?id=<?php echo $item['id']; ?>" class="action-button">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

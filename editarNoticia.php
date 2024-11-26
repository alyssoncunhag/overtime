<?php
// Incluir a classe Noticias, que contém os métodos necessários para manipulação de notícias no banco de dados
include 'classes/noticias.class.php';
$noticia = new Noticias(); // Cria um objeto da classe Noticias para interagir com o banco de dados

// Verifica se o ID foi passado via GET e se ele não está vazio
if (!empty($_GET['id'])) {
    $id = $_GET['id']; // Atribui o ID da notícia passado via GET
    $info = $noticia->buscar($id); // Busca as informações da notícia com o ID fornecido
    // Verifica se o título da notícia não está vazio
    if (empty($info['titulo'])) {
        // Se o título estiver vazio, redireciona para a página inicial
        header("Location: /overtime");
        exit; // Interrompe a execução do código
    }
} else {
    // Se o ID não foi passado, redireciona para a página inicial
    header("Location: /overtime");
    exit; // Interrompe a execução do código
}

// Verifica se o formulário foi enviado com o ID da notícia (POST)
if (!empty($_POST['id'])) {
    // Captura os dados do formulário enviados via POST
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $imagem = $_FILES['imagem']; // Captura a imagem enviada pelo formulário
    $id_categorias = $_POST['id_categorias']; // Captura o ID da categoria da notícia
    $id_autor = $_POST['id_autor']; // Captura o ID do autor da notícia
    $data_publicacao = $_POST['data_publicacao']; // Captura a data de publicação da notícia
    
    // Verifica se uma imagem foi enviada
    if (isset($_FILES['imagem'])) {
        $imagem = $_FILES['imagem']; // Se imagem foi enviada, captura o arquivo
    } else {
        $imagem = array(); // Caso contrário, define como um array vazio
    }

    // Se o título da notícia não estiver vazio, chama o método editar da classe Noticias
    if (!empty($titulo)) {
        // Chama o método editar para atualizar as informações da notícia no banco de dados
        $noticia->editar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao, $_GET['id']);
    }
    // Após a edição, redireciona o usuário para a página principal
    header("Location: /overtime");
}
?>

<!-- HTML para o formulário de edição de notícia -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia</title>
    <!-- Ligação com o arquivo CSS -->
    <link rel="stylesheet" href="css/editarNoticia.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <h1>EDITAR NOTÍCIA</h1>
    </header>

    <!-- Container do formulário -->
    <div class="form-container">
        <form action="editarNoticiaSubmit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $info['id']; ?>">

            <div class="input-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" value="<?php echo $info['titulo']; ?>"/>
            </div>

            <div class="input-group">
                <label for="conteudo">Conteúdo:</label>
                <textarea name="conteudo"><?php echo $info['conteudo']; ?></textarea>
            </div>

            <div class="input-group">
                <label for="id_categorias">Categoria:</label>
                <input type="text" name="id_categorias" value="<?php echo $info['id_categorias']; ?>"/>
            </div>

            <div class="input-group">
                <label for="id_autor">Autor:</label>
                <input type="text" name="id_autor" value="<?php echo $info['id_autor']; ?>"/>
            </div>

            <div class="input-group">
                <label for="data_publicacao">Data de Publicação:</label>
                <input type="date" name="data_publicacao" value="<?php echo $info['data_publicacao']; ?>"/>
            </div>

            <div class="input-group">
                <label for="imagem">Imagem:</label>
                <input type="file" name="imagem[]" multiple />
            </div>

            <div class="button-container">
                <input type="submit" name="btAlterar" value="ALTERAR" class="submit-button"/>
            </div>
        </form>
    </div>
</body>
</html>



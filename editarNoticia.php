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
<h1>EDITAR NOTÍCIA</h1>

<form action="editarNoticiaSubmit.php" method="POST" enctype="multipart/form-data">
    <!-- Campo oculto para o ID da notícia, para garantir que o servidor saiba qual notícia editar -->
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    
    <!-- Campo para o título da notícia -->
    Título: <br>
    <input type="text" name="titulo" value="<?php echo $info['titulo'] ;?>"/><br><br>

    <!-- Campo para o conteúdo da notícia -->
    Conteúdo: <br>
    <textarea name="conteudo"><?php echo $info['conteudo'] ;?></textarea><br><br>

    <!-- Campo para o ID da categoria da notícia -->
    Categoria: <br>
    <input type="text" name="id_categorias" value="<?php echo $info['id_categorias'] ;?>"/><br><br>

    <!-- Campo para o ID do autor da notícia -->
    Autor: <br>
    <input type="text" name="id_autor" value="<?php echo $info['id_autor'] ;?>"/><br><br>

    <!-- Campo para a data de publicação da notícia -->
    Data de Publicação: <br>
    <input type="date" name="data_publicacao" value="<?php echo $info['data_publicacao'] ;?>"/><br><br>

    <!-- Campo para upload de imagens (permitindo múltiplas imagens) -->
    Imagem: <br>
    <input type="file" name="imagem[]" multiple /><br>
 
    <!-- Se houver imagens associadas à notícia, exibe as imagens e permite excluir -->
    <div class="cabecalho">Imagem da Notícia</div>
    <div class="corpo">
    <?php if (!empty($info['imagem']) && is_array($info['imagem'])): ?>
        <!-- Se houver imagens associadas, exibe-as -->
        <?php foreach ($info['imagem'] as $fotos): ?>
            <div class="foto_item">
                <img src="img/noticias/<?php echo $fotos['url']; ?>"/>
                <a href="excluir_foto.php?id=<?php echo $fotos['id'];?>">Excluir Imagem</a>
            </div> 
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Se não houver imagens, exibe uma mensagem -->
        <p>Não há imagens para esta notícia.</p>
    <?php endif; ?>
    </div>

    <!-- Botão para submeter o formulário de edição -->
    <input type="submit" name="btAlterar" value="ALTERAR"/>
</form>

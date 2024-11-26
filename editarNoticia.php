<?php
include 'classes/noticias.class.php';
$noticia = new Noticias();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $info = $noticia->buscar($id);
    if (empty($info['titulo'])) {
        header("Location: /overtime");
        exit;
    }
} else {
    header("Location: /overtime");
    exit;
}

if (!empty($_POST['id'])) {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $imagem = $_FILES['imagem']; // Para imagens
    $id_categorias = $_POST['id_categorias'];
    $id_autor = $_POST['id_autor'];
    $data_publicacao = $_POST['data_publicacao'];
    
    if (isset($_FILES['imagem'])) {
        $imagem = $_FILES['imagem']; // Se imagem for enviada, captura
    } else {
        $imagem = array(); // Se não houver imagem
    }

    if (!empty($titulo)) {
        $noticia->editar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao, $_GET['id']);
    }
    header("Location: /overtime");
}
?>

<h1>EDITAR NOTÍCIA</h1>

<form action="editarNoticiaSubmit.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    Título: <br>
    <input type="text" name="titulo" value="<?php echo $info['titulo'] ;?>"/><br><br>
    Conteúdo: <br>
    <textarea name="conteudo"><?php echo $info['conteudo'] ;?></textarea><br><br>
    Categoria: <br>
    <input type="text" name="id_categorias" value="<?php echo $info['id_categorias'] ;?>"/><br><br>
    Autor: <br>
    <input type="text" name="id_autor" value="<?php echo $info['id_autor'] ;?>"/><br><br>
    Data de Publicação: <br>
    <input type="date" name="data_publicacao" value="<?php echo $info['data_publicacao'] ;?>"/><br><br>
    Imagem: <br>
    <input type="file" name="imagem[]" multiple /><br>
 
    <div class="cabecalho">Imagem da Notícia</div>
    <div class="corpo">
    <?php if (!empty($info['imagem']) && is_array($info['imagem'])): ?>
        <?php foreach ($info['imagem'] as $fotos): ?>
            <div class="foto_item">
                <img src="img/noticias/<?php echo $fotos['url']; ?>"/>
                <a href="excluir_foto.php?id=<?php echo $fotos['id'];?>">Excluir Imagem</a>
            </div> 
        <?php endforeach; ?>
    <?php else: ?>
        <p>Não há imagens para esta notícia.</p>
    <?php endif; ?>
    </div>
    <input type="submit" name="btAlterar" value="ALTERAR"/>
</form>

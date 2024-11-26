<?php
include 'classes/noticias.class.php';
$noticia = new Noticias();

if (!empty($_POST['id'])) {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $imagem = $_FILES['imagem'];
    $id_categorias = $_POST['id_categorias'];
    $id_autor = $_POST['id_autor'];
    $data_publicacao = $_POST['data_publicacao'];
    $id = $_POST['id'];

    if (!empty($titulo)) {
        $noticia->editar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao, $id);
    }
    header("Location: /overtime");
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $info = $noticia->buscar($_GET['id']);
} else {
    ?>
    <script type="text/javascript">window.location.href="index.php";</script>
    <?php
    exit;
}
?>
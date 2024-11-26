<?php
include 'classes/noticias.class.php';
$noticia = new Noticias();

if(!empty($_POST['titulo']) && isset($_POST['titulo'])){
    $titulo = $_POST['titulo']; // Corrigido para 'titulo'
    $conteudo = $_POST['conteudo'];
    $imagem = $_POST['imagem'];
    $id_categorias = $_POST['id_categorias'];
    $id_autor = $_POST['id_autor']; // Adicionado: 'id_autor'
    $data_publicacao = $_POST['data_publicacao'];

    $resultado = $noticia->adicionar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao); // Corrigido para passar todos os parâmetros necessários

    if ($resultado) {
        header('Location: index.php'); // Redireciona após a adição
    } else {
        echo '<script type="text/javascript">alert("Notícia já cadastrada!");</script>';
    }
} else {
    echo '<script type="text/javascript">alert("Preencha todos os campos!");</script>';
}
?>

<?php
include 'classes/noticias.class.php';
$noticia = new Noticias();

if(!empty($_POST['id'])){
    $titulo = $_POST['nome'];
    $conteudo = $_POST['conteudo'];
    $imagem = $_POST['imagem'];
    $id_categoria = $_POST['id_categoria'];
    $data_publicacao = $_POST['data_publicacao'];
    $noticia->adicionar($titulo, $conteudo, $imagem, $id_categoria, $data_publicacao);
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Noticia já cadastrado!");<script>';
}
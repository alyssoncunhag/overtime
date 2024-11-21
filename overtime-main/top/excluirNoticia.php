<?php
include 'classes/noticias.class.php';
$com = new Noticias();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $com ->deletar($id);
    header('Location: /overtime');
}else{
    echo '<script type="text/javascript">alert("Erro ao excluir noticia!");</script>';
    header('Location: /overtime');
}
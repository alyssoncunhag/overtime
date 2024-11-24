<?php
include 'classes/categorias.class.php';
$com = new Categorias();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $com ->deletar($id);
    header('Location: /overtime');
}else{
    echo '<script type="text/javascript">alert("Erro ao excluir categoria!");</script>';
    header('Location: /overtime');
}
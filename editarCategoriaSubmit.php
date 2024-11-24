<?php
include 'classes/categorias.class.php'
$categoria = new Categorias();

if(!empty($_POST['id'])){
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $id = $_POST['id'];

    if(!empty($nome)){
        $categoria->editar($nome, $categoria, $id);
    }
    header("Location: /overtime");
}
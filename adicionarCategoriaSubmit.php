<?php
include 'classes/categorias.class.php';
$categoria = new Categorias();

if(!empty($_POST['id'])){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $categoria->adicionar($nome, $descricao);
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Categoria já cadastrado!");</script>';
}
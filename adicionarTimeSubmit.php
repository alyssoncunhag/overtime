<?php
include 'classes/times.class.php';
$time = new Times();

if(!empty($_POST['nome'])){
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];
    $time->adicionar($nome, $pais, $descricao, $imagem);
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Time já cadastrado!");</script>';
}


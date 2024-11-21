<?php
include 'classes/torneios.class.php';
$torneio = new Torneios();

if(!empty($_POST['id'])){
    $nome = $_POST['nome'];
    $id_jogo = $_POST['id_jogo'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $torneio->adicionar($nome, $id_nome, $descricao, $data_inicio, $data_fim);
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Torneio já cadastrado!");</script>';
}
<?php
include 'classes/jogos.class.php';
$com = new Jogos();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $com ->deletar($id);
    header('Location: /overtime');
}else{
    echo '<script type="text/javascript">alert("Erro ao excluir jogo!");</script>';
    header('Location: /overtime');
}
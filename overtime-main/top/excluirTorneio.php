<?php
include 'classes/torneios.class.php';
$com = new Torneios();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $com ->deletar($id);
    header('Location: /overtime');
}else{
    echo '<script type="text/javascript">alert("Erro ao excluir torneio!");</script>';
    header('Location: /overtime');
}
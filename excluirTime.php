<?php
include 'classes/times.class.php';
$com = new Times();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $com ->deletar($id);
    header('Location: /overtime');
}else{
    echo '<script type="text/javascript">alert("Erro ao excluir time!");</script>';
    header('Location: /overtime');
}
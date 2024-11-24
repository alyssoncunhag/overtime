<?php
include 'classes/usuarios.class.php';
$com = new Usuarios();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $com ->deletar($id);
    header('Location: /overtime');
}else{
    echo '<script type="text/javascript">alert("Erro ao excluir usuario!");</script>';
    header('Location: /overtime');
}
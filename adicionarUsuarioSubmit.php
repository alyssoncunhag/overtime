<?php
include 'classes/usuarios.class.php';
$usuario = new Usuarios();

if(!empty($_POST['email'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $permissoes = $_POST['permissoes'];
    $usuario->adicionar( $nome, $email, $senha, $permissoes);
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Usuário já cadastrado!");</script>';
}
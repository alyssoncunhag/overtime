<?php
session_start();
require 'classes/usuarios.class.php';

if (!empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = addslashes($_POST['email']);
    $senha = $_POST['senha']; // A senha será verificada usando password_verify, sem criptografia aqui.

    $usuarios = new Usuarios();
    if ($usuarios->fazerLogin($email, $senha)) {
        header("Location: index.php");
        exit;
    } else {
        echo '<span style="color: red;">' . htmlspecialchars("Usuário e/ou senha incorretos!") . '</span>';
    }
}
?>
<h1>LOGIN</h1>
<form method="POST">
    Email: <br>
    <input type="email" name="email" required><br><br>
    Senha: <br>
    <input type="password" name="senha" required><br><br>
    <a href="esqueceuSenha.php">ESQUECEU SUA SENHA? CLIQUE AQUI</a><br><br>
    <input type="submit" value="Entrar">
</form>

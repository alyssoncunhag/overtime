<?php
session_start();
include 'classes/usuarios.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}

$usuario = new Usuarios();
$usuario->setUsuario($_SESSION['logado']);
?>

<h1>OVERTIME</h1>
<hr>

<!-- Verificação de permissão 'ADMIN' para gerenciar usuários -->
<?php if($usuario->temPermissoes("ADMIN")): ?>
    <button><a href="gestaoUsuario.php">Gerenciar Usuários</a></button>
<?php endif; ?>

<!-- Botão de logout -->
<button><a href="sair.php">SAIR</a></button>

<!-- Verificação de permissão 'ADMIN' para gerenciar categorias -->
<?php if($usuario->temPermissoes("ADMIN")): ?>
    <button><a href="gestaoCategoria.php">Gerenciar Categorias</a></button>
<?php endif; ?>

<!-- Verificação de permissão 'ADMIN' para gerenciar times -->
<?php if($usuario->temPermissoes("ADMIN")): ?>
    <button><a href="gestaoTime.php">Gerenciar Times</a></button>
<?php endif; ?>

<!-- Verificação de permissão 'ADMIN' para gerenciar torneios -->
<?php if($usuario->temPermissoes("ADMIN")): ?>
    <button><a href="gestaoTorneios.php">Gerenciar Torneios</a></button>
<?php endif; ?>

<!-- Verificação de permissão 'ADMIN' para gerenciar notícias -->
<?php if($usuario->temPermissoes("ADMIN")): ?>
    <button><a href="gestaoNoticias.php">Gerenciar Notícias</a></button>
<?php endif; ?>

<!-- Verificação de permissão 'ADMIN' para gerenciar jogos -->
<?php if($usuario->temPermissoes("ADMIN")): ?>
    <button><a href="gestaoJogos.php">Gerenciar Jogos</a></button>
<?php endif; ?>

<br><br>

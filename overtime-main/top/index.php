<?php
session_start();
include '../classes/usuarios.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit();
}

$usuario = new Usuarios();
$usuario = setUsuario($_SESSION['logado']);

?>

<h1>OVERTIME</h1>
<hr>
<?php if($usuario->temPermissao("ADMIN")): ?><button><a href="gestaoUsuario.php"></a></button>Gerenciar Usuários</a></button><?php endif; ?>
<button><a href="sair.php">SAIR</a></button>
<?php if($usuario->temPermissao("ADMIN")): ?><button><a href="gestaoCategoria.php">Gerenciar Categorias</a></button><?php endif;?>
<?php if($usuario->temPermissao("ADMIN")): ?><button><a href="gestaoTime.php">Gerenciar Times</a></button><?php endif;?>
<?php if($usuario->temPermissao("ADMIN")): ?><button><a href="gestaoTorneios.php">Gerenciar Torneios</a></button><?php endif;?>
<?php if($usuario->temPermissao("ADMIN")): ?><button><a href="gestaoNoticias.php">Gerenciar Notícias</a></button><?php endif;?>
<?php if($usuario->temPermissao("ADMIN")): ?><button><a href="gestaoJogos.php">Gerenciar Jogos</a></button><?php endif;?>
<br><br>

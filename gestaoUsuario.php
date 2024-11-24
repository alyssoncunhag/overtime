<?php
session_start();
include 'classes/usuarios.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}


$usuario = new Usuarios();

?>

<h1>Gestão de Usuários</h1>
<hr>
<button><a href="#">ADICIONAR</a></button>
<br><br>
<table border="3" width="100%">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Senha</th>
        <th>Permissões</th>
    </tr>
<?php
$lista = $usuario->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['nome']?></td>
        <td><?php echo $item['email']?></td>
        <td><?php echo $item['senha']?></td>
        <td><?php echo $item['permissoes']?></td>
            <a href="#">Editar</a>
            <a href="#"> | Excluir</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>
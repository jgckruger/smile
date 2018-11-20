<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// including the database connection file
$title = "Editar administrador";
include_once("../../header.php");
include_once("../../db/DBClass.php");
$banco = new DBClass();
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
			<h2>Editar Administrador</h2>
	<br/><br/>
	<?php

if(isset($_POST['update']))
{

	$id = $banco->escapeString($_POST['id']);

	$user = $banco->escapeString($_POST['username']);
	$password = $banco->escapeString($_POST['password']);
	$email = $banco->escapeString($_POST['email']);

	// checking empty fields
	if(empty($user) || empty($email) || empty($password)) {
		//echo "<p>entrou aqui n era</p>";
		if(empty($user)) {
			echo "<font color='red'>O campo Usuário está vazio.</font><br/>";
		}

		if(empty($password)) {
			echo "<font color='red'>O campo Senha está vazio.</font><br/>";
		}

		if(empty($email)) {
			echo "<font color='red'>O campo E-mail está vazio.</font><br/>";
		}
		//link to the previous page
		echo "</div>";
	} else {
		//updating the table

		$result = $banco->query("UPDATE `administrador` SET `username`='$user',`password`='".md5($password)."',`email`='$email' WHERE `idAdmin`=$id");

		//redirectig to the display page. In our case, it is index.php
		echo "<script>window.location.href='index.php'</script>";
	}
}
?>
<?php
//getting id from url
//if(isset($_GET)){
$id = $_GET['id'];

//selecting data associated with this particular id
//echo "SELECT * FROM funcionario WHERE idFuncionario=".$id.";";
$result = $banco->query("SELECT * FROM administrador WHERE idAdmin=".$id.";");

while($res = $banco->fetchArray($result))
{
	$user = $res['username'];
	$password = $res['password'];
	$email = $res['email'];
}
?>

	<form action="edit.php?id=<?php echo ("".$_GET['id']);?>" method="post" name="form1">
		<table width="25%" border="0">
			<tr>
				<td>Usuário</td>
				<td><input type="text" name="username" value=<?php echo $user; ?>></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="email" name="email" value=<?php echo $email; ?>></td>
			</tr>
			<tr>
				<td>Senha</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</main>


<?php
require_once("../../footer.php");
 ?>

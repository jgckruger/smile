<?php
$title = "Editar RFID";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// including the database connection file
include_once("../../header.php");
include_once("../../db/DBClass.php");
$banco = new DBClass();

if(isset($_POST['update']))
{

	$id = $banco->escapeString($_POST['id']);

	$nome = $banco->escapeString($_POST['nome']);
	$nascimento = $banco->escapeString($_POST['nascimento']);
	$email = $banco->escapeString($_POST['email']);

	// checking empty fields
	if(empty($nome) || empty($nascimento) || empty($email)) {

		if(empty($nome)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}

		if(empty($nascimento)) {
			echo "<font color='red'>Age field is empty.</font><br/>";
		}

		if(empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
	} else {
		//updating the table
		$result = $banco->query("UPDATE funcionario SET nome='$nome',nascimento='$nascimento',email='$email' WHERE idFuncionario=$id");

		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = $banco->query("SELECT * FROM funcionario WHERE idFuncionario=".$id.";");

while($res = $banco->fetchArray($result))
{
	$nome = $res['nome'];
	$nascimento = $res['nascimento'];
	//$newDate = date("d-m-Y", strtotime($originalDate));
	$email = $res['email'];
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
			<h2>Editar Funcionário</h2>
	<br/><br/>

	<form action="edit.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr>
				<td>Nome</td>
				<td><input type="text" name="nome" value="<?php echo $nome;?>"></td>
			</tr>
			<tr>
				<td>Nascimento</td>
				<td><input type="date" name="nascimento" value="<?php echo $nascimento;?>"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email" value="<?php echo $email;?>"></td>
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

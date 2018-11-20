<?php
$title = "Editar funcionário";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// including the database connection file
include_once("../../header.php");
include_once("../../db/DBClass.php");
$banco = new DBClass();
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
			<h2>Editar Funcionário</h2>
	<br/><br/>
	<?php
function validaCPF($cpf = null) {

	// Verifica se um número foi informado
	if(empty($cpf)) {
		return false;
	}

	// Elimina possivel mascara
	$cpf = preg_replace("/[^0-9]/", "", $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

	// Verifica se o numero de digitos informados é igual a 11
	if (strlen($cpf) != 11) {
		return false;
	}
	// Verifica se nenhuma das sequências invalidas abaixo
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' ||
		$cpf == '11111111111' ||
		$cpf == '22222222222' ||
		$cpf == '33333333333' ||
		$cpf == '44444444444' ||
		$cpf == '55555555555' ||
		$cpf == '66666666666' ||
		$cpf == '77777777777' ||
		$cpf == '88888888888' ||
		$cpf == '99999999999') {
		return false;
	 // Calcula os digitos verificadores para verificar se o
	 // CPF é válido
	 } else {

		for ($t = 9; $t < 11; $t++) {

			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
			}
		}

		return true;
	}
}


if(isset($_POST['update']))
{

	$id = $banco->escapeString($_POST['id']);

	$nome = $banco->escapeString($_POST['nome']);
	$nascimento = $banco->escapeString($_POST['nascimento']);
	$email = $banco->escapeString($_POST['email']);
	$cpf = $banco->escapeString($_POST['cpf']);

	// checking empty fields
	if(empty($nome) || empty($nascimento) || empty($email)|| empty($cpf) || !validaCPF($cpf)) {
		echo "<div>";
		if(empty($nome)) {
			echo "<font color='red'>O campo Nome está vazio.</font><br/>";
		}

		if(empty($nascimento)) {
			echo "<font color='red'>O campo Nascimento está vazio.</font><br/>";
		}

		if(empty($email)) {
			echo "<font color='red'>O campo Email está vazio.</font><br/>";
		}

		if(empty($cpf)) {
			echo "<font color='red'>O campo CPF está vazio.</font><br/>";
		}
		if(!validaCPF($cpf)){
      echo "<font color='red'>O CPF é inválido.</font><br/>";
    }
		echo "</div>";
	} else {
		//updating the table
		$result = $banco->query("UPDATE funcionario SET nome='$nome',nascimento='$nascimento',email='$email',cpf='$cpf' WHERE idFuncionario=$id");

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
$result = $banco->query("SELECT * FROM funcionario WHERE idFuncionario=".$id.";");

while($res = $banco->fetchArray($result))
{
	$nome = $res['nome'];
	$nascimento = $res['nascimento'];
	//$newDate = date("d-m-Y", strtotime($originalDate));
	$email = $res['email'];
	$cpf = $res['cpf'];
}
?>

	<form action="edit.php?id=<?php echo ("".$_GET['id']);?>" method="post" name="form1">
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
				<td>CPF</td>
				<td><input type="text" id="cpf" name="cpf" value="<?php echo $cpf;?>"></td>
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

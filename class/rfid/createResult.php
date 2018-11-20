<?php
require_once("../../header.php");
//including the database connection file
require_once("../../db/DBClass.php");
$banco = new DBClass();
?>

<!-- <pre><?php// var_dump($banco); ?></pre> -->
<!-- <pre><?php// var_dump($_POST); ?></pre> -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
			<h2>Novo Funcionário</h2>


<?php
if(isset($_POST['Submit'])) {
	$rfid = $banco->escapeString($_POST['rfid']);
	$idFuncionario = $banco->escapeString($_POST['idFuncionario']);

	// checking empty fields
	if(empty($rfid) || empty($idFuncionario)) {
		//echo "<p>entrou aqui n era</p>";
		if(empty($rfid)) {
			echo "<font color='red'>O campo RFID está vazio.</font><br/>";
		}
		if(empty($idFuncionario)) {
			echo "<font color='red'>O campo Funcionário está vazio.</font><br/>";
		}
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Voltar</a>";
	} else {
		// if all the fields are filled (not empty)

		//insert data to database
		$str = "INSERT INTO `rfid` (`rfid`, `idFuncionario`) VALUES ('$rfid', '$idFuncionario');";
		echo($str);
		$resultado = $banco->query("INSERT INTO `rfid` (`rfid`, `idFuncionario`) VALUES ('$rfid', '$idFuncionario');");
		//display success message
		//echo "<p>entrou aqui n era</p>";
		//var_dump($_POST);
		echo "<font color='green'>Funcionario adicionado com sucesso!";
		echo "<br><a href='index.php'>Ver resultado</a>";
	}
}
?>
</main>
<?php
require_once("../../footer.php");
?>

<?php
require_once("../../header.php");
//including the database connection file
require_once("../../db/DBClass.php");
$banco = new DBClass();
?>

<!-- <pre><?php// var_dump($banco); ?></pre> -->
 <pre><?php var_dump($_POST); ?></pre>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
			<h2>Novo Administrador</h2>


<?php
if(isset($_POST['Submit'])) {
	$user = $banco->escapeString($_POST['username']);
	$email = $banco->escapeString($_POST['email']);
	$password = $banco->escapeString($_POST['password']);

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
		echo "<br/><a href='javascript:self.history.back();'>Voltar</a>";
	} else {
		// if all the fields are filled (not empty)

		//insert data to database
		$resultado = $banco->query("INSERT INTO `administrador`(`username`, `password`, `email`) VALUES ('$user','".md5($password)."','$email')");
		//display success message
		//echo "<p>entrou aqui n era</p>";
		echo "<font color='green'>Administrador adicionado com sucesso!";
		echo "<br><a href='index.php'>Ver resultado</a>";
	}
}
?>
</main>
<?php
require_once("../../footer.php");
?>

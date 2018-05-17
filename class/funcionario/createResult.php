<?php
require_once("../../header.php");
//including the database connection file
require_once("../../db/DBClass.php");
$banco = new DBClass();
?>

<pre><?php var_dump($banco); ?></pre>
<pre><?php var_dump($_POST); ?></pre>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<h2>Novo Funcionário</h2>


<?php
if(isset($_POST['Submit'])) {
	$nome = $banco->escapeString($_POST['nome']);
	$nascimento = $banco->escapeString($_POST['nascimento']);
	$email = $banco->escapeString($_POST['email']);

	// checking empty fields
	if(empty($nome) || empty($nascimento) || empty($email)) {
		echo "<p>entrou aqui n era</p>";
		if(empty($nome)) {
			echo "<font color='red'>O campo Nome está vazio.</font><br/>";
		}

		if(empty($nascimento)) {
			echo "<font color='red'>O campo Nascimento está vazio.</font><br/>";
		}

		if(empty($email)) {
			echo "<font color='red'>O campo Email está vazio.</font><br/>";
		}

		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Voltar</a>";
	} else {
		// if all the fields are filled (not empty)

		//insert data to database
		$resultado = $banco->query("INSERT INTO funcionario(nome,nascimento,email) VALUES('$nome','$nascimento','$email')");
		//display success message
		//echo "<p>entrou aqui n era</p>";
		echo "<font color='green'>Funcionario adicionado com sucesso!";
		echo "<br><a href='index.php'>Ver resultado</a>";
	}
}
?>
</main>
<?php
require_once("../../footer.php");
?>

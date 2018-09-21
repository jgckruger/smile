<?php
require_once("../../header.php");
//including the database connection file
require_once("../../db/DBClass.php");
$banco = new DBClass();
?>

<!-- <pre><?php// var_dump($banco); ?></pre> -->
 <pre><?php var_dump($_POST); ?></pre>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<h2>Novo Funcionário</h2>


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

if(isset($_POST['Submit'])) {
	$nome = $banco->escapeString($_POST['nome']);
	$nascimento = $banco->escapeString($_POST['nascimento']);
	$email = $banco->escapeString($_POST['email']);
	$cpf = $banco->escapeString($_POST['cpf']);

	// checking empty fields
	if(empty($nome) || empty($nascimento) || empty($email) || empty($cpf)) {
		//echo "<p>entrou aqui n era</p>";
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

    if(validaCPF($cpf)){
      echo "<font color='red'>O CPF é inválido.</font><br/>";
    }

		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Voltar</a>";
	} else {
		// if all the fields are filled (not empty)

		//insert data to database
		$resultado = $banco->query("INSERT INTO funcionario(nome,nascimento,email, cpf) VALUES('$nome','$nascimento','$email', '$cpf')");
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

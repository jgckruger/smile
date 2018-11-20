<?php
$title = "Inserir funcionário";
require_once("../../header.php");
//including the database connection file
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
			<h2>Novo Funcionário</h2>
	<br/><br/>

	<form action="createResult.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr>
				<td>Nome</td>
				<td><input type="text" name="nome"></td>
			</tr>
			<tr>
				<td>Nascimento</td>
				<td><input type="date" name="nascimento"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email"></td>
			</tr>
			<tr>
				<td>CPF</td>
				<td><input type="text" id="cpf" name="cpf"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="Submit" value="Add"></td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php
require_once("../../footer.php");
?>

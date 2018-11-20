<?php
require_once("../../header.php");
//including the database connection file
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	</div>
			<h2>Novo Administrador</h2>
	<br/><br/>

	<form action="createResult.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr>
				<td>Usuário</td>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="email" name="email"></td>
			</tr>
			<tr>
				<td>Senha</td>
				<td><input type="password" name="password"></td>
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

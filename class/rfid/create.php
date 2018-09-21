<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT `idFuncionario`, `nome`, `email`, DATE_FORMAT(`nascimento`,'%d/%m/%Y') AS `nascimento`, cpf FROM `funcionario` WHERE 1  ");
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<h2>Novo Identificador RFID</h2>
	<br/><br/>

	<form action="createResult.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr>
				<td>RFID</td>
				<td><input type="text" name="rfid"></td>
			</tr>
			<tr>

    			<label for="idFuncionario">Funcionário Responsável</label>
    				<select class="form-control" name="idFuncionario">
							<?php
							while ($row = $resultado->fetch_assoc()) {
								echo("<option value=". $row['idFuncionario'].">".$row['nome']."</option>");
							}?>
    				</select>

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
//require_once("../../footer.php");
?>

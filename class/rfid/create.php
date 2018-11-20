<?php
$title = "Inserir RFID";
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT `idFuncionario`, `nome`, `email`, DATE_FORMAT(`nascimento`,'%d/%m/%Y') AS `nascimento`, cpf FROM `funcionario` WHERE 1  ");

$resultado2 = $banco->query("SELECT DISTINCT `campo` FROM `registrosRFID` WHERE `campo` not in (SELECT `campo` FROM `registrosRFID` INNER JOIN `rfid` ON `registrosRFID`.`campo` = `rfid`.`rfid`)");
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
			<h2>Novo Identificador RFID</h2>
	<br/><br/>

	<form action="createResult.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr>

    			<label for="rfid">Identificador RFID</label>
    				<select class="form-control" name="rfid">
							<?php
							while ($row2 = $resultado2->fetch_assoc()) {
								echo("<option value=". $row2['campo'].">".$row2['campo']."</option>");
							}?>
    				</select>

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

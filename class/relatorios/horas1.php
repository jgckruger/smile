<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT `idFuncionario`, `nome` FROM `funcionario` WHERE 1  ");
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
  <h2>Histórico de pontos e horas</h2>
	<br/><br/>

	<form action="horas2.php" method="post" name="form1">
		<table width="25%" border="0">
			<tr>
        <label for="idFuncionario">Funcionário</label>
          <select class="form-control" name="idFuncionario">
            <?php
            while ($row = $resultado->fetch_assoc()) {
              echo("<option value=". $row['idFuncionario'].">".$row['nome']."</option>");
            }?>
          </select>
			</tr>
			<tr>
				<label for="inicio">Mês e ano</label>
				<td><input type="month" name="inicio" value="<?php echo date('Y-m');?>"  oninvalid="this.setCustomValidity('Por favor preencha esse campo!')" required></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="Submit" value="Requisitar relatório"></td>
			</tr>
		</table>
	</form>
</body>
</html>


<?php
$banco->close();
require_once("../../footer.php");
 ?>

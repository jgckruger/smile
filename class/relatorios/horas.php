<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();

// Calcula número de dias do mês
function days_in_month($month, $year){
	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
} 

// Atribui os parâmetros do GET para essas variáveis
// Mudar para post depois
$ano = $_GET["ano"];
$mes = $_GET["mes"];
$id  = $_GET["id"];


// Obtém os dados do funcionário, no mês especícico do ano específico e os coloca na variável pontos
$query = "SELECT funcionario.idFuncionario, rfid.rfid, funcionario.nome, passagem.horario FROM (((rfid INNER JOIN funcionario ON rfid.idFuncionario = funcionario.idFuncionario ) INNER JOIN rfidPassagem ON rfidPassagem.rfid = rfid.rfid) INNER JOIN passagem ON rfidPassagem.idPassagem = passagem.idPassagem) where funcionario.idFuncionario = ". $id ." AND passagem.horario >= '".  $ano . "-" . $mes . "-01' and passagem.horario < '".  $ano . "-" . ($mes+1) . "-01' ORDER BY `passagem`.`horario` ASC";
$resultado = $banco->query($query);
$pontos = array();
while ($row = $resultado->fetch_assoc()) {
	array_push($pontos, $row);
}

// Caso não retorne resultado, exibir zero
if(count($pontos) == 0){
	echo "zero";
}
	 
	 
// Array com as horas de cada dia
$horas = array();
// Array que contém a tupla entrada, saída, horas trabalhadas
$tabela = array();

// Itera pelos dias do mês
for($i = 1; $i <= days_in_month($mes , $ano ); $i++){
	
	// Agrupa os dias do mês na variável dia
	$dia = array();
	foreach ($pontos as $row) {
		$dateRow = date($row['horario']);
		$curr = date($ano.'-'.$mes.'-'.$i);
		$datediff = strtotime($curr) - strtotime($dateRow);
		$diferenca = floor($datediff/(60*60*24));
		if($diferenca == -1){
			array_push($dia,$row);
		}
	}
		
	// Se o funcionário não trabalhou no dia, insere 0 no array de horas trabalhadas
	if(count($dia) == 0){
		$horas[$i]=0;
	}
	
	
	// Se o funcionário bateu o ponto um número impar de vezes no dia, ele perde o último ponto
	else if(count($dia) % 2 == 1){
		array_pop($dia);
		$horas[$i] = Datetime::createFromFormat('H:i:s','00:00:00');
		// Itera sobre os pontos do dia e os pareia.
		for($j = 0; $j < count($dia); $j+=2){
			$d2 = new DateTime($dia[$j+1]['horario']);
			$d1 = new DateTime($dia[$j]['horario']);
			$entradaTabela = array();
			$entradaTabela['nome'] = $dia[$j]['nome'];
			$entradaTabela['entrada']= $d1;
			$entradaTabela['saida']= $d2;
			$entradaTabela['tempo']= $diferenca = $d1->diff($d2);
			array_push($tabela,$entradaTabela);
			$horas[$i]->add($diferenca);
		}
	}
	else{ // ponto certinho
		$horas[$i] = Datetime::createFromFormat('H:i:s','00:00:00');
		// Itera sobre os pontos do dia e os pareia.
		for($j = 0; $j < count($dia); $j+=2){
			$d2 = new DateTime($dia[$j+1]['horario']);
			$d1 = new DateTime($dia[$j]['horario']);
			$entradaTabela = array();
			$entradaTabela['nome'] = $dia[$j]['nome'];
			$entradaTabela['entrada']= $d1;
			$entradaTabela['saida']= $d2;
			$entradaTabela['tempo']= $diferenca = $d1->diff($d2);
			array_push($tabela,$entradaTabela);
			$horas[$i]->add($diferenca);
		}
	}
 
}


?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
       <h2>Registro dos Pontos</h2>
       <br/><br/>
       <div class="table-responsive">
         <table id="tabela_relatorio" class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Nome</th>
               <th>Hora de entrada</th>
               <th>Hora de saída</th>
               <th>Tempo de permanência</th>
             </tr>
           </thead>
           <?php
            foreach ($tabela as $ponto)  {
				echo "<tr>";
				echo "<td>".$ponto['nome']."</td>";
				echo "<td>".$ponto['entrada']->format('d/m/Y H:s:s')."</td>";
				echo "<td>".$ponto['entrada']->format('d/m/Y H:i:s')."</td>";
				echo "<td>".$ponto['tempo']->format('%H:%I:%S')."</td>";
				echo "</tr>";
           	}
         	?>
         	</table>
       </div>
       <div class="table-responsive">
         <table id="tabela" class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Nome</th>
               <th>Dia</th>
               <th>Tempo de permanência no dia</th>
             </tr>
           </thead>
           <?php
            for($i = 1; $i <= days_in_month($mes , $ano ); $i++){
				echo "<tr>";
				echo "<td>".$tabela[0]['nome']."</td>";
				echo "<td>".$i."/".$mes."/".$ano."</td>";
				echo ($horas[$i]==0 ? "<td>Não trabalhou no dia</td>" : "<td>".$horas[$i]->format('H:i:s')."</td>");
				echo "</tr>";
           	}
         	?>
         	</table>
       </div>
     </main>

<?php
$banco->close();
require_once("../../footer.php");
 ?>

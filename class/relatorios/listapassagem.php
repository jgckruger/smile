<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT rfid.rfid, funcionario.nome, passagem.horario, passagem.fotoIN, passagem.fotoOUT FROM (((rfid INNER JOIN funcionario ON rfid.idFuncionario = funcionario.idFuncionario ) INNER JOIN rfidPassagem ON rfidPassagem.rfid = rfid.rfid) INNER JOIN passagem ON rfidPassagem.idPassagem = passagem.idPassagem) ORDER BY (horario) DESC");
 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <h2>Registro das Passagens</h2>
       <br/><br/>
       <div class="table-responsive">
         <table id="tabela" class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Horário</th>
               <th>Funcionário</th>
               <th>RFID</th>
               <th>Foto interna</th>
               <th>Foto externa</th>
             </tr>
           </thead>
         	<?php

          while ($row = $resultado->fetch_assoc()) {
            //var_dump($row);
         		echo "<tr>";
            echo "<td>".date('H:i:s d-m-Y',strtotime($row['horario']))."</td>";
            echo "<td>".$row['nome']."</td>";
         		echo "<td>".$row['rfid']."</td>";
            echo "<td><a href=\"".$row['fotoIN']."\"><img src=\"".$row['fotoIN']."\" height=\"180\" width=\"320\"></a></td>";
            echo "<td><a href=\"".$row['fotoOUT']."\"><img src=\"".$row['fotoOUT']."\" height=\"180\" width=\"320\"></a></td>";
         		//echo "<td><a href=\"edit.php?id=$row[idFuncionario]\">Edit</a> | <a href=\"delete.php?id=$row[idFuncionario]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
         	}
         	?>
         	</table>
       </div>
     </main>
<?php
$banco->close();
require_once("../../footer.php");
 ?>

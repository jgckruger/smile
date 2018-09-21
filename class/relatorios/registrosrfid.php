<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
//$resultado = $banco->query("SELECT `id`, `campo`, DATE_FORMAT(`horario`,'%d/%m/%Y - %H:%i:%s') AS `horario` FROM `registrosRFID` WHERE 1 ORDER BY (horario) DESC");
$resultado = $banco->query("SELECT `id`, `campo`, `horario` FROM `registrosRFID` WHERE 1 ORDER BY (horario) DESC");

 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <h2>Registro das Passagens</h2>
       <br/><br/>
       <div class="table-responsive">
         <table id="tabela" class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Horário</th>
               <th>RFID</th>
             </tr>
           </thead>
         	<?php

          while ($row = $resultado->fetch_assoc()) {
            //var_dump($row);
         		echo "<tr>";
            echo "<td>".date('H:i:s d-m-Y',strtotime($row['horario']))."</td>";
         		echo "<td>".$row['campo']."</td>";

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

<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT * FROM rfid INNER JOIN funcionario ON rfid.idFuncionario = funcionario.idFuncionario");
 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <h2>Identificadores RFID</h2>
       <a href="create.php">
         <button type="button" class="btn btn-primary" >Novo Identificador</button>
       </a>
       <br/><br/>
       <div class="table-responsive">
         <table id="tabela"class="table table-striped table-sm">
           <thead>
             <tr>
               <th>CPF</th>
               <th>Nome</th>
               <th>RFID</th>
               <th>Opções</th>
             </tr>
           </thead>
         	<?php

          while ($row = $resultado->fetch_assoc()) {
            //var_dump($row);
         		echo "<tr>";
            echo "<td>".$row['cpf']."</td>";
         		echo "<td>".$row['nome']."</td>";
         		echo "<td>".$row['rfid']."</td>";
         		//echo "<td><a href=\"edit.php?id=$row[rfid]\">Edit</a> | <a href=\"delete.php?id=$row[rfid]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
            echo "<td><a href=\"delete.php?id=$row[rfid]\" onClick=\"return confirm('Tem certeza que deseja apagar a entrada?')\">Apagar</a></td>";

          }
         	?>
         	</table>
       </div>
     </main>
<?php
$banco->close();
require_once("../../footer.php");
 ?>

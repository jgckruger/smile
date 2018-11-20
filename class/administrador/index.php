<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT `idAdmin`, `username`, `email` FROM `administrador` WHERE 1");
 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
       <h2>Administradores</h2>
       <a href="create.php">
         <button type="button" class="btn btn-primary" >Novo Administrador</button>
       </a>
       <br/><br/>
       <div class="table-responsive">
         <table id="tabela" class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Identificador</th>
               <th>Usuário</th>
               <th>Email</th>
               <th>Opções</th>
             </tr>
           </thead>
         	<?php

          while ($row = $resultado->fetch_assoc()) {
            //var_dump($row);
         		echo "<tr>";
         		echo "<td>".$row['idAdmin']."</td>";
         		echo "<td>".$row['username']."</td>";
         		echo "<td>".$row['email']."</td>";
            if($row['username']!=$_SESSION['login']){
            echo "<td><a href=\"edit.php?id=".$row[idAdmin]."\">Edit</a> | <a href=\"delete.php?id=$row[idAdmin]\" onClick=\"return confirm('Tem certeza que deseja apaga a entrada?')\">Apagar</a></td>";
            }else {
              echo "<td><a href=\"edit.php?id=".$row[idAdmin]."\">Edit</a></td>";
            }
          }
         	?>
         	</table>
       </div>
     </main>
<?php
$banco->close();
require_once("../../footer.php");
 ?>

<?php
$title = "Passagens não registradas";
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT * FROM `passagem` WHERE 1 ORDER BY horario DESC");
 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
       <h2>Passagens não registradas</h2>
       <br/><br/>
       <div class="table-responsive">
         <table id="tabela_relatorio" class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Horário</th>
               <th>Tipo da passagem</th>
               <th>Foto interna</th>
               <th>Foto externa</th>
             </tr>
           </thead>

         	<?php

          while ($row = $resultado->fetch_assoc()) {
            //var_dump($row);
            if($row['tipoPassagem']!== "0"){
              echo "<tr>";
              echo "<td>".date('d/m/Y H:i:s',strtotime($row['horario']))."</td>";

            echo "<td>";
              if($row['tipoPassagem'] == "2"){
                echo "Entrada</td>";
              }else if($row['tipoPassagem'] == "3"){
                echo "Saída</td>";
              }
              echo "<td><a href=\"".$row['fotoIN']."\"><img src=\"".$row['fotoIN']."\" height=\"180\" width=\"320\"></a></td>";
              echo "<td><a href=\"".$row['fotoOUT']."\"><img src=\"".$row['fotoOUT']."\" height=\"180\" width=\"320\"></a></td>";
           		//echo "<td><a href=\"edit.php?id=$row[idFuncionario]\">Edit</a> | <a href=\"delete.php?id=$row[idFuncionario]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";

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

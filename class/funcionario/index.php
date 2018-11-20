<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT `idFuncionario`, `nome`, `email`, DATE_FORMAT(`nascimento`,'%d/%m/%Y') AS `nascimento`, cpf FROM `funcionario` WHERE 1  ");
 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
</div>
       <h2>Funcionários</h2>
       <a href="create.php">
         <button type="button" class="btn btn-primary" >Novo Funcionário</button>
       </a>
       <br/><br/>
       <div class="table-responsive">
         <table id="tabela" class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Nome</th>
               <th>Nascimento</th>
               <th>Email</th>
               <th>CPF</th>
               <th>Opções</th>
             </tr>
           </thead>
         	<?php

          while ($row = $resultado->fetch_assoc()) {
            //var_dump($row);
         		echo "<tr>";
         		echo "<td>".$row['nome']."</td>";
         		echo "<td>".$row['nascimento']."</td>";
         		echo "<td>".$row['email']."</td>";
            echo "<td id=\"cpf\">".$row['cpf']."</td>";
         		echo "<td><a href=\"edit.php?id=".$row[idFuncionario]."\">Edit</a> | <a href=\"delete.php?id=$row[idFuncionario]\" onClick=\"return confirm('Tem certeza que deseja apaga a entrada?')\">Apagar</a></td>";
         	}
         	?>
         	</table>
       </div>
     </main>
<?php
$banco->close();
require_once("../../footer.php");
 ?>

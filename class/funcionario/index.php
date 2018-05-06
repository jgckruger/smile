<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT * FROM funcionario WHERE 1");
 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <h2>Funcionários</h2>
       <a href="create.php">
         <button type="button" class="btn btn-primary" >Novo Funcionário</button>
       </a>
       <br/><br/>
       <div class="table-responsive">
         <table class="table table-striped table-sm">
           <thead>
             <tr>
               <th>Nome</th>
               <th>Nascimento</th>
               <th>Email</th>
             </tr>
           </thead>
         	<?php

          while ($row = $resultado->fetch_assoc()) {
            var_dump($row);
         		echo "<tr>";
         		echo "<td>".$row['nome']."</td>";
         		echo "<td>".$row['nascimento']."</td>";
         		echo "<td>".$row['email']."</td>";
         		echo "<td><a href=\"edit.php?id=$row[id]\">Edit</a> | <a href=\"delete.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
         	}
         	?>
         	</table>
       </div>
     </main>
<?php
$banco->close();
require_once("../../footer.php");
 ?>

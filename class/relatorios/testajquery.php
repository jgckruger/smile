<?php
require_once("../../header.php");
require_once("../../db/DBClass.php");
$banco = new DBClass();
$resultado = $banco->query("SELECT * FROM `passagem` WHERE 1 ORDER BY horario DESC");

while ($row = $resultado->fetch_assoc()) {
  $res[] = $row;
}
$json_res = json_encode($res);
 ?>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <h2>Registro das Passagens</h2>
       <br/><br/>
       <div class="table-responsive">
				<table id="example" class="display" width="100%"></table>
       </div>
</main>
<script type="text/javascript" class="init">
var dataSet = ;

$(document).ready(function() {
  $('#example').DataTable( {
    data: dataSet,
    columns: [
      { title: "Name" },
      { title: "Position" },
      { title: "Office" },
      { title: "Extn." },
      { title: "Start date" },
      { title: "Salary" }
    ]
  } );
} );


</script>
<?php
$banco->close();
require_once("../../footer.php");
 ?>


      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="/smile/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
    $(document).ready(function(){
                $('#cpf').mask('000.000.000-00', {reverse: true});
            });
    $(document).ready(function() {
		$.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );    //Formatação com Hora
		//$.fn.dataTable.moment('DD/MM/YYYY');    //Formatação sem Hora
    $('#tabela').DataTable( {
		dom: "<'row'<'col-md-6'l><'col-md-6'Bfr>>" +
"<'row'<'col-md-6'><'col-md-6'>>" +
"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
			"sEmptyTable": "Nenhum registro encontrado",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			"sInfoFiltered": "(Filtrados de _MAX_ registros)",
			"sInfoPostFix": "",
			"sInfoThousands": ".",
			"sLengthMenu": "_MENU_ resultados por página",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado",
			"sSearch": "Pesquisar",
			"oPaginate": {
				"sNext": "Próximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Último"
			},
			"oAria": {
				"sSortAscending": ": Ordenar colunas de forma ascendente",
				"sSortDescending": ": Ordenar colunas de forma descendente"
			}
		}
    } );
} );

    $(document).ready(function() {
	$.fn.dataTable.moment( 'DD/MM/YYYY HH:mm:ss' );
    $('#tabela_relatorio').DataTable( {
		dom: "<'row'<'col-md-6'l><'col-md-6'Bfr>>" +
"<'row'<'col-md-6'><'col-md-6'>>" +
"<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "bLengthChange": true,
		"columnDefs": [
                { "type": "numeric-comma", targets: 3 }
        ],
        "language": {
			"sEmptyTable": "Nenhum registro encontrado",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			"sInfoFiltered": "(Filtrados de _MAX_ registros)",
			"sInfoPostFix": "",
			"sInfoThousands": ".",
			"sLengthMenu": "_MENU_ resultados por página",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado",
			"sSearch": "Pesquisar",
			"oPaginate": {
				"sNext": "Próximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Último"
			},
			"oAria": {
				"sSortAscending": ": Ordenar colunas de forma ascendente",
				"sSortDescending": ": Ordenar colunas de forma descendente"
			}
		}
    } );
} );


    </script>

    <script>window.jQuery || document.write('<script src="/smile/js/4.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="/smile/js/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="/smile/js/4.1/dist/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="/smile/js/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src="/smile/js/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
            data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>
  </body>
</html>

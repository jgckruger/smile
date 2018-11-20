<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Projeto de controle de entrada e saida do NUTEAD - 2018">
    <meta name="author" content="Joao Kruger">
    <link rel="icon" href="/smile/icons/favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/smile/css/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/smile/css/4.1/examples/dashboard/dashboard.css" rel="stylesheet">
    <!-- DataTable -->
    <link href="/smile/css/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script type="text/javascript" language="javascript" src="/smile/js/jquery-3.3.1.js"></script>
  	<script type="text/javascript" language="javascript" src="/smile/js/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="/smile/js/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js "></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/plug-ins/1.10.10/sorting/datetime-moment.js"></script>
	<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet">

  </head>

  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/smile/">NUTEAD</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Buscar" aria-label="Buscar">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" <?php echo isset($_SESSION['login'])? 'href="/smile/logout.php">Sair' : 'href="/smile/login.php">Entrar';?></a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="home"></span>
                  Painel de Controle <span class="sr-only">(current)</span>
                </a>
              </li>
               <?php echo isset($_SESSION['login'])? '
               <li class="nav-item">
                 <a class="nav-link" href="/smile/class/administrador">
                   <span data-feather="users"></span>
                   Administradores
                 </a>
               </li>
              <li class="nav-item">
                <a class="nav-link" href="/smile/class/funcionario">
                  <span data-feather="users"></span>
                  Funcionários
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/smile/class/rfid">
                  <span data-feather="layers"></span>
                  Identificadores RFID
                </a>
              </li>
            </ul>
            ': '';?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Relatórios</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <!--<ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="/smile/class/relatorios/mes.php">
                  <span data-feather="file-text"></span>
                  Mês atual
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Saídas por funcionário
                </a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link" href="/smile/class/relatorios/listapassagem.php">
                  <span data-feather="file-text"></span>
                  Passagens de funcionários
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/smile/class/relatorios/passagemsemregistro.php">
                  <span data-feather="file-text"></span>
                  Passagens não registradas
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/smile/class/relatorios/registrosrfid.php">
                  <span data-feather="file-text"></span>
                  Registros de RFID
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/smile/class/relatorios/horas1.php">
                  <span data-feather="file-text"></span>
                  Horas e pontos no mês
                </a>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="image"></span>
                  Visualização de fotos
                </a>
              </li>-->
            </ul>
          </div>
        </nav>

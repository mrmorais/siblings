﻿<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	
    <title>Bodyfit</title>

    <!-- Bootstrap Core CSS -->
    <link href="public/template/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="public/template/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="public/template/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="public/template/dist/css/sb-admin-2.css" rel="stylesheet">
    
	<!--Freelancer CSS-->
    <link href="public/css/freelancer.css" rel="stylesheet">
    
	<!--Bodyfit CSS-->
    <link href="public/css/style.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="public/template/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="public/template/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script>
	pegarTodos();
	
	function dinamica(){
		var nome = $("#busca-nome").val();
		
		$.ajax({
			type: 'post',
			url: '?/Personal/searchAluno',
			data: { q:nome}
		}).success(function(data) {
			var obj = $.parseJSON(data);
			//console.log(obj);
			var html = "";
			if (obj.length > 0) {
				
			} else {
				html += "<tr>";
				html += "<th colspan='5'>Sem resultados para a busca</th>";
				html += "</tr>";
			}
			
			for (var n = 0; n < obj.length; n++) {
				html+= "<tr class='aluno'>";
				html+= "<td class='info-id' >"+obj[n].id+"</td>";
				html+= "<td>"+obj[n].nome+"</td>";
				html+= "<td>"+obj[n].email+"</td>";
				html+= "<td>"+obj[n].telefone+"</td>";
				html+= "<td>"+obj[n].endereco+"</td>";
				html+= "<td><a href='?/Personal/treino/"+obj[n].id+"' class='btn btn-primary'>Treino</a></td>";
				html+= "<td><a href='javascript:agendarAvaliacao("+obj[n].id+");' class='btn btn-primary'>Agendar avaliação</a></td>";
				html+= "</tr>";
			}
			document.getElementById("resultados").innerHTML = html;
			
			if (nome.length == 0) {
				pegarTodos();
			}
		});
	}
	
	function pegarTodos(){
		$.ajax({
			type: 'post',
			url: '?/Personal/pegarTodos',
			data: { r:"true"}
		}).success(function(data) {
			var obj = $.parseJSON(data);
			//console.log(obj);
			var html = "";
			
			if (obj.length > 0) {
				
			} else {
				html += "<tr>";
				html += "<th colspan='5'>Nenhum aluno cadastrado</th>";
				html += "</tr>";
			}
			
			for (var n = 0; n < obj.length; n++) {
				html+= "<tr class='aluno'>";
				html+= "<td class='info-id' >"+obj[n].id+"</td>";
				html+= "<td>"+obj[n].nome+"</td>";
				html+= "<td>"+obj[n].email+"</td>";
				html+= "<td>"+obj[n].telefone+"</td>";
				html+= "<td>"+obj[n].endereco+"</td>";
				html+= "<td><a href='?/Personal/treino/"+obj[n].id+"' class='btn btn-primary'>Treino</a></td>";
				html+= "<td><a href='javascript:agendarAvaliacao("+obj[n].id+");' class='btn btn-primary'>Agendar avaliação</a></td>";
				html+= "</tr>";
			}
			document.getElementById("resultados").innerHTML = html;
		});
	}
	
	function agendarAvaliacao(id_aluno){
		
		var trsAlunos = document.getElementsByClassName("aluno");
		
		var data = window.prompt("Digite a data da avaliação (dd/mm/aaaa)");
		
		var verificarData = validarData(data);
		if(verificarData){
			for(var i = 0; i < trsAlunos.length; i++){
				var alunoIr = trsAlunos[i];
				
				var id = alunoIr.getElementsByClassName("info-id")[0].textContent;
				var aluno = {"id" : id};
			
				if(aluno.id == id_aluno){
					$.ajax({
						type: 'post',
						url: '?/Personal/agendarAvaliacao',
						data: { z:aluno.id, p:data}
					}).success(function(data) {
						alert("Agendado");
					});
				}
			}
		}else{
			alert("Erro na data");
		}
	}
	
	function validarData( data ) {

			data = data.replace(/[^0-9\/]/g, "");

			var partes = data.split("/");

			if( partes.length != 3 ) return false;

			var dia = partes[0];
			var mes = partes[1];
			var ano = partes[2];

			if( isNaN(dia) || isNaN(mes) || isNaN(ano) ) return false;

			if( mes > 12 || mes < 1 || ano < 1 || dia < 1) return false;

			if( mes == 2 ) {

					maiorDia = ( ( (!(ano % 4)) && (ano % 100) ) || (!(ano % 400)) )? 29: 28;

					if( dia > maiorDia ) return false;

			}else {

					if( mes == 4 || mes == 6 || mes == 9 || mes == 11 ) {

							if( dia > 30 ) return false;
					}else {

							if( dia > 31 ) return false;
					}
			}

			return true;
	}
	
</script>

</head>

<body>


    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="?/Personal/">Bodyfit</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="?/Personal/sair"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php include("menu.php"); ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Minha conta</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-md-12">
						<center><h2>Olá, <?php echo $user->nome." ".$user->sobrenome; ?>!</h2><hr class="star-primary"></center>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 panel">
						<div class="panel-heading">
							<h3>Meus alunos</h3>
						<label>Digite um nome:</label>
						<input type="text" name="nome" id="busca-nome" onkeyup="dinamica()" autocomplete="off">
						</div>
						<div class="panel-body">
							<table class="table">
								<tr>
									<th>ID</th>
									<th>Nome</th>
									<th>Email</th>
									<th>Telefone</th>
									<th>Endereço</th>
									<th></th>
									<th></th>
								</tr>
								<tbody id="resultados">
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div><!-- /.container -->
			<div class="row" id="footer">
				<div class="col-md-12">
				Siblings <?php echo date("Y"); ?>
				</div>
			</div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="public/template/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="public/template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="public/template/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="public/template/bower_components/raphael/raphael-min.js"></script>
    <script src="public/template/bower_components/morrisjs/morris.min.js"></script>
    <script src="public/template/js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="public/template/dist/js/sb-admin-2.js"></script>
	

</body>

</html>

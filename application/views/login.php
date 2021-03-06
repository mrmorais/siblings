<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html><html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bem vindo ao Bodyfit</title>
    <!-- Favicon na aba-->
    <link href="public/img/favicon.ico" rel="shortcut icon" />

    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="public/css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="?/Page">BodyFit</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="?/Page/login">fazer login</a>
                    </li>
                    <li class="page-scroll">
                        <a href="?/Page/cadastro">criar conta</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <?php if($area == "picker") { ?>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="intro-text">
                        <span class="name" style="background: #F39C12;">Login</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
						<div class="col-lg-8 col-lg-offset-2 text-center" style="vertical-align: middle; line-height: 90px;">
							<a href="?/Page/login/aluno" class="btn btn-warning">ALUNO</a>
							<a href="?/Page/login/personal" class="btn btn-warning" >PERSONAL</a>
							<a href="?/Page/login/academia" class="btn btn-warning" >ACADEMIA</a>
						</div>
					</div>
                </div>
            </div>
        </div>
    </header>
    <?php } else { ?>
	<?php
		switch($area) {
			case "aluno":
				$titulo = "ALUNO";
				$action = "?/Page/login/aluno/go";
			break;
			case "personal":
				$titulo = "PERSONAL";
				$action = "?/Page/login/personal/go";
			break;
			case "academia":
				$titulo = "ACADEMIA";
				$action = "?/Page/login/academia/go";
			break;
		}
	?>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="intro-text">
                        <h1><?php echo $titulo; ?></h1>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="intro-text">
						<form class="form" action="<?php echo $action; ?>" method="post">
							<div class="form-group col-lg-6">
								<input type="mail" class="form-control" placeholder="E-mail" name="email">
							</div>
							<div class="form-group col-lg-6">
								<input type="password" class="form-control" placeholder="Senha" name="senha">
							</div>
							<div class="form-group col-lg-6">
								<button class="btn btn-primary form-control">Entrar</button>
							</div>
							<div class="form-group col-lg-6">
								esqueci minha senha
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </header>
	<?php } ?>
    <!-- Cadastro Section -->
    

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Localização</h3>
                        <p>IFRN<br>Apodi, RN 59700-000</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Redes Sociais</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Em breve...</h3>
                        <p>mais informações.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Siblings &copy; BodyFit 2015
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- jQuery -->
    <script src="public/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="public/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="public/js/classie.js"></script>
    <script src="public/js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="public/js/jqBootstrapValidation.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="public/js/freelancer.js"></script>

</body>

</html>

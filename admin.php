<?php

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.html');
    exit;
}

// Define o tempo limite (por exemplo, 30 minutos = 1800 segundos)
$timeout = 1800;

// Verifica o tempo desde o último acesso
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    // Se o tempo limite foi excedido, encerra a sessão
    session_unset();
    session_destroy();
    header('Location: login.html');
    exit;
}

// Atualiza o tempo da última atividade
$_SESSION['LAST_ACTIVITY'] = time();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<div class="container">
		<div id="alert"></d
        <div class="logo" style="display: flex; justify-content: center; align-items: center; height: 20vh;">
            <img src="images/logoadmin.png" style="width: 500px; height: auto; display: block; margin: auto;;">
        </div>
        <div class="mb-3">
            <a href="menu.php">Voltar ao menu principal</a>
        </div>
        <div>
			<h3>Upload de vídeo</h3>
		</div>
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<input type="file" name="arquivo" class="form-control" accept="video/mp4">
			</div>
            <input type="submit" name="Salvar" value="Salvar" class="btn btn-primary" style="background-color: #C20E1A; border-color: #C20E1A;">
        </form>
		<p class="reservado">Todos os direitos reservados @ 2023</p>
		<p class="reservado"></p>
	</div>

	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

$file = !empty($_FILES['arquivo'])? $_FILES['arquivo'] : '';

if(!empty($file)){

	$ext = substr($file['name'], -3);

	if($ext != 'mp4'){
	
		?>
		<script type="text/javascript">
			
			var div = '<div class="alert alert-danger" role="alert">Selecionar vídeo .mp4</div>'

			document.getElementById("alert").innerHTML = div;
			
		</script>
		<?php		 
	
	}else{
		
		move_uploaded_file($file['tmp_name'], 'mp4/video.mp4');
		
		?>
		<script type="text/javascript">
			
			var div = '<div class="alert alert-success" role="alert">Gravado com sucesso!</div>'

			document.getElementById("alert").innerHTML = div;
			
		</script>
		<?php	
	}
}
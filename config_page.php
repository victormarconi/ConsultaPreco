<?php
session_start();

global $config;
include 'config.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newConfig = [
        'dbhost' => $_POST['dbhost'],
        'dbuser' => $_POST['dbuser'],
        'dbpass' => !empty($_POST['dbpass']) ? $_POST['dbpass'] : $config['dbpass'],
        'dbname' => $_POST['dbname'],
        'filialid' => $_POST['filialid'],
        'sqlFile' => 'command.sql',
        'mysqlDir' => $config['mysqlDir']
    ];

    $configContent = "<?php\n\n\$config = " . var_export($newConfig, true) . ";\n";
    file_put_contents('config.php', $configContent);
    $message = "Configurações atualizadas com sucesso!";
    include 'config.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 50px;
        }
        .config-form {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="config-form">
        <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>

        <div class="mb-3">
            <a href="menu.php">Voltar ao menu principal</a>
        </div>

        <form action="config_page.php" method="post" class="border p-4 rounded bg-light">
            <h2 class="mb-4">Configurações</h2>
            <div class="form-group">
                <label for="dbhost">IP:</label>
                <input type="text" class="form-control" id="dbhost" name="dbhost" value="<?php echo $config['dbhost']; ?>">
            </div>
            <div class="form-group">
                <label for="dbuser">Usuário:</label>
                <input type="text" class="form-control" id="dbuser" name="dbuser" value="<?php echo $config['dbuser']; ?>">
            </div>
            <div class="form-group">
                <label for="dbpass">Senha:</label>
                <input type="password" class="form-control" id="dbpass" name="dbpass">
            </div>
            <div class="form-group">
                <label for="dbname">Banco de Dados:</label>
                <input type="text" class="form-control" id="dbname" name="dbname" value="<?php echo $config['dbname']; ?>">
            </div>
            <div class="form-group">
                <label for="filial">Filial:</label>
                <input type="text" class="form-control" id="filialid" name="filialid" value="<?php echo $config['filialid']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

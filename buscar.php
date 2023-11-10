<?php

global $config;
include 'config.php';

$post = $_POST["barras"]; #lendo codigo de barras
$strBar = 13 - strlen($post);
$strPost = strlen($post);
$soma = $strBar + $strPost;
$bar = str_pad($post, $soma, '0', STR_PAD_LEFT); #adicionando 0 a esquerda
$promo = true;
$filial = $config['filialid'];

$descricao = "";

#aqui embaixo dados do servidor
$dbhost = $config['dbhost'];
$dbuser = $config['dbuser'];
$dbpass = $config['dbpass'];
$db     = $config['dbname'];

$file   = 'command.sql'; #nome do arquivo
$mySQLDir= $config['mysqlDir'];
    $out = "";
    $query = "SELECT CONCAT(p.descricao,'|',IF((pf.produto_id IS NULL OR pf.apagado = 'S'), IF(gp.preco_pro < (gp.preco_vnd - (gp.preco_vnd * (gp.desconto / 100))) AND gp.preco_pro > 0 AND gp.valid_pro > CURDATE(), gp.preco_pro, ROUND(gp.preco_vnd - (gp.preco_vnd * (gp.desconto / 100)), 2)), IF(pf.preco_promo < (pf.preco - (pf.preco * (pf.desc_vista / 100))) AND pf.preco > 0 AND pf.final_promocao > CURDATE(), pf.preco_promo, ROUND(pf.preco - (pf.preco * (pf.desc_vista / 100)), 2))),'|')
 FROM produto p
    LEFT JOIN barras b
     ON p.produto_id = b.produto_id
    LEFT JOIN grupo_preco_produto gp
     ON gp.produto_id = p.produto_id
    LEFT JOIN precosfilial pf
        ON pf.produto_id = p.produto_id
        AND pf.filial_id = $filial
    WHERE (b.barras = $bar OR p.barras = $bar) and p.apagado = 'N';";


    file_put_contents("command.sql",$query);
    $cmd = $mySQLDir." -A -h $dbhost --user=$dbuser --password=$dbpass gerente  < $file ";
    exec($cmd,$out ,$retval);

    if (isset($out[1])) {
        $result = explode('|', $out[1]);
        if (isset($result[1]) && $result[1] > 0) {
            $promo = false;
            $descricao = $result[0];
            $preco = str_replace('.', ',', $result[1]);
            $desconto = 0;
            $codigo = $result[2];
        }
}


if ($descricao != "") {
    $retorno = '<p>' . substr($descricao, 0, 100) . '</p>
    <h1>' . $preco . '</h1>';
} else {
    $retorno = '<p>Produto não Encontrado</p>';
}

echo $retorno;
unlink('command.sql');
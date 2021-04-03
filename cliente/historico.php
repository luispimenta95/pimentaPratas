<?php
session_start();
$idCliente = $_SESSION["idCliente"];

include '../BD/.conecta.php';
include '../mensagemPadrao.php';

if (!isset($_SESSION["idCliente"])) {
    header("Location:../loginCliente.php");
}
if ($_SESSION["primeiroAcesso"] == 1) {
    header("Location:primeiroAcesso.php");
}
mysqli_set_charset($conn, 'utf8');
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$pagina_atual = "home.php";
//Selecionar todos os logs da tabela
$pesquisaProdutos = "SELECT nomeProduto from produto p order by p.nomeProduto";
$Produtos = mysqli_query($conn, $pesquisaProdutos);

//Contar o total de logs
$totalProdutos = mysqli_num_rows($Produtos);

//Seta a quantidade de logs por pagina
$quantidade_pg = 30;

//calcular o número de pagina necessárias para apresentar os logs
$num_pagina = ceil($totalProdutos / $quantidade_pg);

//Calcular o inicio da visualizacao
$incio = ($quantidade_pg * $pagina) - $quantidade_pg;

//Selecionar os logs a serem apresentado na página


$resultadoProdutos = mysqli_query($conn, $pesquisaProdutos);
$totalProdutos = mysqli_num_rows($resultadoProdutos);
$pesquisaPedidos = "select idpedido,codPedido,sum(quantidade) as quantidade, pe.preco precoPedido,pe.pedidoFinalizado, nomeProduto, nomeCliente from pedido pe, produto pr, cliente c where idProduto = produto and idCliente = cliente and pedidoFinalizado = 1 and idCliente = " . $_SESSION["idCliente"] . " GROUP BY produto";
$resultadoPedidos = mysqli_query($conn, $pesquisaPedidos);
$totalPedidos = mysqli_num_rows($resultadoPedidos);
echo $totalPedidos;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Legrano Orgânicos</title>
    <link rel="shortcut icon" href="../imagens/icon.jpg" type="image/x-icon" />

</head>

<body>


    <nav class="navbar navbar-expand-sm bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="historico.php">Pedidos</a>
            </li>

        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user"> <?php echo $_SESSION["nomeCliente"] ?></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <form method="POST" action="editarDados.php">
                        <input type="hidden" name="idCliente" value="<?php echo $idCliente ?>">

                        <button type="submit" class="btn btn-default"> <i class="fa fa-pencil">Editar dados</i> </button>
                        </button>

                    </form>
                    <a class="dropdown-item" href="../sairCliente.php">
                        <i class="fa fa-sign-out"> Fazer logout</i>
                    </a>


            </li>

        </ul>
    </nav>
    <?php if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    } ?>
    <div class="col-sm-12">
        <!--Exemplo -->

        <?php if ($totalPedidos > 0) { ?>
            <h4 class="mb-3 text-center">Confira seu historico de pedidos</h4>

        <?php } else { ?>
            <h4 class="mb-3 text-center">Carrinho vazio ! </h4>
        <?php } ?>
    </div> <!-- card.// -->


    <div class="row">
        <?php if ($totalPedidos > 0) { ?>
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Seu carrinho</span>
                    <span class="badge badge-secondary badge-pill"><?php echo $totalPedidos ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php
                    $totalPedido = 0;
                    $somaProduto = 0;
                    while ($row = mysqli_fetch_assoc($resultadoPedidos)) {

                        $somaProduto = $row["precoPedido"] * $row["quantidade"];
                        $totalPedido += $somaProduto;
                    ?>

                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $row["nomeProduto"] ?></h6>
                                <small class="text-muted">Quantidade: <?php echo $row["quantidade"] ?></small>
                            </div>

                            <span class="text-muted">Preço total : R$ <?php echo number_format($somaProduto, 2, ",", "."); ?></span>
                        </li>

                    <?php } ?>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (BRL)</span>
                        <strong>R$ <?php echo number_format($totalPedido, 2, ",", "."); ?></strong>
                    </li>
                </ul>

                <form action="finalizarPedido.php" class="card p-2">
                    <a onclick="return confirm('Deseja realmente finalizar o pedido ?');"> <button type="submit" class="btn btn-secondary">Finalizar pedido</button>
                    </a>
                </form>
            </div>
        <?php } ?>
        <div class="col-md-8 order-md-1">
            <?php if ($totalPedidos > 0) { ?>
                <h4 class="mb-3 text-center">Revise o seu pedido antes de confirmar </h4>

            <?php } else { ?>
                <h4 class="mb-3 text-center">Carrinho vazio ! </h4>
            <?php } ?>
            <?php
            $pesquisa =  "select idpedido,codPedido,sum(quantidade) as quantidade, pe.preco precoPedido,pe.pedidoFinalizado, nomeProduto, nomeCliente from pedido pe, produto pr, cliente c where idProduto = produto and idCliente = cliente and pedidoFinalizado = 1 and idCliente = " . $_SESSION["idCliente"] . " GROUP BY produto";

            //preciso fazer as pesquisas


            $resultado = mysqli_query($conn, $pesquisa);
            $total = mysqli_num_rows($resultado);
            ?>
            <div class="row">

            </div>
        </div>
    </div>



    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
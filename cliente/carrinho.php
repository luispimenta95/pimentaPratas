<?php
session_start();
$idCliente = $_SESSION["idCliente"];

if (!isset($_SESSION["idCliente"])) {
    header("Location:../loginCliente.php");
}
if ($_SESSION["primeiroAcesso"] == 1) {
    header("Location:primeiroAcesso.php");
}
include '../BD/.conecta.php';
include '../mensagemPadrao.php';
$codPedido = $_SESSION["codPedido"];
$pesquisaPedidos = "select idpedido,codPedido,sum(quantidade) as quantidade, pe.preco precoPedido,pe.pedidoFinalizado,
nomeProduto from pedido pe, produto pr, cliente c where 
idProduto = produto and idCliente = cliente and  codPedido = '$codPedido' GROUP BY produto";

$resultadoPedidos = mysqli_query($conn, $pesquisaPedidos);
$totalPedidos = mysqli_num_rows($resultadoPedidos);

?>

<html lang="pt-br">

<head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Legrano Orgânicos</title>
    <link rel="shortcut icon" href="../imagens/icon.jpg" type="image/x-icon" />
</head>

<body class="bg-light">
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
                    <?php if ($totalPedidos == 0) { ?>

                        <a class="dropdown-item" href="../sairCliente.php">
                            <i class="fa fa-sign-out"> Fazer logout</i>
                        </a>
                    <?php } ?>

            </li>

        </ul>
    </nav>
    <?php if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    } ?>
    <div class="container">


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
                        <?php

                        $sql3 = "SELECT precoFrete,nomeCidade FROM cidade ci INNER JOIN cliente cl on cl.cidade = ci.idCidade where cl.idCliente = $idCliente";
                        $result3 = $conn->query($sql3);
                        $cidade = $result3->fetch_assoc();
                        $frete = $cidade["precoFrete"];
                        ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Preço do frete para <?php echo $cidade["nomeCidade"] ?></span>
                            <strong>R$ <?php echo number_format($frete, 2, ",", "."); ?></strong>
                        </li>
                        <?php $totalPedido += $frete; ?>
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
                $pesquisa = "select idpedido,codPedido,quantidade, pe.preco precoPedido,
                nomeProduto,imagem from pedido pe, produto pr, cliente c where 
                idProduto = produto and idCliente = cliente and  codPedido = '$codPedido'";

                //preciso fazer as pesquisas


                $resultado = mysqli_query($conn, $pesquisa);
                $total = mysqli_num_rows($resultado);
                ?>
                <div class="row">
                    <?php
                    while ($linha = mysqli_fetch_assoc($resultado)) {

                    ?>

                        <div class="card col-md-4">
                            <img src="../adm/Imagens_produto/<?php echo $linha["imagem"] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $linha["nomeProduto"] ?></h5>
                                <p class="card-text"><strong> R$ <?php echo number_format($linha["precoPedido"], 2, ",", "."); ?></strong></p>
                                <form action="atualizarPedido.php?id=<?php echo $linha["idpedido"]; ?>" method="POST" class="form-group">

                                    <input type="number" min=0 max=1000 class="form-control" name="contador" value="<?php echo $linha["quantidade"] ?>" />
                                    <button type=" submit" class=" btn btn-success btn-sm">Atualizar quantidade</button>

                                </form>
                                <form action="deletarPedido.php?id=<?php echo $linha["idpedido"]; ?>" method="POST" class="form-group">
                                    <a onclick="return confirm('Deseja realmente excluir o produto do carrinho ?');"> <button type=" submit" class=" btn btn-danger btn-sm">Remover do carrinho</button>
                                    </a>

                                </form>

                            </div>
                        </div>


                    <?php } ?>
                </div>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021 Legrano Orgânicos</p>
        </footer>
    </div>

    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
        // Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido.
        (function() {
            'use strict';

            window.addEventListener('load', function() {
                // Selecione todos os campos que nós queremos aplicar estilos Bootstrap de validação customizados.
                var forms = document.getElementsByClassName('needs-validation');

                // Faz um loop neles e previne envio
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>


</body>

</html>
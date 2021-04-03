<?php
session_start();
$idCliente = $_SESSION["idCliente"];
include '../BD/.conecta.php';
include '../mensagemPadrao.php';
if (!isset($_SESSION["codPedido"])) {
  $_SESSION["codPedido"] = substr(md5(time()), 0, 5);
}
if ($_SESSION["primeiroAcesso"] == 1) {
  header("Location:primeiroAcesso.php");
}
if (!isset($_SESSION["idCliente"])) {
  header("Location:../loginCliente.php");
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
$pesquisa = "";
if (!isset($_POST['termo'])) {
  $pesquisaProdutos = "select 
    idProduto,
    nomeProduto,
    codigo,
    imagem,
    ativo , 
    dataCadastro,
    unidade,
    precoAtacado,
    precoDelivery,
    estoque,
    dataCadastro 
    from 
    produto p order by p.nomeProduto limit $incio, $quantidade_pg";
} else {
  $pesquisa = $_POST["termo"];

  $pesquisaProdutos = "select idProduto, nomeProduto, codigo, imagem, ativo, dataCadastro, unidade, precoAtacado, precoDelivery, estoque 
    from produto p WHERE p.nomeProduto LIKE '%" . $pesquisa . "%'";
}
$resultadoProdutos = mysqli_query($conn, $pesquisaProdutos);
$totalProdutos = mysqli_num_rows($resultadoProdutos);
$codPedido = $_SESSION["codPedido"];
$pesquisaPedidos = "select idpedido,codPedido,sum(quantidade) as quantidade, pe.preco precoPedido,
nomeProduto from pedido pe, produto pr, cliente c where 
idProduto = produto and idCliente = cliente and  codPedido = '$codPedido' GROUP BY produto";
$resultadoPedidos = mysqli_query($conn, $pesquisaPedidos);
$totalPedidos = mysqli_num_rows($resultadoPedidos);



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
          </a>
          <?php if ($totalPedidos == 0) { ?>

            <a class="dropdown-item" href="../sairCliente.php">
              <i class="fa fa-sign-out"> Fazer logout</i>
            </a>
          <?php } ?>

      </li>
      <li class="nav-item">
        <a class="nav-link" href="carrinho.php">
          <i class="fa fa-shopping-cart"> Acessar carrinho de compras</i>

          <span class="badge badge-primary badge-pill">
            <?php echo $totalPedidos ?></span>

        </a>
      </li>
    </ul>
  </nav>
  <?php if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
  } ?>
  <div class="col-sm-12">
    <div class="card">
      <article class="card-group-item">
        <header class="card-header">
          <h6 class="title">Filtrar produtos </h6>
        </header>
        <div class="filter-content">
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <form method="POST" action="produto.php" class="search nav-form">
                  <div class="input-group input-search">
                    <input type="text" class="form-control" name="termo" id="q" placeholder="Pesquisa por nome...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                  </div>
                </form>
              </div>


            </div> <!-- card-body.// -->
          </div>
      </article> <!-- card-group-item.// -->

    </div> <!-- card.// -->
  </div>

  <div class="row">
    <?php



    if ($totalProdutos == 0) {
      $pesquisaProdutos = "select 
        idProduto,
        nomeProduto,
        codigo,
        imagem,
        ativo , 
        dataCadastro,
        unidade,
        precoAtacado,
        precoDelivery,
        estoque,
        dataCadastro 
        from 
        produto p order by p.nomeProduto limit $incio, $quantidade_pg";
      $resultadoProdutos = mysqli_query($conn, $pesquisaProdutos);
      $totalProdutos = mysqli_num_rows($resultadoProdutos);
      $_SESSION["msg"] = $mensagens["semRegistro"];
    }






    while ($row = mysqli_fetch_assoc($resultadoProdutos)) { ?>

      <div class="col-md-4">
        <div class="thumbnail">

          <img src="../adm/Imagens_produto/<?php echo $row["imagem"] ?>" alt="Imagem do produto" style="width:100%">
          <div class="caption">
            <h3 class="text-center"> <?php echo $row['nomeProduto'] . " " . $row['unidade'] ?> </h3>

            <?php if ($_SESSION["tipoCliente"] == 1) { ?>
              <h3 class="text-center"> R$ <?php echo number_format($row["precoAtacado"], 2, ",", "."); ?> </h3>

            <?php } else { ?>

              <h3 class="text-center"> R$ <?php echo number_format($row["precoDelivery"], 2, ",", "."); ?> </h3>
            <?php } ?>
            <br>
            <form action="inserirPedido.php?id=<?php echo $row["idProduto"]; ?>" method="POST" class="form-group">

              <input type="number" min=0 max=1000 class="form-control" name="contador" required />
              <br>
              <button type="submit" class=" btn btn-success btn-sm">Adicionar ao carrinho</button>

            </form>
          </div>
          </a>

        </div>

      </div>



    <?php } ?>
  </div>


  <?php

  $result_log = "SELECT * from produto";

  $Produtos = mysqli_query($conn, $result_log);

  //Contar o total de logs
  $totalProdutos = mysqli_num_rows($Produtos);
  $limitador = 1;
  if ($totalProdutos > $quantidade_pg && $totalProdutos > 0) { ?>
    <nav class="text-center">
      <ul class="pagination">

        <li><a href="home.php?pagina=1"> Primeira página </a></li>


        <?php
        for ($i = $pagina - $limitador; $i <= $pagina - 1; $i++) {
          if ($i >= 1) {
        ?>
            <li><a href="home.php?pagina=<?php echo $i; ?>"> <?php echo $i; ?></a></li>


        <?php }
        }
        ?>
        <li class="active"> <span><?php echo $pagina; ?></span></li>

        <?php
        for ($i = $pagina + 1; $i <= $pagina + $limitador; $i++) {
          if ($i <= $num_pagina) { ?>
            <li><a href="home.php?pagina=<?php echo $i; ?>"> <?php echo $i; ?></a></li>

        <?php }
        }



        ?>
        <li><a href="home.php?pagina=<?php echo $num_pagina; ?>"> <span aria-hidden="true"> Ultima página </span></a></li>



      <?php } ?>
      </ul>
    </nav>


    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
<?php
session_start();
include '../BD/.conecta.php';
include '../mensagemPadrao.php';

if (!isset($_SESSION["idAdministrador"])) {
    header("Location:../login.php");
}
mysqli_set_charset($conn, 'utf8');
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$pagina_atual = "produto.php";
//Selecionar todos os logs da tabela
$pesquisaProdutos = "SELECT nomeProduto from produto pr";
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
if (isset($_POST['todos'])) {
    $pesquisa = "todos";
    $listaTodos = "select 
    idProduto,
    nomeProduto,
    ativo , 
    promocao,
    txDesconto,
    dataCadastro,
    precoProduto,
    estoque,
    nomeCategoria,
    dataCadastro 
    from 
    produto p inner join categoriaProduto c on p.categoriaProduto = c.idCategoria order by p.nomeProduto";
}
if (!isset($_POST['termo'])) {
    $pesquisaProdutos = "select 
    idProduto,
    nomeProduto,
    ativo ,
    promocao,
    txDesconto, 
    dataCadastro,
    precoProduto,
    estoque,
    nomeCategoria,
    dataCadastro 
    from 
    produto p inner join categoriaProduto c on p.categoriaProduto = c.idCategoria order by p.nomeProduto limit $incio, $quantidade_pg";
} else {
    $pesquisa = $_POST["termo"];

    $pesquisaProdutos = "select 
    idProduto,
     nomeProduto,
     ativo,
     promocaos,
    txDesconto,
    dataCadastro,
    precoProduto, 
    estoque,
    nomeCategoria
    from produto p inner join categoriaProduto c on p.categoriaProduto = c.idCategoria
      WHERE p.nomeProduto LIKE '%" . $pesquisa . "%'";
}
if ($pesquisa == "todos") {
    $pesquisaProdutos = $listaTodos;
}


$resultadoProdutos = mysqli_query($conn, $pesquisaProdutos);
$totalProdutos = mysqli_num_rows($resultadoProdutos);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Pimenta pratas</title>
    <link rel="shortcut icon" href="../imagens/icon.jpg" type="image/x-icon" />
</head>

<body>



    <nav class="navbar navbar-expand-sm bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pedido.php">Pedidos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="produto.php">Produtos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="usuario.php">Usuários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cidades.php">Cidades</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../sair.php">
                    <i class="fa fa-sign-out"> Fazer logout</i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-user"> <?php echo $_SESSION["nomeAdministrador"] ?></i>
                </a>
            </li>

        </ul>
    </nav>
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


                            <div class="form-group col-md-12 text-right">
                                <form method="POST" action="relatorioProduto.php" class="search nav-form">
                            </div>

                            <input type="hidden" name="sql" value="<?php echo $pesquisaProdutos ?>">
                            <input type="hidden" name="pg_atual" value="<?php echo $pagina ?>">
                            <input type="hidden" name="total_pg" value="<?php echo $num_pagina ?>">

                            <button type="submit" class="btn btn-primary btn-sm">Gerar relatório </button>


                            </form>

                            <form method="POST" action="produto.php" class="col-md-6 search nav-form">
                                <div class="input-group input-search">
                                    <input type="hidden" name="todos">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"> Listar todos</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div> <!-- card-body.// -->
                </div>
            </article> <!-- card-group-item.// -->

        </div> <!-- card.// -->
    </div>
    <br><br>

    <h3 class="text-center"> Produtos coorporativa </h3>
    <br><br>

    <?php



    if ($totalProdutos == 0) {
        $pesquisaProdutos = "select 
        idProduto,
        nomeProduto,
        ativo ,
        promocao,
        txDesconto, 
        dataCadastro,
        precoProduto,
        estoque,nomeCategoria,
        dataCadastro 
        from 
        produto p inner join categoriaProduto c on p.categoriaProduto = c.idCategoria order by p.nomeProduto limit $incio, $quantidade_pg";
        $resultadoUsuarios = mysqli_query($conn, $pesquisaProdutos);

        $_SESSION["msg"] = $mensagens["semRegistro"];
    }
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }


    ?>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th> Produto</th>
                <th> Categoria do produto</th>
                <th> Preço</th>
                <th> Desconto ativo ? </th>
                <th> Quantidade em estoque</th>

                <th> Situação</th>
                <th> Editar</th>


            </tr>
            </tr>
        </thead>
        <tbody>
            <?php


            while ($row = mysqli_fetch_assoc($resultadoProdutos)) { ?>

                <tr>

                    <th> <?php echo $row["nomeProduto"] ?> </th>

                    <th> <?php echo $row["nomeCategoria"] ?> </th>

                    <th> R$ <?php echo number_format($row["precoProduto"], 2, ",", "."); ?> </th>
                    <?php if ($row["promocao"] == 0) { ?>
                        <th> Não </th>
                    <?php } else {
                        $desconto = $row["precoProduto"] - $row["precoProduto"] * $row["txDesconto"] / 100;


                    ?>
                        <th> Produto com <?php echo $row["txDesconto"] ?> % de desconto custando R$ <?php echo number_format($desconto, 2, ",", "."); ?> </th>

                    <?php } ?>
                    <th> <?php echo $row["estoque"] ?> </th>
                    <?php if ($row["ativo"] == 1) { ?>
                        <th> Produto disponível</th>
                    <?php } else { ?>
                        <th> Produto indisponível</th>

                    <?php } ?>

                    <th>
                        <a href="#edicao<?php echo $row["idProduto"] ?>" data-toggle="modal"><button type='button' class='btn btn-primary btn-sm'><i class="fa fa-pencil"></i> </button></a>
                        <a href="#verGaleria<?php echo $row["idProduto"] ?>" data-toggle="modal"><button type='button' class='btn btn-default btn-sm'><span class='fa fa-camera' aria-hidden='true'></span></button></a>
                        <a href="#novaImagem<?php echo $row["idProduto"] ?>" data-toggle="modal"><button type='button' class='btn btn-default btn-sm'><span class='fa fa-plus' aria-hidden='true'></span></button></a>

                    </th>
                    <div id="verGaleria<?php echo $row["idProduto"] ?>" class="modal fade" role="dialog" class="form-group">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Ver imagens de um produto</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $pesquisaImagens = "SELECT * from imagens i  where i.produto = " . $row["idProduto"];
                                    $imagens = mysqli_query($conn, $pesquisaImagens);

                                    //Contar o total de logs
                                    $totalImagens = mysqli_num_rows($imagens);

                                    if ($totalImagens == 0) {

                                        echo "Não existem imagens cadastradas para essa obra";
                                    }



                                    ?>


                                    <div class="row">

                                        <?php
                                        $result_logs = "SELECT * from imagens i  where i.produto = " . $row["idProduto"];
                                        $resultado_logs = mysqli_query($conn, $result_logs);
                                        $totalImagens = mysqli_num_rows($resultado_logs);
                                        $marcadores = 0;
                                        while ($lista = mysqli_fetch_assoc($resultado_logs)) { ?>
                                            <form action="updateCapa.php?id=<?php echo $row["idProduto"]; ?>" method="POST" enctype="multipart/form-data">

                                                <div class="col-md-4">
                                                    <div>

                                                        <img src="../Imagens/<?php echo $lista["imagem"] ?>" alt="Lights" style="width:100%">
                                                        <div class="caption">
                                                            <?php
                                                            if ($lista["capa"] == 0) { ?>

                                                                <a href="updateCapa.php?id=<?php echo $lista["idImagem"] ?>&&idProduto=<?php echo $row["idProduto"]; ?>"" onclick=" return confirm('Deseja realmente definir como capa ?')"> <button type="button" class="btn btn-primary btn-xs">Definir como capa</button></a>
                                                                <a href="excluirImagem.php?idImagem=<?php echo $lista["idImagem"] ?> " onclick="return confirm('Deseja realmente excluir o registro ?')"><button type="button" class="btn btn-danger btn-xs">Excluir imagem</button></a>
                                                                <?php } else {

                                                                if ($totalImagens > 1 && $lista["capa"] == 0) { ?>
                                                                    <a href="excluirImagem.php?id=<?php echo $lista["idImagem"] ?>"" onclick=" return confirm('Deseja realmente excluir o registro ?')"><button type="button" class="btn btn-danger btn-xs">Excluir imagem</button></a>


                                                                <?php } else { ?>
                                                                    <p> Essa imagem está definida como capa </p>
                                                            <?php }
                                                            } ?>

                                                            <input type="hidden" name="obra" value="<?php echo $row["idProduto"] ?>">
                                                        </div>
                                                        </a>

                                                    </div>

                                                </div>
                                            </form>

                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <button type="submit" class=" btn btn-primary" data-dismiss="modal">Voltar</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <form action="imagemProduto.php?id=<?php echo $row["idProduto"]; ?>" method="POST" enctype="multipart/form-data">


                        <div id="novaImagem<?php echo $row["idProduto"] ?>" class="modal fade" role="dialog" class="form-group">

                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        <h4 class="modal-title">Cadastro de imagens</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">

                                            <input type="file" id="exampleInputEmail1" name="arquivo[]" multiple="multiple" required>

                                        </div>
                                    </div>



                                    <div class="modal-footer">
                                        <button type="submit" class=" btn btn-primary">Realizar cadastro</button>

                                        <button type="submit" class=" btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                    <form action="updateProduto.php?id=<?php echo $row["idProduto"]; ?>" method="POST" class="form-group" enctype="multipart/form-data">

                        <div id="edicao<?php echo $row["idProduto"] ?>" class="modal fade" role="dialog" class="form-group">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <?php
                                        if (isset($_SESSION['msg'])) {
                                            echo $_SESSION['msg'];
                                            unset(
                                                $_SESSION['msg']

                                            );
                                        }
                                        ?>
                                        <h4 class="modal-title">Atualizar produto</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nome" value="<?php echo $row["nomeProduto"] ?>" required>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Preço </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="precoProduto" value="R$ <?php echo number_format($row["precoProduto"], 2, ",", "."); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Quantidade: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="quantidade" value="<?php echo $row["estoque"] ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Variação: </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="variacao" value="<?php echo $row["variacao"] ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row" required>
                                            <label for="inputEmail3" class="col-sm-6 col-form-label">Situação do produto</label>
                                            <div class="col-sm-6">
                                                <label class="radio-inline">
                                                    <input type="radio" name="situacao" value="1" required><span class="label label-success">Disponível</span>
                                                </label>

                                                <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="situacao" value="0" required><span class="label label-danger">Indisponível</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Alterar foto: </label>
                                            <div class="col-sm-9">
                                                <input type="file" id="exampleInputEmail1" name="arquivo">
                                            </div>
                                        </div>




                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class=" btn btn-primary">Realizar alterações</button>

                                        <button type="submit" class=" btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>

                <?php } ?>
                </tr>

        </tbody>
    </table>

    <form action="inserirProduto.php" method="POST" class="form-group" enctype="multipart/form-data">

        <div id="cadastro" class="modal fade" role="dialog" class="form-group">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset(
                                $_SESSION['msg']

                            );
                        }
                        ?>
                        <h4 class="modal-title">Cadastrar produto</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nome" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Categoria do produto </label>
                            <div class="col-sm-10">
                                <select name="categoria" required>
                                    <option>Selecione</option>
                                    <?php

                                    $sql2 = "SELECT * from  categoriaProduto order by nomeCategoria";
                                    $result2 = $conn->query($sql2);

                                    while ($socio2 = $result2->fetch_assoc()) {

                                    ?>
                                        <option value="<?php echo $socio2["idCategoria"]; ?>"><?php echo $socio2["nomeCategoria"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Preço</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="preco" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Estoque: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="quantidade" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Variação: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="variacao" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Inserir foto: </label>
                            <div class="col-sm-9">
                                <input type="file" id="exampleInputEmail1" name="arquivo" required>
                            </div>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="submit" class=" btn btn-primary">Inserir registro</button>

                        <button type="submit" class=" btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>

            </div>
        </div>

    </form>
    <a href="#cadastro" data-toggle="modal"><button type='button' class='btn btn-success'>Cadastrar produto</button></a>

    <?php

    $result_log = "SELECT * from produto";

    $Usuarios = mysqli_query($conn, $result_log);

    //Contar o total de logs
    $totalUsuarios = mysqli_num_rows($Usuarios);
    $limitador = 1;
    if ($totalUsuarios > $quantidade_pg && $totalUsuarios > 0) { ?>
        <nav class="text-center">
            <ul class="pagination">

                <li><a href="produto.php?pagina=1"> Primeira página </a></li>


                <?php
                for ($i = $pagina - $limitador; $i <= $pagina - 1; $i++) {
                    if ($i >= 1) {
                ?>
                        <li><a href="produto.php?pagina=<?php echo $i; ?>"> <?php echo $i; ?></a></li>


                <?php }
                }
                ?>
                <li class="active"> <span><?php echo $pagina; ?></span></li>

                <?php
                for ($i = $pagina + 1; $i <= $pagina + $limitador; $i++) {
                    if ($i <= $num_pagina) { ?>
                        <li><a href="produto.php?pagina=<?php echo $i; ?>"> <?php echo $i; ?></a></li>

                <?php }
                }



                ?>
                <li><a href="produto.php?pagina=<?php echo $num_pagina; ?>"> <span aria-hidden="true"> Ultima página </span></a></li>



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
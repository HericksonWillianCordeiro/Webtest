<?php
   session_start();

    require './config.php';

    if (!empty($_GET['message']) && $_GET['message'] == 'error') {
        echo "<script>alert('Ops, ocorreu um erro ao processar registro!')</script>";
    }

    if (!empty($_GET['error']) && $_GET['error'] == 'required') {
        echo "<script>alert('Ops, campo requirido não informado!')</script>";
    }

    require("actions/conexao.php");

    $conexaoClass = new Conexao();
    $conexao = $conexaoClass->conectar();

    $adm  = $_SESSION["usuario"][1];
    $nome= $_SESSION["usuario"][0];
    $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="style/dashboard.css" />
        <title>Partidas</title>
    </head>
    <body>
         <header>
            <div id="content">
            <div id="user">
                    <span><?php echo $adm ? $nome." (ADM)" : $nome; ?></span>
                </div>
                <span class="logo">Sistema de Partidas</span>
                <div id="logout">
                <?php if($adm): ?> <a href="cadastroPartida.php"><button>Nova Partida</button></a><?php endif; ?>
                    <?php if($adm): ?> <a href="dashboard.php"><button>Dashboard</button></a> <?php endif; ?>
                    <a href="actions/logout.php"><button>Sair</button></a>
                </div>
            </div>
        </header>

        <div id="content">
            <?php ?>
                <div id="tabelaUsuarios">
                    <span class="title">Lista de Partidas</span>

                    <table>
                        <thead>
                            <tr>
                                <td>PARTIDAS</td>
                                <td>CONFIRMADO</td>
                                <td>DATA/HORA DE CRIAÇÃO</td>
                            </tr>                
                        </thead>
                        <tbody>
                            <?php
                                $query = $conn->prepare("SELECT * FROM todos");
                                $query->execute();
                        
                                $users = $query->fetchAll(PDO::FETCH_ASSOC);

                                for($i = 0; $i < sizeof($users); $i++):
                                    $usuarioAtual = $users[$i];
                            ?>
                            <tr>
                                <td><?php echo $usuarioAtual["title"]; ?></td>
                                <td><?php echo $usuarioAtual["checked"]; ?></td>
                                <td><?php echo $usuarioAtual["created_at"]; ?></td>
                            <?php endfor; ?>
                        </tbody>            
                    </table>
                </div>
            <?php ?>
        </div>
    </body>
</html>
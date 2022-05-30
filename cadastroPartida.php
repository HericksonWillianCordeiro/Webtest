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
    $nome = $_SESSION["usuario"][0];
    $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro de Partidas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
<title>Dashboard - <?php echo $nome; ?></title>
    </head>
    <body>
        <header>
            <div id="content">
                <div id="user">
                    <span><?php echo $adm ? $nome." (ADM)" : $nome; ?></span>
                </div>
                <span class="logo">Sistema de Partidas</span>
                <div id="logout">
                    <?php if($adm): ?> <a href="dashboard.php"><button>Dashboard</button></a> <?php endif; ?>
                    <a href="partidas.php"><button>Partidas</button></a>
                    <a href="actions/logout.php"><button>Sair</button></a>
                </div>
            </div>
        </header>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <form action="./actions/store.php" method="POST" autocomplete="off">
                            <div class="d-flex justify-content-between">
                                <input class="form-control mb-2 mr-2" type="text" name="title" placeholder="Agende sua partida agora!" id="inputTodoText"/>
                                <button class="btn btn-primary" type="submit" id="btnAddTodo"><i class="fa fa-plus"></i> Agendar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <?php if ($todos->rowCount() > 0): ?>
                <div class="col-6">
                    <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="card mt-5">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <form action="./actions/update.php" method="POST">
                                        <p <?= $todo['checked'] ? 'style="text-decoration: line-through"' : '' ?>>
                                            <input type="hidden" value="<?= $todo['id']; ?>" name="id">
                                            <input onChange="this.form.submit();" type="checkbox" data-todo-id="<?= $todo['id']; ?>" class="check-box" <?= $todo['checked'] ? 'checked' : '' ?> />
                                            <span class="textTodo"><?= $todo['title']; ?></span>
                                        </p>
                                    </form>
                                    
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-info btnUpdateTodo mr-2" type="button" data-todo-id="<?= $todo['id']; ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <form action="./actions/destroy.php" method="POST">
                                            <input type="hidden" value="<?= $todo['id']; ?>" name="id">
                                            <button class="btn btn-danger destroy-todo mr-2" type="submit" data-todo-id="<?= $todo['id']; ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <small>Criado: <?= date('d/m/Y H:i:s', strtotime($todo['created_at'])); ?></small>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        const btnUpdateTodo = $('.btnUpdateTodo')

        btnUpdateTodo.on('click', function () {
            const todoToUpdate = $(this).parent('div').prev().find('span').text();
            const todoId = $(this).attr('data-todo-id');
            const newTodoText = prompt("Please enter todo", todoToUpdate);
            
            if (newTodoText) {
                const xmlRequest = new XMLHttpRequest();
                const formData = new FormData();

                formData.append('title', newTodoText);
                formData.append('updateTitle', 'true');
                formData.append('id', todoId);

                xmlRequest.addEventListener('load', function(event) {
                    console.log('Deu boa!');
                    window.location.reload();
                });

                xmlRequest.addEventListener('error', function(event) {
                    alert('Deu ruim');
                    window.location.reload();
                });

                xmlRequest.open('POST', './actions/update.php');
                xmlRequest.send(formData);
            }
        });
    </script>
</body>
</html>
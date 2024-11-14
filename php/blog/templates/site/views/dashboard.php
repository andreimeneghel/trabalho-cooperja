<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
}

$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Professores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container-fluid p-0">
        <div class="row m-0" style="min-height: 100vh;">
            <?php include('sidebar.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark">Seja Bem-Vindo!</h1>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-5x mb-3 text-primary"></i>
                                <h5 class="card-title">Alunos</h5>
                                <p class="card-text">Acesse e gerencie os dados dos alunos cadastrados.</p>
                                <a href="/alunos" class="btn btn-dark">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-chalkboard-teacher fa-5x mb-3 text-success"></i>
                                <h5 class="card-title">Turmas</h5>
                                <p class="card-text">Veja as turmas disponíveis e seus detalhes e outras coisas</p>
                                <a href="/turmas" class="btn btn-dark">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-cogs fa-5x mb-3 text-warning"></i>
                                <h5 class="card-title">Configurações</h5>
                                <p class="card-text">Ajuste as configurações da página conforme necessário.</p>
                                <a href="/mudarcadprof" class="btn btn-dark">Acessar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
</body>

</html>
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
    <link rel="stylesheet" href="/templates/site/assets/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="dash container-fluid p-0">
        <div class="row m-0" style="min-height: 100vh;">
            <?php include('sidebar.php'); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="title h2">Seja Bem-Vindo!</h1>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-5x mb-3 text-warning"></i>
                                <h5 class="card-title text-white">Alunos</h5>
                                <p class="card-text text-white">Acesse e gerencie os dados dos alunos cadastrados.</p>
                                <a href="/alunos" class="btn btn-warning">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-chalkboard-teacher fa-5x mb-3 text-warning"></i>
                                <h5 class="card-title text-white">Turmas</h5>
                                <p class="card-text text-white">Veja as turmas disponíveis e seus detalhes e outras coisas</p>
                                <a href="/turmas" class="btn btn-warning">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-cogs fa-5x mb-3 text-warning"></i>
                                <h5 class="card-title text-white">Configurações</h5>
                                <p class="card-text text-white">Ajuste as configurações da página conforme necessário.</p>
                                <a href="/configuracoes" class="btn btn-warning">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="8000">
                        <img src="templates/site/assets/img/vanir/1.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                        <img src="templates/site/assets/img/vanir/2.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="templates/site/assets/img/vanir/3.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="templates/site/assets/img/vanir/4.png" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
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
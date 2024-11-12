<?php
$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";
session_start();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Professores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- Hamburger Button -->
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#">Dashboard</a>
            <div class="d-flex ms-auto">
                <a class="btn btn-outline-light btn-sm" href="<?= $BASE_URL ?>logout.php">Sair</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-lg-2 d-lg-block sidebar collapse">
                <div class="pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <i class="fas fa-home"></i> Página Inicial
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i> Alunos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/turminhas">
                                <i class="fas fa-chalkboard-teacher"></i> Turmas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cogs"></i> Configurações
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark">Seja Bem-Vindo!</h1>
                </div>
                <div class="row g-4 d-flex align-items-stretch">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-5x mb-3 text-primary"></i>
                                <h5 class="card-title">Alunos</h5>
                                <p class="card-text">Acesse e gerencie os dados dos alunos cadastrados.</p>
                                <a href="#" class="btn btn-dark">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-chalkboard-teacher fa-5x mb-3 text-success"></i>
                                <h5 class="card-title">Turmas</h5>
                                <p class="card-text">Veja as turmas disponíveis e seus detalhes e outras coisas</p>
                                <a href="/turminhas" class="btn btn-dark">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-cogs fa-5x mb-3 text-warning"></i>
                                <h5 class="card-title">Configurações</h5>
                                <p class="card-text">Ajuste as configurações da página conforme necessário.</p>
                                <a href="#" class="btn btn-dark">Acessar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</body>

</html>
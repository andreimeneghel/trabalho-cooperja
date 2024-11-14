<?php
session_start();
$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] !== 'professor') {
        header("Location: /");
        exit;
    }
} else {
    header("Location: /");
}

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
            
            <!-- Conteúdo principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="title h2 text-white">Seja Bem-Vindo!</h1>
                </div>

                <div class="content">
                    <!-- Cards de Acesso -->
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
                    </div>
                </div> <!-- Fim da div content -->
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</body>

</html>

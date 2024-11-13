<?php

use sistema\Suporte\Conexao;

try {
    $conn = Conexao::getInstancia();

    // Consulta: Total de matérias
    $stmtMaterias = $conn->query("SELECT COUNT(*) AS total FROM tb_materias");
    $materiasAtivas = $stmtMaterias->fetch()->total;

    // Consulta: Total de faltas (ausências)
    $stmtFaltas = $conn->query("SELECT COUNT(*) AS total FROM tb_notas_presenca WHERE presenca = 0");
    $faltasRegistradas = $stmtFaltas->fetch()->total;

    // Consulta: Média geral dos alunos
    $stmtMedia = $conn->query("SELECT AVG(nota) AS media FROM tb_notas_presenca");
    $mediaGeral = number_format($stmtMedia->fetch()->media, 1);

} catch (Exception $e) {
    die("Erro ao carregar os dados: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Acadêmico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Acadêmico</a>
            <div class="d-flex ms-auto">
                <a class="btn btn-outline-light btn-sm" href="logout.php">Sair</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container-fluid">
        <main class="col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-dark">Painel Acadêmico</h1>
                <p class="text-muted">Bem-vindo! Aqui você pode gerenciar informações acadêmicas como matérias, faltas e notas.</p>
            </div>

            <!-- Destaques Estatísticos -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Matérias Ativas</h5>
                            <p class="display-6 text-primary"><?= $materiasAtivas ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Faltas Registradas</h5>
                            <p class="display-6 text-danger"><?= $faltasRegistradas ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Média Geral</h5>
                            <p class="display-6 text-success"><?= $mediaGeral ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Card -->
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-table fa-5x mb-3 text-primary"></i>
                            <h5 class="card-title">Gerenciar Acadêmicos</h5>
                            <p class="card-text">Acesse uma tabela com todas as matérias, faltas e notas.</p>
                            <a href="/academico/informacoes" class="btn btn-dark">Acessar</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

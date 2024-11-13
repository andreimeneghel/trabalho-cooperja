<?php
session_start();
$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";


if(isset($_SESSION['user_id'])){
    if ($_SESSION['user_role'] !== 'aluno') {
        header("Location: /"); 
        exit;
    }
} else {
    header("Location: /"); 
}

use sistema\Suporte\Conexao;

try {
    $conn = Conexao::getInstancia();

    // ID do usuário logado (você pode obter isso de um session ou outra variável)
    $userId = $_SESSION['user_id'];  // Certifique-se de ter um ID de usuário logado

    // Consulta: Total de matérias do aluno logado (com base na turma do aluno)
    $stmtMaterias = $conn->prepare("
        SELECT COUNT(DISTINCT m.id) AS total 
        FROM tb_materias m
        JOIN tb_turmas t ON m.id = t.tb_materia_id
        JOIN tb_alunos a ON a.tb_turma_id = t.id
        WHERE a.tb_user_id = :user_id
    ");
    $stmtMaterias->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtMaterias->execute();
    $materiasAtivas = $stmtMaterias->fetch()->total;

    // Consulta: Total de faltas (ausências) do aluno logado
    $stmtFaltas = $conn->prepare("
        SELECT COUNT(*) AS total 
        FROM tb_notas_presenca np
        JOIN tb_alunos a ON a.id = np.tb_aluno_id
        WHERE a.tb_user_id = :user_id AND np.presenca = 0
    ");
    $stmtFaltas->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtFaltas->execute();
    $faltasRegistradas = $stmtFaltas->fetch()->total;

    // Consulta: Média geral de notas do aluno logado
    $stmtMedia = $conn->prepare("
        SELECT AVG(np.nota) AS media 
        FROM tb_notas_presenca np
        JOIN tb_alunos a ON a.id = np.tb_aluno_id
        WHERE a.tb_user_id = :user_id
    ");
    $stmtMedia->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmtMedia->execute();
    $mediaGeral = $stmtMedia->fetch()->media;
    $mediaGeral = $mediaGeral !== null ? number_format($mediaGeral, 1) : 0;    

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
    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Dashboard Acadêmico</a>
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
                                <i class="fas fa-graduation-cap"></i> Minhas Notas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-book"></i> Minhas Matérias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chalkboard-teacher"></i> Minha Turma
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/sistema/backend/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-lg-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-dark">Seja Bem-Vindo!</h1>
                    <p class="text-muted">Bem-vindo ao seu painel acadêmico. Acesse suas matérias, notas e outras informações aqui.</p>
                </div>

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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

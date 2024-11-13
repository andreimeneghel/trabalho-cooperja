<?php
session_start();

use sistema\Suporte\Conexao;


$pdo = Conexao::getInstancia();

$stmt = $pdo->prepare("
    SELECT t.id, t.nome 
    FROM tb_turmas t
    INNER JOIN tb_professores p ON t.tb_professor_id = p.id
    WHERE p.tb_user_id = :user_id
");
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

$turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);


$alunos = [];


if (isset($_POST['turma_id']) && !empty($_POST['turma_id'])) {
    $turma_id = $_POST['turma_id'];

    //deoende da turma que bota, ela busca os alunos
    $stmt = $pdo->prepare("SELECT a.id, a.nome FROM tb_alunos a WHERE a.tb_turma_id = :turma_id");
    $stmt->bindParam(':turma_id', $_SESSION['turma_id'], PDO::PARAM_INT);
    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>
<body>
    
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="/dashboard">Voltar</a>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="<?=$BASE_URL?>logout.php">Sair</a>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="mb-4 text-dark">Selecionar Turma e Ver Alunos</h2>
        
        <div class="mb-4">
            <form method="POST" action="">
                <label for="turmaSelect" class="form-label">Selecione uma Turma:</label>
                <select class="form-select" name="turma_id" id="turmaSelect" onchange="this.form.submit()">
                    <option value="">Escolha uma turma...</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= $turma['id'] ?>" <?= (isset($_POST['turma_id']) && $_POST['turma_id'] == $turma['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($turma['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        
        <div id="alunosContainer" class="mt-4">
            <h3 class="text-secondary">Alunos:</h3>
            <ul class="list-group">
                <?php if (!empty($alunos)): ?>
                    <?php foreach ($alunos as $aluno): ?>
                        <li class="list-group-item"><?= htmlspecialchars($aluno['nome']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">Nenhum aluno encontrado para esta turma.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

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
$nome_aluno = '';

if (isset($_GET['turma_id'])) {
    $turma_id = (int) $_GET['turma_id'];


    if (isset($_GET['nome_aluno']) && !empty($_GET['nome_aluno'])) {
        $nome_aluno = $_GET['nome_aluno'];
        $stmt = $pdo->prepare("SELECT a.id, a.nome 
                               FROM tb_alunos a 
                               WHERE a.tb_turma_id = :turma_id 
                               AND a.nome LIKE :nome_aluno");
        $nome_aluno_param = '%' . $nome_aluno . '%'; // Acentuar a busca
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
        $stmt->bindParam(':nome_aluno', $nome_aluno_param, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT a.id, a.nome 
                               FROM tb_alunos a 
                               WHERE a.tb_turma_id = :turma_id");
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
    }
    
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .header-bg {
        background-color: #343a40;
    }
    .header-text {
        font-size: 1.2rem;
    }
    .form-label {
        font-weight: bold;
    }
    .card-container {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .list-group-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 5px;
    }
    .main-container {
        background-color: #343a40; /* Fundo escuro */
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        color: #ffffff; /* Cor do texto dentro do container para branco */
    }

    .search-container {
        margin-bottom: 30px;
    }
    .alunos-container {
        background-color: #ffffff; /* Cor de fundo mais clara para a lista de alunos */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

</head>
<body>
    <header class="navbar navbar-dark sticky-top header-bg flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 header-text" href="/dashboard">Voltar</a>
    </header>

    <div class="container mt-5">
        <h2 class="mb-4 text-dark">Selecionar Turma e Ver Alunos</h2>
        
        <!-- Container com fundo diferente englobando a pesquisa e os alunos -->
        <div class="main-container">
            <div class="search-container">
                <form method="GET" action="" class="d-flex flex-wrap gap-3">
                    <div class="w-100 w-md-auto">
                        <label for="turmaSelect" class="form-label">Selecione uma Turma:</label>
                        <select class="form-select" name="turma_id" id="turmaSelect" onchange="this.form.submit()">
                            <option value="">Escolha uma turma...</option>
                            <?php foreach ($turmas as $turma): ?>
                                <option value="<?= $turma['id']; ?>" <?= isset($_GET['turma_id']) && $_GET['turma_id'] == $turma['id'] ? 'selected' : '' ?>>
                                    <?= $turma['nome']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="w-100 w-md-auto">
                        <label for="nome_aluno" class="form-label">Pesquisar Aluno:</label>
                        <input type="text" class="form-control" name="nome_aluno" id="nome_aluno" value="<?= htmlspecialchars($nome_aluno); ?>" placeholder="Nome do aluno">
                    </div>
                </form>
            </div>

            <div class="alunos-container">
                <h3 class="text-secondary">Alunos:</h3>
                <ul class="list-group list-group-flush" id="alunosList">
                    <?php if (!empty($alunos)): ?>
                        <?php foreach ($alunos as $aluno): ?>
                            <li class="list-group-item"><?= $aluno['nome']; ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">Nenhum aluno encontrado para esta turma.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        $('#nome_aluno').on('input', function() {
            var turmaId = $('#turmaSelect').val();
            var nomeAluno = $(this).val();
            if (turmaId) {
                $.ajax({
                    url: 'seu_arquivo.php',
                    method: 'GET',
                    data: {
                        turma_id: turmaId,
                        nome_aluno: nomeAluno
                    },
                    success: function(response) {
                        $('#alunosList').html(response);
                    }
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



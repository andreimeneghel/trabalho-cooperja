<?php
session_start();

use sistema\Suporte\Conexao;

// Inicializa o banco de dados
$pdo = Conexao::getInstancia();

// Verificar se o usuário está autenticado como professor
if ($_SESSION['user_role'] !== 'professor') {
    die('Acesso restrito! Somente professores podem cadastrar notas e presença.');
}

// Buscar as turmas do professor
$stmt = $pdo->prepare("
    SELECT t.id, t.nome 
    FROM tb_turmas t
    INNER JOIN tb_professores p ON t.tb_professor_id = p.id
    WHERE p.tb_user_id = :user_id
");
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

$turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Se uma turma for selecionada, buscar os alunos dessa turma
if (isset($_GET['turma_id'])) {
    $turma_id = $_GET['turma_id'];

    // Buscar os alunos da turma selecionada
    $stmt = $pdo->prepare("SELECT a.id, a.nome FROM tb_alunos a WHERE a.tb_turma_id = :turma_id");
    $stmt->bindParam(':turma_id', $turma_id);
    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Notas e Presença</title>
    <!-- Link para o CSS do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">Cadastro de Notas e Presença</h1>

    <!-- Formulário para selecionar a turma -->
    <div class="card p-4 mb-4">
        <form action="" method="get">
            <div class="form-group">
                <label for="turma_id">Selecione uma Turma:</label>
                <select name="turma_id" id="turma_id" class="form-control" required>
                    <option value="">Escolha uma turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= $turma['id'] ?>" <?= (isset($_GET['turma_id']) && $_GET['turma_id'] == $turma['id']) ? 'selected' : '' ?>>
                            <?= $turma['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Selecionar</button>
        </form>
    </div>

    <?php if (isset($alunos) && count($alunos) > 0): ?>
        <h2 class="text-center mb-3">Alunos da Turma Selecionada</h2>
        <form action="/sistema/backend/cadastroNotasPresenca.php" method="post" class="card p-4">
            <input type="hidden" name="materia_id" value="<?=$_GET['turma_id']?>">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome do Aluno</th>
                            <th>Presença</th>
                            <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= $aluno['nome'] ?></td>
                                <td class="text-center">
                                    <input type="checkbox" name="presenca[<?= $aluno['id'] ?>]" value="1" class="form-check-input">
                                </td>
                                <td>
                                    <input type="number" name="nota[<?= $aluno['id'] ?>]" min="0" max="10" step="0.01" class="form-control">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-success btn-block">Cadastrar Notas e Presença</button>
        </form>
    <?php elseif (isset($turma_id)): ?>
        <div class="alert alert-warning mt-4" role="alert">
            Não há alunos cadastrados nesta turma ainda.
        </div>
    <?php endif; ?>
</div>

<!-- Scripts do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

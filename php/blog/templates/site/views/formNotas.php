<?php
session_start();

use sistema\Suporte\Conexao;

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

if (isset($_GET['turma_id'])) {
    $turma_id = $_GET['turma_id'];

    // Buscar a matéria associada à turma
    $stmt = $pdo->prepare("
        SELECT m.id, m.nome 
        FROM tb_materias m
        INNER JOIN tb_turmas t ON t.tb_materia_id = m.id
        WHERE t.id = :turma_id
    ");
    $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
    $stmt->execute();
    $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Buscar alunos da turma que têm a matéria
    if (isset($_GET['materia_id'])) {
        $materia_id = $_GET['materia_id'];

        $stmt = $pdo->prepare("
            SELECT a.id, a.nome 
            FROM tb_alunos a
            INNER JOIN tb_turmas t ON a.tb_turma_id = t.id
            WHERE a.tb_turma_id = :turma_id
              AND t.tb_materia_id = :materia_id
        ");
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
        $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
        $stmt->execute();
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Notas e Presença</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">Cadastro de Notas e Presença</h1>

    <div class="card p-4 mb-4">
        <form action="" method="get">
            <div class="form-group">
                <label for="turma_id">Selecione uma Turma:</label>
                <select name="turma_id" id="turma_id" class="form-control" required>
                    <option value="">Escolha uma turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?= htmlspecialchars($turma['id']) ?>" <?= (isset($_GET['turma_id']) && $_GET['turma_id'] == $turma['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($turma['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (isset($materias)): ?>
                <div class="form-group">
                    <label for="materia_id">Selecione uma Matéria:</label>
                    <select name="materia_id" id="materia_id" class="form-control" required>
                        <option value="">Escolha uma Matéria</option>
                        <?php foreach ($materias as $materia): ?>
                            <option value="<?= htmlspecialchars($materia['id']) ?>" <?= (isset($_GET['materia_id']) && $_GET['materia_id'] == $materia['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($materia['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Selecionar</button>
        </form>
    </div>

    <?php if (isset($alunos) && count($alunos) > 0): ?>
        <h2 class="text-center mb-3">Alunos da Turma Selecionada</h2>
        <form action="/sistema/backend/cadastroNotasPresenca.php" method="post" class="card p-4">
            <input type="hidden" name="turma_id" value="<?= htmlspecialchars($_GET['turma_id']) ?>">
            <input type="hidden" name="materia_id" value="<?= htmlspecialchars($_GET['materia_id']) ?>">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome do Aluno</th>
                            <th>Presença</th>
                            <th>Nota</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= htmlspecialchars($aluno['nome']) ?></td>
                                <td class="text-center">
                                    <input type="checkbox" name="presenca[<?= htmlspecialchars($aluno['id']) ?>]" value="1" class="form-check-input">
                                </td>
                                <td>
                                    <input type="number" name="nota[<?= htmlspecialchars($aluno['id']) ?>]" min="0" max="10" step="0.01" class="form-control">
                                </td>
                                <td>
                                    <input name="data"  class="form-control" value="<?= date('d/m/Y');?>" readonly>
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
            Não há alunos cadastrados nesta turma para esta matéria.
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

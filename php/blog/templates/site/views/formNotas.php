<?php
session_start();



require_once '../../../sistema/Suporte/Conexao.php';
use sistema\Suporte\Conexao;

// Inicializa o banco de dados
$pdo = Conexao::getInstancia();

// Buscar as turmas do professor
$stmt = $pdo->prepare("SELECT t.id, t.nome FROM tb_turmas t WHERE t.tb_professor_id = :professor_id");
$stmt->bindParam(':professor_id', $_SESSION['user_id']);
$stmt->execute();
$turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se uma turma for selecionada, buscar os alunos dessa turma
if (isset($_POST['turma_id'])) {
    $turma_id = $_POST['turma_id'];

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
</head>
<body>

<h1>Cadastro de Notas e Presença</h1>

<!-- Formulário para selecionar a turma -->
<form action="formNotas.php" method="post">
    <label for="turma_id">Selecione uma Turma:</label>
    <select name="turma_id" id="turma_id" required>
        <option value="">Escolha uma turma</option>
        <?php foreach ($turmas as $turma): ?>
            <option value="<?= $turma['id'] ?>"><?= $turma['nome'] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Selecionar</button>
</form>

<?php if (isset($alunos) && count($alunos) > 0): ?>
    <h2>Alunos da Turma Selecionada</h2>
    <form action="cadastroNotasPresenca.php" method="post">
        <table border="1">
            <thead>
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
                        <td><input type="checkbox" name="presenca[<?= $aluno['id'] ?>]" value="1"></td>
                        <td><input type="number" name="nota[<?= $aluno['id'] ?>]" min="0" max="10" step="0.01"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Cadastrar Notas e Presença</button>
    </form>
<?php elseif (isset($turma_id)): ?>
    <p>Não há alunos cadastrados nesta turma ainda.</p>
<?php endif; ?>

</body>
</html>
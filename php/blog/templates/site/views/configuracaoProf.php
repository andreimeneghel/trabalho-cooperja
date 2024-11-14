<?php

require __DIR__ . '/../../../sistema/Suporte/Sessao.php';

use Sistema\Suporte\Sessao;
use sistema\Modelo\ProfessoresModelo;
use sistema\Modelo\UsuarioModelo;

$prof = new ProfessoresModelo;
$user = new UsuarioModelo;
$sessao = new Sessao;

$role = $sessao->user_role;
$id = $sessao->user_id;

$dadosProf = $prof->lerTudo($id);

$username = $dadosProf['professor_username'];

// var_dump($dadosProf);
// var_dump($sessao->user_id);
// var_dump($_SESSION);

$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Permissão</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= $_SESSION['flash_message']['type'] ?> alert-dismissible fade show custom-alert" role="alert">
            <?= $_SESSION['flash_message']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>


    <!-- Modal Bootstrap -->
    <div class="modal fade" id="permissionModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModalLabel">Acesso Negado</h5>
                </div>
                <div class="modal-body">
                    você não pode acessar essa página
                </div>
                <div class="modal-footer">
                    <a href="/dashboard" class="btn btn-primary">Ir para o Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <?php if ($dadosProf): ?>
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8"> <!-- Aumentamos a largura da coluna -->
                    <h4 class="text-center mb-4">Detalhes do Professor</h4>
                    <form>
                        <div class="form-group mb-4">
                            <label for="professorNome">Nome:</label>
                            <input type="text" class="form-control form-control-lg" id="professorNome" value="<?= $dadosProf['professor_nome'] ?>" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label for="professorNascimento">Data de Nascimento:</label>
                            <input type="text" class="form-control form-control-lg" id="professorNascimento" value="<?= $dadosProf['professor_nascimento'] ?>" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label for="professorAdmissao">Data de Admissão:</label>
                            <input type="text" class="form-control form-control-lg" id="professorAdmissao" value="<?= $dadosProf['professor_admissao'] ?>" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label for="professorTurmas">Turmas:</label>
                            <input type="text" class="form-control form-control-lg" id="professorTurmas" value="<?= $dadosProf['turmas'] ?>" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label for="professorMaterias">Matérias:</label>
                            <input type="text" class="form-control form-control-lg" id="professorMaterias" value="<?= $dadosProf['materias'] ?>" readonly>
                        </div>

                        <div class="d-flex flex-row justify-content-between">
                            <div class="text-center mt-5">
                                <a href="/dashboard" class="btn btn-primary btn-lg px-5 py-3">Voltar para o Dashboard</a>
                            </div>

                            <div class="text-center mt-5">
                                <button class="btn btn-primary btn-lg px-5 py-3" id="btnAtualizar">Atualizar cadastro</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container mt-5">
            <div class="alert alert-danger text-center">
                <p>Professor não encontrado.</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Modal de Atualização -->
    <div class="modal fade" id="modalAtualizar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAtualizarLabel">Atualizar Cadastro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= $BASE_URL ?>usuarioProfAtualizacao.php" id="formAtualizar" method="POST">
                        <div class="form-group mb-4">
                            <label for="professorUserVerf">Digite seu email para atualizar o cadastro:</label>
                            <input type="email" class="form-control form-control-lg" id="professorUserVerf">
                        </div>

                        <div class="form-group mb-4">
                            <label for="professorUsernameAt">Username (Email):</label>
                            <input type="email" class="form-control form-control-lg" id="professorUsernameAt" name="email" value="<?= $dadosProf['professor_username'] ?>" disabled required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="professorSenhaAt">Senha:</label>
                            <input type="password" class="form-control form-control-lg" id="professorSenhaAt" name="password" placeholder="Digite uma senha nova" disabled required>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const userRole = "<?php echo $role; ?>";

        // Verificação do papel do usuário e exibição do modal
        if (userRole !== 'professor') {
            mostrar();
        }

        function mostrar() {
            const modalPerm = new bootstrap.Modal(document.getElementById('permissionModal'), {
                backdrop: 'static',
                keyboard: false
            });
            modalPerm.show();
        }

        // Formatando as datas após a página carregar
        function formatDate(date) {
            const d = new Date(date);
            return new Intl.DateTimeFormat('pt-BR').format(d); // Formata no formato dd/mm/yyyy
        }

        window.onload = function() {
            const professorNascimento = document.getElementById('professorNascimento');
            const professorAdmissao = document.getElementById('professorAdmissao');

            if (professorNascimento) {
                professorNascimento.value = formatDate(professorNascimento.value);
            }
            if (professorAdmissao) {
                professorAdmissao.value = formatDate(professorAdmissao.value);
            }
        };

        // Abrir modal de atualização
        document.getElementById('btnAtualizar').addEventListener('click', function() {
            event.preventDefault();
            console.log("Botão Atualizar clicado");
            abrirModalAtualizar();
        });

        function abrirModalAtualizar() {
            console.log("Tentando abrir o modal de atualização");
            const modalAtualizar = document.getElementById('modalAtualizar');
            const modal = new bootstrap.Modal(modalAtualizar);
            modal.show();
        }

        document.getElementById("professorUserVerf").addEventListener('input', function() {
            console.log(event.target.value);
            console.log("<?php echo $username; ?>");

            if (event.target.value === "<?php echo $username; ?>") {
                $campoS = document.getElementById("professorSenhaAt").disabled = false;
                $campoU = document.getElementById("professorUsernameAt").disabled = false;
                $campoU = document.getElementById("professorUsernameAt").type = "email";
                $campoUV = document.getElementById("professorUserVerf").disabled = true;
            }
        })

        // Adicionar evento de envio ao formulário
        document.getElementById('formAtualizar').addEventListener('submit', function(event) {
            const professorUserVerf = document.getElementById('professorUserVerf').value.trim();

            // Verifica se o campo está vazio
            if (professorUserVerf === "") {
                event.preventDefault(); // Impede o envio do formulário
                alert("Por favor, preencha o campo de email para atualizar o cadastro.");
            }
        });
    </script>

</body>

</html>
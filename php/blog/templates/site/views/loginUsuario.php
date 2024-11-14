<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] !== 'aluno') {
      header('Location: /dashboard');
    } 
    if(($_SESSION['user_role'] !== 'professor')){
      header('Location: /academico');
    }
  exit;
}

$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <base href="/templates/site/">
  <link rel="icon" href="/assets/img/logocooperja.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/login.css">
  <script src="assets/js/loginUsuario.js"></script>

  <title>Login Cooperja</title>
</head>

<body>

  <section class="background-radial-gradient overflow-hidden">
    <?php if (isset($_SESSION['flash_message'])): ?>
      <div class="alert alert-<?= $_SESSION['flash_message']['type'] ?> alert-dismissible fade show custom-alert" role="alert">
        <?= $_SESSION['flash_message']['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <div class="container px-4 py-5 text-center text-lg-start my-5">
      <div class="row gx-lg-5 align-items-center mb-5">
        <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
          <img src="assets/img/logocooperja.png" alt="Logo Cooperja" id="logo-login" class="img-fluid">
        </div>
        <div class="col-lg-6 position-relative">
          <div class="card bg-glass">
            <div class="card-body px-4 py-5">

              <form action="<?= $BASE_URL ?>login.php" method="POST" id="loginForm">
                <h2 class="text-center mb-4">Login</h2>
                <div class="form-floating mb-4 text-secondary">
                  <input type="email" name="email" class="form-control" placeholder="Email" required />
                  <label for="loginEmail">Email</label>
                </div>
                <div class="form-floating mb-4 text-secondary">
                  <input type="password" name="password" class="form-control" placeholder="Password" required />
                  <label for="loginPassword">Senha</label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-block">Entrar</button>
                  <p class="mt-3">Não tem conta? <a class="text-decoration-none" href="#" onclick="toggleForm(false); return false;">Cadastre-se</a></p>
                </div>
              </form>

              <form action="<?= $BASE_URL ?>cadastro.php" method="POST" id="registerForm" class="d-none">
                <h2 class="text-center mb-4">Criar Conta</h2>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="form-floating">
                      <input type="text" name="nome" class="form-control" placeholder="Nome" required />
                      <label for="registerFirstName">Nome</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div class="form-floating">
                      <input type="text" name="sobrenome" class="form-control" placeholder="Sobrenome" required />
                      <label for="registerLastName">Sobrenome</label>
                    </div>
                  </div>
                </div>
                <div class="form-floating mb-4">
                  <input type="email" name="email" class="form-control" placeholder="Email" required />
                  <label for="registerEmail">Email</label>
                </div>
                <div class="form-floating mb-4">
                  <input type="password" name="password" class="form-control" placeholder="Senha" required />
                  <label for="registerPassword">Senha</label>
                </div>
                <div class="form-floating mb-4">
                  <select name="role" class="form-control" required>
                    <option value="aluno">Aluno</option>
                    <option value="professor">Professor</option>
                  </select>
                  <label for="registerRole">Função</label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-block">Criar Conta</button>
                  <p class="mt-3">Já tem uma conta? <a href="#" class="text-decoration-none" onclick="toggleForm(true); return false;">Entrar</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    function toggleForm(showLogin) {
      const loginForm = document.getElementById('loginForm');
      const registerForm = document.getElementById('registerForm');
      if (showLogin) {
        loginForm.classList.remove('d-none');
        registerForm.classList.add('d-none');
      } else {
        loginForm.classList.add('d-none');
        registerForm.classList.remove('d-none');
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
// Iniciar a sessão 
session_start();

// Redirecionar se o usuário já estiver logado 
if (isset($_SESSION['user_id'])) {
  header('Location: dashboard.php'); // Redireciona para a página de dashboard
  exit;
}

$BASE_URL = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/sistema/backend/";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <link rel="icon" href="../assets/img/logocooperja.ico" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/login.css">

  <script src="../assets/js/loginUsuario.js" defer></script>
  <title>Login Cooperja</title>
</head>

<body>
  <section class="background-radial-gradient overflow-hidden">
    <div class="container px-4 py-5 text-center text-lg-start my-5">
      <div class="row gx-lg-5 align-items-center mb-5">
        <div class="col-lg-6" style="z-index: 10">
          <img src="../assets/img/logocooperja.png" alt="Logo Cooperja" id="logo-login">
        </div>
        <div class="col-lg-6 position-relative">
          <div class="card bg-glass">
            <div class="card-body px-4 py-5">
              <!-- Formulário de Login (NAO INTEGRADO) -->
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

              <!-- Formulário de Cadastro -->
              <form action="<?= $BASE_URL ?>cadastro.php" method="POST" id="registerForm" class="hidden">
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

</body>

</html>
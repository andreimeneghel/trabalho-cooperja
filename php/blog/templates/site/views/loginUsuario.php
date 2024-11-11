<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="../assets/img/logocooperja.ico" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <base href="/templates/site/">
  <link rel="stylesheet" href="assets/css/login.css">
  <script src="assets/js/loginUsuario.js"></script>


  <title>Login Cooperja</title>
</head>
<body>
  <section class="background-radial-gradient overflow-hidden">
    <div class="container px-4 py-5 text-center text-lg-start my-5">
      <div class="row gx-lg-5 align-items-center mb-5">
        <div class="col-lg-6" style="z-index: 10">
          <img src="assets/img/logocooperja.png" alt="Logo Cooperja" id="logo-login">
        </div>
        <div class="col-lg-6 position-relative">
          <div class="card bg-glass">
            <div class="card-body px-4 py-5">
              
              <!-- Login Form -->
              <form id="loginForm">
                <h2 class="text-center mb-4">Login</h2>
                <div class="form-floating mb-4 text-secondary">
                  <input type="email" id="loginEmail" class="form-control" placeholder="Email address" required />
                  <label for="loginEmail">Email</label>
                </div>
                <div class="form-floating mb-4 text-secondary">
                  <input type="password" id="loginPassword" class="form-control" placeholder="Password" required />
                  <label for="loginPassword">Senha</label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-block">Entrar</button>
                  <p class="mt-3">Não tem conta? <a class="text-decoration-none" href="#" onclick="toggleForm(false); return false;">Cadastre-se</a></p>
                </div>
              </form>

              <!-- Register Form -->
              <form id="registerForm" class="hidden" >
                <h2 class="text-center mb-4">Criar Conta</h2>
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="registerFirstName" placeholder="First name" required />
                      <label for="registerFirstName">Nome</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="registerLastName" placeholder="Last name" required />
                      <label for="registerLastName">Sobrenome</label>
                    </div>
                  </div>
                </div>
                <div class="form-floating mb-4">
                  <input type="email" id="registerEmail" class="form-control" placeholder="Email address" required />
                  <label for="registerEmail">Email</label>
                </div>
                <div class="form-floating mb-4">
                  <input type="password" id="registerPassword" class="form-control" placeholder="Password" required />
                  <label for="registerPassword">Senha</label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-block">Criar conta</button>
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

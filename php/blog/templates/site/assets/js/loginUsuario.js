function toggleForm(isLogin) {
    document.getElementById('registerForm').classList.toggle('hidden', isLogin);
    document.getElementById('loginForm').classList.toggle('hidden', !isLogin);
  }

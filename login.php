<?php
session_start();
require_once 'config/bootstrap.php';

if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    exit;
}

$pageTitle = 'Login — EcoMarket';
$bodyClass = 'page-auth';
$navActive = 'login';
$extraStyles = [];
require_once 'includes/head.php';
?>

<div class="auth-layout">
    <div class="auth-panel">
        <div class="auth-panel__brand">
            <a href="index.php">
                <img src="assets/logo.svg" alt="EcoMarket" width="56" height="56">
            </a>
            <h1>Área do produtor</h1>
            <p>Acesse seu painel para gerenciar commodities</p>
        </div>

        <form class="login-form" id="loginForm" method="post" action="javascript:void(0);">
            <div id="login-message" class="alert" style="display:none;"></div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="seu@email.com" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn--primary btn--block btn--lg">Entrar</button>
        </form>

        <p class="auth-panel__footer">
            Não tem conta? <a href="cadastrarUsuario.php"><strong>Cadastre-se como produtor</strong></a>
        </p>
        <p class="auth-panel__footer" style="margin-top:0.75rem;">
            <a href="index.php">← Voltar à vitrine</a>
        </p>
    </div>
</div>

<script src="script/login.js"></script>
<script>
document.getElementById('login-message').style.display = 'none';
</script>
</body>
</html>

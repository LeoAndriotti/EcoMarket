<?php
require_once 'config/bootstrap.php';
require_once './classes/DataBase.php';
require_once './classes/Usuario.php';

$db = DataBase::getConnection();
$usuario = new Usuario($db);
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];

    if (
        strlen($senha) < 8 ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[\W_]/', $senha)
    ) {
        $mensagem = '<div class="alert alert--error">A senha deve ter pelo menos 8 caracteres, uma letra maiúscula e um caractere especial.</div>';
    } elseif (!preg_match('/^\d{10,11}$/', $telefone)) {
        $mensagem = '<div class="alert alert--error">O telefone deve conter apenas números e ter 10 ou 11 dígitos.</div>';
    } elseif ($usuario->criar($nome, $email, $senha, $telefone)) {
        header('Location: index.php');
        exit;
    } else {
        $mensagem = '<div class="alert alert--error">Erro ao cadastrar. Verifique se o e-mail já está em uso.</div>';
    }
}

$pageTitle = 'Cadastro de produtor — EcoMarket';
$bodyClass = 'page-auth';
require_once 'includes/head.php';
?>

<div class="auth-layout">
    <div class="auth-panel">
        <div class="auth-panel__brand">
            <a href="index.php"><img src="assets/logo.svg" alt="EcoMarket" width="56" height="56"></a>
            <h1>Cadastro de produtor</h1>
            <p>Publique commodities na vitrine do EcoMarket</p>
        </div>

        <?php echo $mensagem; ?>

        <form method="POST" id="form-cadastro">
            <div class="form-group">
                <label for="nome">Nome completo</label>
                <input type="text" class="form-control" name="nome" id="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone (somente números)</label>
                <input type="tel" class="form-control" name="telefone" id="telefone" maxlength="11" required>
                <small id="erro-telefone" class="alert alert--error" style="display:none;margin-top:0.5rem;">Telefone inválido (10 ou 11 dígitos).</small>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" id="senha" required>
                <small style="color:var(--color-text-muted);font-size:0.8rem;">Mín. 8 caracteres, 1 maiúscula e 1 especial</small>
            </div>
            <button type="submit" class="btn btn--primary btn--block btn--lg">Criar conta</button>
        </form>

        <p class="auth-panel__footer">
            Já tem conta? <a href="login.php"><strong>Fazer login</strong></a>
        </p>
    </div>
</div>

<script>
document.getElementById('form-cadastro').addEventListener('submit', function (e) {
    const senha = document.getElementById('senha').value;
    const telefone = document.getElementById('telefone').value;
    const erroTelefone = document.getElementById('erro-telefone');
    erroTelefone.style.display = 'none';
    if (senha.length < 8 || !/[A-Z]/.test(senha) || !/[\W_]/.test(senha)) {
        alert('A senha deve ter pelo menos 8 caracteres, uma letra maiúscula e um caractere especial.');
        e.preventDefault();
        return;
    }
    if (!/^\d{10,11}$/.test(telefone)) {
        erroTelefone.style.display = 'block';
        e.preventDefault();
    }
});
</script>
</body>
</html>

<?php
require_once 'config/bootstrap.php';
require_once './classes/DataBase.php';
require_once './classes/Usuario.php';

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$db = DataBase::getConnection();
$usuario = new Usuario($db);
$mensagem = '';
$dadosUsuario = $usuario->buscarPorId($_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';

    if (!preg_match('/^\d{10,11}$/', $telefone)) {
        $mensagem = '<div class="alert alert--error">O telefone deve conter 10 ou 11 dígitos numéricos.</div>';
    } elseif (!empty($nova_senha)) {
        if (strlen($nova_senha) < 8 || !preg_match('/[A-Z]/', $nova_senha) || !preg_match('/[\W_]/', $nova_senha)) {
            $mensagem = '<div class="alert alert--error">A nova senha deve ter 8+ caracteres, uma maiúscula e um especial.</div>';
        } elseif (!$usuario->verificarSenha($_SESSION['id'], $senha_atual)) {
            $mensagem = '<div class="alert alert--error">Senha atual incorreta.</div>';
        } elseif ($usuario->atualizar($_SESSION['id'], $nome, $email, $nova_senha, $telefone)) {
            $mensagem = '<div class="alert alert--success">Dados atualizados com sucesso.</div>';
            $dadosUsuario = $usuario->buscarPorId($_SESSION['id']);
            $_SESSION['nome'] = $dadosUsuario['nome'];
        } else {
            $mensagem = '<div class="alert alert--error">Erro ao atualizar dados.</div>';
        }
    } elseif ($usuario->atualizar($_SESSION['id'], $nome, $email, $dadosUsuario['senha'], $telefone)) {
        $mensagem = '<div class="alert alert--success">Dados atualizados com sucesso.</div>';
        $dadosUsuario = $usuario->buscarPorId($_SESSION['id']);
        $_SESSION['nome'] = $dadosUsuario['nome'];
    } else {
        $mensagem = '<div class="alert alert--error">Erro ao atualizar dados.</div>';
    }
}

$pageTitle = 'Editar perfil — EcoMarket';
$bodyClass = 'page-form';
$navActive = 'dashboard';
require_once 'includes/head.php';
require_once 'includes/navbar.php';
?>

<main class="page-wrap">
    <div class="container container--narrow">
        <div class="form-card">
            <h1>Editar perfil</h1>
            <p class="subtitle">Dados da conta do produtor</p>
            <?php echo $mensagem; ?>
            <form method="POST" id="form-alterar">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="nome" id="nome" value="<?php echo htmlspecialchars($dadosUsuario['nome'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($dadosUsuario['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" class="form-control" name="telefone" id="telefone" maxlength="11" value="<?php echo htmlspecialchars($dadosUsuario['telefone'] ?? ''); ?>" required>
                    <small id="erro-telefone" class="alert alert--error" style="display:none;margin-top:0.5rem;">Telefone inválido.</small>
                </div>
                <hr style="border:none;border-top:1px solid var(--color-border);margin:1.5rem 0;">
                <p style="font-weight:600;color:var(--color-primary);margin-bottom:1rem;">Alterar senha (opcional)</p>
                <div class="form-group">
                    <label for="senha_atual">Senha atual</label>
                    <input type="password" class="form-control" name="senha_atual" id="senha_atual">
                </div>
                <div class="form-group">
                    <label for="nova_senha">Nova senha</label>
                    <input type="password" class="form-control" name="nova_senha" id="nova_senha">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Salvar</button>
                    <a href="dashboard.php" class="btn btn--ghost">Voltar</a>
                </div>
            </form>
            <hr style="border:none;border-top:1px solid var(--color-border);margin:2rem 0 1rem;">
            <p style="font-size:0.875rem;color:var(--color-text-muted);text-align:center;margin-bottom:0.75rem;">Zona de perigo</p>
            <button type="button" class="btn btn--danger btn--block" id="btn-excluir">Excluir minha conta</button>
        </div>
    </div>
</main>

<script>
document.getElementById('form-alterar').addEventListener('submit', function (e) {
    const tel = document.getElementById('telefone').value;
    const err = document.getElementById('erro-telefone');
    err.style.display = 'none';
    if (!/^\d{10,11}$/.test(tel)) { err.style.display = 'block'; e.preventDefault(); }
});
document.getElementById('telefone').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 11);
});
document.getElementById('btn-excluir').addEventListener('click', function () {
    if (confirm('Excluir sua conta permanentemente?') && confirm('Esta ação é irreversível. Confirmar?')) {
        window.location.href = 'deletarUsuario.php';
    }
});
</script>
<?php require_once 'includes/footer.php'; ?>

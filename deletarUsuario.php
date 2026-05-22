<?php
require_once 'config/bootstrap.php';
require_once './classes/DataBase.php';

session_start();
$db = DataBase::getConnection();
$mensagem = '';

if (!isset($_SESSION['id'])) {
    $mensagem = '<div class="alert alert--error">Nenhum usuário logado.</div>';
} else {
    $id = (int) $_SESSION['id'];
    if ($id > 0 && !isset($_POST['confirmar'])) {
        $mensagem = '<form method="POST"><p style="margin-bottom:1rem;">Confirma a exclusão permanente da sua conta e de todos os produtos vinculados?</p><input type="hidden" name="confirmar" value="1"><button type="submit" class="btn btn--danger btn--block">Sim, excluir conta</button></form>';
    } elseif ($id > 0) {
        $stmt = $db->prepare('DELETE FROM tbproduto WHERE id_usuario = ?');
        $stmt->execute([$id]);
        $stmt = $db->prepare('DELETE FROM tbusu WHERE id = ?');
        if ($stmt->execute([$id])) {
            session_destroy();
            header('Location: index.php');
            exit;
        }
        $mensagem = '<div class="alert alert--error">Erro ao excluir usuário.</div>';
    }
}

$pageTitle = 'Excluir conta — EcoMarket';
$bodyClass = 'page-auth';
require_once 'includes/head.php';
?>

<div class="auth-layout">
    <div class="auth-panel">
        <h1 style="text-align:center;color:var(--color-error);font-size:1.25rem;">Excluir conta</h1>
        <?php echo $mensagem; ?>
        <p style="text-align:center;margin-top:1rem;"><a href="dashboard.php">Cancelar</a></p>
    </div>
</div>
</body>
</html>

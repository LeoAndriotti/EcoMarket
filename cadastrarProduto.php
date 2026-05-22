<?php
session_start();
require_once 'config/bootstrap.php';

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

include_once './classes/DataBase.php';
include_once './classes/Produto.php';
include_once './classes/Categoria.php';

$db = DataBase::getConnection();
$listaCategorias = Categoria::buscarTodas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = new Produto($db);
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = str_replace(',', '.', $_POST['preco'] ?? '');
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_VALIDATE_INT);

    if (!$nome || !$descricao || !is_numeric($preco) || !$categoria) {
        $erro = 'Preencha todos os campos corretamente.';
    } else {
        $imagemNome = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $pastaDestino = 'uploads/';
            if (!is_dir($pastaDestino)) mkdir($pastaDestino, 0755, true);
            $novoNome = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($_FILES['imagem']['name']));
            $caminhoCompleto = $pastaDestino . $novoNome;
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
                $imagemNome = $caminhoCompleto;
            }
        }
        if ($produto->criar($nome, $descricao, $preco, $categoria, $imagemNome)) {
            header('Location: dashboard.php?msg=criado');
            exit;
        }
        $erro = 'Erro ao cadastrar o produto.';
    }
}

$pageTitle = 'Cadastrar commodity — EcoMarket';
$bodyClass = 'page-form';
$navActive = 'dashboard';
require_once 'includes/head.php';
require_once 'includes/navbar.php';
?>

<main class="page-wrap">
    <div class="container container--narrow">
        <div class="form-card">
            <h1>Nova commodity</h1>
            <p class="subtitle">Publique uma oferta na vitrine do marketplace</p>

            <?php if (!empty($erro)): ?>
                <div class="alert alert--error"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" data-preco>
                <div class="form-group">
                    <label for="nome">Nome do produto</label>
                    <input type="text" class="form-control" name="nome" id="nome" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" name="descricao" id="descricao" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="preco">Preço (R$)</label>
                    <input type="text" class="form-control" name="preco" id="preco" placeholder="0,00" onkeypress="return validarPreco(event)" oninput="formatarPreco(this)" required>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select class="form-control" name="categoria" id="categoria" required>
                        <option value="">Selecione</option>
                        <?php foreach ($listaCategorias as $cat): ?>
                            <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->nome); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="imagem">Imagem (opcional)</label>
                    <input type="file" class="form-control" name="imagem" id="imagem" accept="image/*">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Cadastrar</button>
                    <a href="dashboard.php" class="btn btn--ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once 'includes/preco-script.php'; require_once 'includes/footer.php'; ?>

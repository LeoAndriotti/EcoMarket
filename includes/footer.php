<footer class="site-footer">
    <div class="site-footer__grid">
        <div class="site-footer__brand">
            <img src="assets/logo.svg" alt="" width="36" height="36">
            <div>
                <strong>EcoMarket</strong>
                <p>Plataforma B2B para negociação de grãos, oleaginosas e insumos do agronegócio brasileiro.</p>
            </div>
        </div>
        <div>
            <h4>Plataforma</h4>
            <ul>
                <li><a href="index.php">Vitrine de ofertas</a></li>
                <li><a href="login.php">Área do produtor</a></li>
                <li><a href="cadastrarUsuario.php">Cadastrar produtor</a></li>
            </ul>
        </div>
        <div>
            <h4>Institucional</h4>
            <ul>
                <li><a href="sobre.php">Sobre nós</a></li>
                <li><a href="contato.php">Fale conosco</a></li>
            </ul>
        </div>
        <div>
            <h4>Contato</h4>
            <ul class="site-footer__contact">
                <li>contato@ecomarket.com.br</li>
                <li>(51) 3000-0000</li>
                <li>Porto Alegre — RS</li>
            </ul>
            <h4 style="margin-top:1.25rem;">Desenvolvedor</h4>
            <?php require __DIR__ . '/social-links.php'; ?>
        </div>
    </div>
    <div class="site-footer__bottom">
        <span>&copy; <?php echo date('Y'); ?> EcoMarket. Todos os direitos reservados.</span>
    </div>
</footer>
<script src="script/app.js" defer></script>

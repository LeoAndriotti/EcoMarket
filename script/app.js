(function () {
    'use strict';

    function openModal(id) {
        var el = document.getElementById(id);
        if (el) {
            el.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        var el = document.getElementById(id);
        if (el) {
            el.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    }

    window.abrirFormulario = function () {
        openModal('modalFormulario');
    };

    window.fecharModal = closeModal;

    window.abrirModalProduto = function (produto) {
        window._produtoAtual = produto;
        var titulo = document.getElementById('produtoTitulo');
        var conteudo = document.getElementById('produtoConteudo');
        if (!titulo || !conteudo) return;

        var preco = parseFloat(produto.preco);
        var precoFmt = isNaN(preco)
            ? produto.preco
            : preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        titulo.textContent = produto.nome;
        conteudo.innerHTML =
            '<img class="product-modal__img" src="' +
            (produto.imagem || 'uploads/placeholder.svg') +
            '" alt="">' +
            '<dl class="product-modal__meta">' +
            '<div><dt>Descrição</dt><dd>' +
            escapeHtml(produto.descricao) +
            '</dd></div>' +
            '<div><dt>Preço</dt><dd class="product-modal__price">' +
            precoFmt +
            '</dd></div>' +
            '<div><dt>Categoria</dt><dd><span class="badge">' +
            escapeHtml(produto.categoria) +
            '</span></dd></div>' +
            '</dl>' +
            '<button type="button" class="btn btn--primary btn--block" onclick="comprarProduto()">Solicitar cotação via WhatsApp</button>';

        openModal('modalProduto');
    };

    window._produtoAtual = null;

    window.comprarProduto = function () {
        var p = window._produtoAtual;
        if (p) {
            var preco = parseFloat(p.preco);
            var precoStr = isNaN(preco)
                ? p.preco
                : preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            var msg =
                'Olá! Gostaria de solicitar cotação para: *' +
                p.nome +
                '*%0A%0ADescrição: ' +
                p.descricao +
                '%0APreço: ' +
                precoStr +
                '%0ACategoria: ' +
                p.categoria;
            window.open('https://wa.me/5511999999999?text=' + msg, '_blank');
        } else {
            alert('Obrigado pelo interesse! Nossa equipe entrará em contato em breve.');
        }
        closeModal('modalProduto');
    };

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('is-open');
                document.body.style.overflow = '';
            }
        });
    });

    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.querySelector('.site-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            nav.classList.toggle('is-open');
        });
    }

    var formContato = document.getElementById('formContato');
    if (formContato) {
        formContato.addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Mensagem recebida! Nossa equipe entrará em contato em breve.');
            formContato.reset();
            closeModal('modalFormulario');
        });
    }
})();

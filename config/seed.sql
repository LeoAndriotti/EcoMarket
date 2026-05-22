-- EcoMarket Agro - dados de exemplo (UTF-8)
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecomarket;

ALTER DATABASE ecomarket CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE tbusu CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE tbCategorias CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE tbproduto CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

SET @senha_demo = '$2y$10$Q3dTdCZ55gB2XSVVrdYtlOJOYtq5op9iIh6o1LHOaKnRILJhr94mi';

UPDATE tbusu SET
  nome = 'Cooperativa Grãos do Sul',
  telefone = '51999887766'
WHERE email = 'maria.silva@ecomarket.demo';

UPDATE tbusu SET
  nome = 'Fazenda Boa Esperança',
  telefone = '44988776655'
WHERE email = 'joao.santos@ecomarket.demo';

UPDATE tbusu SET
  nome = 'Agro Santa Clara',
  telefone = '62977665544'
WHERE email = 'ana.costa@ecomarket.demo';

UPDATE tbusu SET
  nome = 'Fazenda São José',
  telefone = '67966554433'
WHERE email = 'contato@fazendaverde.demo';

UPDATE tbusu SET
  nome = 'Cooperativa Campo Verde',
  telefone = '54955443322'
WHERE email = 'cooperativa@raiz.demo';

INSERT IGNORE INTO tbusu (nome, email, senha, telefone) VALUES
('Cooperativa Grãos do Sul', 'maria.silva@ecomarket.demo', @senha_demo, '51999887766'),
('Fazenda Boa Esperança', 'joao.santos@ecomarket.demo', @senha_demo, '44988776655'),
('Agro Santa Clara', 'ana.costa@ecomarket.demo', @senha_demo, '62977665544'),
('Fazenda São José', 'contato@fazendaverde.demo', @senha_demo, '67966554433'),
('Cooperativa Campo Verde', 'cooperativa@raiz.demo', @senha_demo, '54955443322');

DELETE FROM tbproduto;
DELETE FROM tbCategorias;

INSERT INTO tbCategorias (nome) VALUES
('Grãos'),
('Oleaginosas'),
('Leguminosas'),
('Fibra e Café'),
('Sementes');

INSERT INTO tbproduto (nome, descricao, preco, categoria, link_img, id_usuario) VALUES
('Soja em grão - saca 60kg', 'Soja tipo exportação, umidade controlada, pronta para comercialização.', '118.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Grãos'), 'uploads/soja.svg',
 (SELECT id FROM tbusu WHERE email = 'maria.silva@ecomarket.demo')),
('Trigo - saca 60kg', 'Trigo panificável, safra atual, origem cooperativa certificada.', '95.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Grãos'), 'uploads/trigo.svg',
 (SELECT id FROM tbusu WHERE email = 'maria.silva@ecomarket.demo')),
('Milho - saca 60kg', 'Milho grão convencional, alto rendimento, ideal para ração e mercado.', '72.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Grãos'), 'uploads/milho.svg',
 (SELECT id FROM tbusu WHERE email = 'joao.santos@ecomarket.demo')),
('Arroz em casca - saca 50kg', 'Arroz irrigado, grão longo fino, colheita recente.', '88.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Grãos'), 'uploads/arroz.svg',
 (SELECT id FROM tbusu WHERE email = 'joao.santos@ecomarket.demo')),
('Aveia - saca 50kg', 'Aveia branca para nutrição animal e indústria alimentícia.', '102.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Grãos'), 'uploads/aveia.svg',
 (SELECT id FROM tbusu WHERE email = '2001leomoura@gmail.com')),

('Girassol - saca 40kg', 'Semente de girassol para extração de óleo e ração.', '145.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Oleaginosas'), 'uploads/girassol.svg',
 (SELECT id FROM tbusu WHERE email = 'ana.costa@ecomarket.demo')),
('Amendoim em casca - saca 25kg', 'Amendoim tipo runner, qualidade para indústria.', '210.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Oleaginosas'), 'uploads/amendoim.svg',
 (SELECT id FROM tbusu WHERE email = 'ana.costa@ecomarket.demo')),
('Soja para esmagamento', 'Soja com teor de óleo elevado, lote para indústria.', '122.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Oleaginosas'), 'uploads/soja.svg',
 (SELECT id FROM tbusu WHERE email = 'contato@fazendaverde.demo')),

('Feijão carioca - saca 60kg', 'Feijão tipo 1, peneira padrão, safra irrigada.', '285.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Leguminosas'), 'uploads/feijao.svg',
 (SELECT id FROM tbusu WHERE email = 'cooperativa@raiz.demo')),
('Feijão preto - saca 60kg', 'Feijão preto premium para mercado interno.', '310.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Leguminosas'), 'uploads/feijao.svg',
 (SELECT id FROM tbusu WHERE email = 'cooperativa@raiz.demo')),
('Centeio - saca 50kg', 'Centeio para cobertura de solo e nutrição animal.', '78.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Leguminosas'), 'uploads/centeio.svg',
 (SELECT id FROM tbusu WHERE email = '2001leomoura@gmail.com')),

('Café arábica - saca 60kg', 'Café beneficiado, pontuação acima de 80, origem Cerrado.', '980.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Fibra e Café'), 'uploads/cafe.svg',
 (SELECT id FROM tbusu WHERE email = 'contato@fazendaverde.demo')),
('Algodão em pluma - fardo', 'Algodão pluma tipo 41-4, umidade e impureza dentro do padrão.', '4200.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Fibra e Café'), 'uploads/algodao.svg',
 (SELECT id FROM tbusu WHERE email = 'maria.silva@ecomarket.demo')),
('Cana-de-açúcar - tonelada', 'Cana para usina, ATR estimado acima da média regional.', '85.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Fibra e Café'), 'uploads/cana.svg',
 (SELECT id FROM tbusu WHERE email = 'joao.santos@ecomarket.demo')),
('Cevada cervejeira - saca 50kg', 'Cevada malteira, lote homogêneo para indústria.', '115.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Fibra e Café'), 'uploads/cevada.svg',
 (SELECT id FROM tbusu WHERE email = 'ana.costa@ecomarket.demo')),

('Semente de soja tratada', 'Semente certificada, tratamento fungicida e inseticida.', '420.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Sementes'), 'uploads/semente-soja.svg',
 (SELECT id FROM tbusu WHERE email = 'cooperativa@raiz.demo')),
('Semente de milho híbrido', 'Híbrido single cross, alto vigor e germinação.', '890.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Sementes'), 'uploads/semente-milho.svg',
 (SELECT id FROM tbusu WHERE email = 'cooperativa@raiz.demo')),
('Milho silagem - tonelada', 'Milho para silagem, colheita no ponto ideal de umidade.', '95.00',
 (SELECT id FROM tbCategorias WHERE nome = 'Sementes'), 'uploads/milho-silagem.svg',
 (SELECT id FROM tbusu WHERE email = 'contato@fazendaverde.demo'));

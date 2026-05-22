<?php
$produtos = [
    'soja' => 'Soja',
    'trigo' => 'Trigo',
    'milho' => 'Milho',
    'arroz' => 'Arroz',
    'feijao' => 'Feijão',
    'cafe' => 'Café',
    'algodao' => 'Algodão',
    'girassol' => 'Girassol',
    'cana' => 'Cana-de-açúcar',
    'amendoim' => 'Amendoim',
    'aveia' => 'Aveia',
    'cevada' => 'Cevada',
    'centeio' => 'Centeio',
    'milho-silagem' => 'Milho silagem',
    'semente-soja' => 'Semente de soja',
    'semente-milho' => 'Semente de milho',
];

$dir = dirname(__DIR__) . '/uploads/';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

foreach ($produtos as $arquivo => $rotulo) {
    $rotuloEsc = htmlspecialchars($rotulo, ENT_XML1, 'UTF-8');
    $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#1b4332"/>
      <stop offset="100%" style="stop-color:#40916c"/>
    </linearGradient>
  </defs>
  <rect width="400" height="400" fill="url(#bg)" rx="12"/>
  <circle cx="200" cy="150" r="70" fill="#d8f3dc" opacity="0.35"/>
  <text x="200" y="215" font-family="Segoe UI, Arial, sans-serif" font-size="38" font-weight="700" fill="#ffffff" text-anchor="middle">{$rotuloEsc}</text>
  <text x="200" y="260" font-family="Segoe UI, Arial, sans-serif" font-size="17" fill="#b7e4c7" text-anchor="middle">EcoMarket Agro</text>
</svg>
SVG;
    file_put_contents($dir . $arquivo . '.svg', $svg);
}

echo "Imagens geradas em uploads/\n";

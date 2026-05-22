<script>
function validarPreco(event) {
    const char = String.fromCharCode(event.which);
    const value = event.target.value;
    if (!/[0-9,\.]/.test(char)) { event.preventDefault(); return false; }
    if ((char === ',' || char === '.') && (value.includes(',') || value.includes('.'))) { event.preventDefault(); return false; }
    if ((char === ',' || char === '.') && value.length === 0) { event.preventDefault(); return false; }
    return true;
}
function formatarPreco(input) {
    let value = input.value.replace(/[^0-9,\.]/g, '').replace(',', '.');
    const parts = value.split('.');
    if (parts.length > 2) value = parts[0] + '.' + parts.slice(1).join('');
    if (parts.length === 2 && parts[1].length > 2) value = parts[0] + '.' + parts[1].substring(0, 2);
    input.value = value.replace('.', ',');
}
document.querySelector('form[data-preco]')?.addEventListener('submit', function (e) {
    const preco = document.getElementById('preco').value.replace(',', '.');
    if (isNaN(preco) || parseFloat(preco) <= 0) {
        e.preventDefault();
        alert('Informe um preço válido maior que zero.');
    }
});
</script>

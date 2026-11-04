// Gestió del canvi de mode fosc a mode blanc (clar)
const btnTema = document.getElementById('btn-tema');

// Comprovem la preferència desada a localStorage
const temaDesat = localStorage.getItem('tema');

if (temaDesat === 'fosc') {
    document.body.classList.add('mode-fosc');
    if (btnTema) {
        btnTema.textContent = '☀️ Mode clar';
    }
}

// Alternar tema en fer clic al botó
if (btnTema) {
    btnTema.addEventListener('click', () => {
        document.body.classList.toggle('mode-fosc');
        
        const esFosc = document.body.classList.contains('mode-fosc');
        btnTema.textContent = esFosc ? '☀️ Mode clar' : '🌙 Mode fosc';
        
        localStorage.setItem('tema', esFosc ? 'fosc' : 'clar');
    });
}

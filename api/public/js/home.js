function openRegister() {
    let form = document.getElementById('registerForm');
    
    form.classList.replace('formHidden','formVisible');
}

function openLogin() {
    let form = document.getElementById('loginForm');
    
    form.classList.replace('formHidden','formVisible');
}

function closeRegister() {
    let form = document.getElementById('registerForm');

    form.classList.replace('formVisible', 'formHidden');
}

function closeLogin() {
    let form = document.getElementById('loginForm');

    form.classList.replace('formVisible', 'formHidden');
}
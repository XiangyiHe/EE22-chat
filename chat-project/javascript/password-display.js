let showPass1 = document.getElementById('show-password-register1');
let showPass2 = document.getElementById('show-password-register2');
let showPass3 = document.getElementById('login-password-show');

const registerPassword = document.getElementById('register-password');
const registerPasswordConfirm = document.getElementById('register-password-confirm');
const loginPassword = document.getElementById('login-password');

const passwordShowHandler = (passwordSection, showButton) => {
    if (passwordSection.type === "text") {
        passwordSection.type = "password";
        showButton.classList.remove('active');
    } else {
        passwordSection.type = "text";
        showButton.classList.add('active');
        
    }
}

if (showPass1 !== null) {
    showPass1.addEventListener('click', () => passwordShowHandler(registerPassword, showPass1));
}

if (showPass2 !== null) {
    showPass2.addEventListener('click', () => passwordShowHandler(registerPasswordConfirm, showPass2));
}

if (showPass3 !== null) {
    showPass3.addEventListener('click', () => passwordShowHandler(loginPassword, loginPassword));
}



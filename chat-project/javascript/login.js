const signUpForm = document.getElementById('login-form');
const loginBtn = document.getElementById('login-submit');
const error = document.getElementById('error-message');

signUpForm.onsubmit = (e) => {
    e.preventDefault();
}

loginBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let res = xhr.response;
                if (res === "success") {
                    location.href = "users.php";
                } else {
                    error.textContent = res;
                    error.style.display = "block";
                }
            }
        }
    }

    let formRes = new FormData(signUpForm);

    xhr.send(formRes);
}

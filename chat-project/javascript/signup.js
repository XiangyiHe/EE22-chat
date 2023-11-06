const signUpForm = document.getElementById('register-form');
const registerBtn = document.getElementById('register-submit');
const error = document.getElementById('error-message');

signUpForm.onsubmit = (e) => {
    e.preventDefault();
}
registerBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/signup.php", true);
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

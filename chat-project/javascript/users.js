const searchBtn = document.getElementById('search-btn');
const searchInput = document.getElementById('search-user-input');
const userList = document.getElementById('list-users')

searchBtn.addEventListener('click', () => {
    searchInput.classList.toggle('active');
    searchInput.focus()
    searchBtn.classList.toggle('active');
    searchInput.value = "";
})


setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php/users.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let res = xhr.response;
                if (!searchInput.classList.contains("active")) {
                    userList.innerHTML = res;
                }
            }
        }
    }
    xhr.send();
}, 500);

searchInput.onkeyup = () => {
    let searchWord = searchInput.value;
    if (searchWord === "") {
        searchInput.classList.remove("active");
    } else {
        searchInput.classList.add("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/search.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let res = xhr.response;
                userList.innerHTML = res;
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchWord=" + searchWord);
}
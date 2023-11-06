const messageInput = document.getElementById('message-content');
const sendBtn = document.getElementById('message-send-btn');
const sendSection = document.getElementById('send-section');

const chatbox = document.getElementById('chat-box');


sendSection.onsubmit = (e) => {
    e.preventDefault();
}

chatbox.onmouseenter = () => {
    chatbox.classList.add('active');
}

chatbox.onmouseleave = () => {
    chatbox.classList.remove('active');
}

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let res = xhr.response;
                chatbox.innerHTML = res;
                if(!chatbox.classList.contains('active')) {
                    scroll();
                }
                
            }
        }
    }
    let sendRes = new FormData(sendSection);
    xhr.send(sendRes);
}, 500);


sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                messageInput.value = "";
                scroll();
            } 
        }
    }

    let sendRes = new FormData(sendSection);
    xhr.send(sendRes);
}


const scroll = () => {
    chatbox.scrollTop = chatbox.scrollHeight;
}


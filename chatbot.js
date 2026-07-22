document.addEventListener("DOMContentLoaded", function () {

    const sendBtn = document.getElementById("sendBtn");
    const userInput = document.getElementById("userInput");
    const chatBody = document.getElementById("chatBody");

    function addMessage(message, sender) {

        let div = document.createElement("div");

        div.className = sender;

        div.innerHTML = message;

        chatBody.appendChild(div);

        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function sendMessage() {

        let message = userInput.value.trim();

        if (message === "") return;

        addMessage("🧑 " + message, "user-message");

        fetch("chatbot.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },

            body: "message=" + encodeURIComponent(message)

        })

        .then(response => response.json())

        .then(data => {

            setTimeout(() => {

                addMessage("🤖 " + data.reply, "bot-message");

            }, 500);

        })

        .catch(() => {

            addMessage("🤖 Server Error!", "bot-message");

        });

        userInput.value = "";

    }

    sendBtn.addEventListener("click", sendMessage);

    userInput.addEventListener("keypress", function (e) {

        if (e.key === "Enter") {

            sendMessage();

        }

    });

});
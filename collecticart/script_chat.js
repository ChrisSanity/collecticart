const chatBody = document.getElementById("chatBody");
const sendBtn = document.getElementById("sendChat");
const msgInput = document.getElementById("chatMessage");
const minimizeBtn = document.getElementById("minimizeChat");

let partnerId = 1; // Admin’s ID

function loadMessages() {
  fetch(`fetch_messages.php?partner_id=${partnerId}`)
    .then(res => res.json())
    .then(messages => {
      if (messages.error === "LOGIN_REQUIRED") {
        openSidebar(); // ⬅️ show login sidebar
        return;
      }
      chatBody.innerHTML = "";
      messages.forEach(msg => {
        const div = document.createElement("div");
        div.classList.add("message", msg.sender_id == partnerId ? "received" : "sent");
        div.textContent = msg.message;
        chatBody.appendChild(div);
      });
      chatBody.scrollTop = chatBody.scrollHeight;
    });
}

sendBtn.addEventListener("click", () => {
  const text = msgInput.value.trim();
  if (text === "") return;
  fetch("send_message.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `receiver_id=${partnerId}&message=${encodeURIComponent(text)}`
  }).then(res => res.text())
    .then(resp => {
      if (resp === "LOGIN_REQUIRED") {
        openSidebar(); // ⬅️ trigger login
      } else {
        msgInput.value = "";
        loadMessages();
      }
    });
});

minimizeBtn.addEventListener("click", () => {
  document.querySelector(".chat-body").classList.toggle("hidden");
  document.querySelector(".chat-footer").classList.toggle("hidden");
});

setInterval(loadMessages, 3000);

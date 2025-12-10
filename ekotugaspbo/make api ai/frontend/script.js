// =============================
// ELEMENTS
// =============================
const sendBtn = document.getElementById("sendBtn");
const promptInput = document.getElementById("promptInput");
const chatContainer = document.getElementById("chatContainer");

const newChatBtn = document.getElementById("newChatBtn");
const aboutBtn = document.getElementById("aboutBtn");
const homeBtn = document.getElementById("homeBtn");
const toggleThemeBtn = document.getElementById("toggleThemeBtn");

const welcomeView = document.getElementById("welcomeView");
const chatView = document.getElementById("chatView");
const aboutView = document.getElementById("aboutView");

const historyList = document.getElementById("historyList");

const sidebar = document.getElementById("sidebar");
const sidebarOpenBtn = document.getElementById("sidebarOpenBtn");
const sidebarToggle = document.getElementById("sidebarToggle");
const sidebarOverlay = document.getElementById("sidebarOverlay");

const templateHistory = document.getElementById("history-item-template");
const templateMessage = document.getElementById("message-template");


// =============================
// STATE - LOCAL DATA
// =============================
let chats = JSON.parse(localStorage.getItem("chats") || "[]");
let activeChatId = null;


// =============================
// SAVE & RENDER HISTORY
// =============================
function saveChats() {
  localStorage.setItem("chats", JSON.stringify(chats));
}

function renderHistory() {
  historyList.innerHTML = "";

  chats.forEach(chat => {
    const li = templateHistory.content.cloneNode(true);
    const btnOpen = li.querySelector(".history-open");
    const btnRename = li.querySelector(".rename");
    const btnDelete = li.querySelector(".delete");
    const time = li.querySelector(".history-time");

    btnOpen.textContent = chat.title || "Percakapan Baru";
    time.textContent = chat.time;

    btnOpen.addEventListener("click", () => openChat(chat.id));
    btnRename.addEventListener("click", () => renameChat(chat.id));
    btnDelete.addEventListener("click", () => deleteChat(chat.id));

    historyList.appendChild(li);
  });
}


// =============================
// CREATE NEW CHAT
// =============================
function createNewChat() {
  const newChat = {
    id: Date.now(),
    title: "Percakapan Baru",
    time: new Date().toLocaleString("id-ID"),
    messages: []
  };

  chats.unshift(newChat);
  activeChatId = newChat.id;

  saveChats();
  renderHistory();
  loadChatMessages();
  showChatView();
}

newChatBtn.addEventListener("click", () => {
  createNewChat();
  promptInput.focus();
});


// =============================
// OPEN EXISTING CHAT
// =============================
function openChat(id) {
  activeChatId = id;
  loadChatMessages();
  showChatView();
}


// =============================
// LOAD MESSAGES TO CHAT VIEW
// =============================
function loadChatMessages() {
  chatContainer.innerHTML = "";

  const chat = chats.find(c => c.id === activeChatId);
  if (!chat) return;

  chat.messages.forEach(msg => {
    addMessage(msg.sender, msg.text, false);
  });
}


// =============================
// RENAME CHAT
// =============================
function renameChat(id) {
  const chat = chats.find(c => c.id === id);
  if (!chat) return;

  const newTitle = prompt("Nama baru percakapan:", chat.title);
  if (newTitle && newTitle.trim() !== "") {
    chat.title = newTitle.trim();
    saveChats();
    renderHistory();
  }
}


// =============================
// DELETE CHAT
// =============================
function deleteChat(id) {
  chats = chats.filter(c => c.id !== id);

  if (activeChatId === id) {
    activeChatId = null;
    showWelcome();
  }

  saveChats();
  renderHistory();
}


// =============================
// ADD CHAT MESSAGE (VIEW + SAVE)
// =============================
function addMessage(sender, text, save = true) {
  const msg = document.createElement("div");
  msg.className = sender === "user" ? "message user" : "message bot";
  msg.innerHTML = `<div class="bubble ${sender}">${text}</div>`;
  chatContainer.appendChild(msg);
  chatContainer.scrollTop = chatContainer.scrollHeight;

  if (save && activeChatId) {
    const chat = chats.find(c => c.id === activeChatId);
    chat.messages.push({ sender, text });
    saveChats();
  }
}


// =============================
// BACKEND API
// =============================
async function sendMessageToBackend(userMessage) {
  try {
    const response = await fetch("/api/chat", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message: userMessage }),
    });

    const data = await response.json();
    return data.reply;
  } catch {
    return "⚠️ Terjadi kesalahan pada server.";
  }
}


// =============================
// SEND BUTTON HANDLER
// =============================
async function handleSend() {
  const text = promptInput.value.trim();
  if (!text) return;

  if (!activeChatId) createNewChat();

  addMessage("user", text);
  promptInput.value = "";

  // loading bubble
  const loading = document.createElement("div");
  loading.className = "message bot loading";
  loading.innerHTML = `<div class="bubble bot">...</div>`;
  chatContainer.appendChild(loading);

  const reply = await sendMessageToBackend(text);

  loading.remove();
  addMessage("bot", reply);
}

sendBtn.addEventListener("click", handleSend);

promptInput.addEventListener("keydown", (e) => {
  if (e.key === "Enter" && !e.shiftKey) {
    e.preventDefault();
    handleSend();
  }
});


// =============================
// VIEW SWITCHER
// =============================
function hideAllViews() {
  welcomeView.classList.add("hidden");
  chatView.classList.add("hidden");
  aboutView.classList.add("hidden");
}

function showWelcome() { hideAllViews(); welcomeView.classList.remove("hidden"); }
function showChatView() { hideAllViews(); chatView.classList.remove("hidden"); }
function showAbout()   { hideAllViews(); aboutView.classList.remove("hidden"); }


// Buttons
aboutBtn.addEventListener("click", showAbout);
homeBtn.addEventListener("click", showWelcome);


// =============================
// PROMPT CARDS
// =============================
document.querySelectorAll(".prompt-card").forEach(card => {
  card.addEventListener("click", async () => {
    const text = card.innerText.trim();

    if (!activeChatId) createNewChat();

    addMessage("user", text);
    showChatView();

    // loading UI
    const loading = document.createElement("div");
    loading.className = "message bot loading";
    loading.innerHTML = `<div class="bubble bot">...</div>`;
    chatContainer.appendChild(loading);

    const reply = await sendMessageToBackend(text);

    loading.remove();
    addMessage("bot", reply);
  });
});


// =============================
// MODE GELAP
// =============================
toggleThemeBtn.addEventListener("click", () => {
  document.body.classList.toggle("dark");
});


// =============================
// SIDEBAR MOBILE
// =============================
sidebarOpenBtn?.addEventListener("click", () => {
  sidebar.classList.add("open");
  sidebarOverlay.classList.remove("hidden");
});

sidebarToggle?.addEventListener("click", () => {
  sidebar.classList.toggle("open");
  sidebarOverlay.classList.toggle("hidden");
});

sidebarOverlay?.addEventListener("click", () => {
  sidebar.classList.add("hidden");
});


// =============================
// INIT APP
// =============================
renderHistory();
showWelcome();

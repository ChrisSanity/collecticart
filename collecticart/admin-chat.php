<?php
/* include __DIR__ . "/session-config.php";

// Require admin login
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

$admin_id = (int)$_SESSION['user_id']; */
$conn = new mysqli("localhost", "root", "", "collecticart");

// Fetch conversation list: distinct partners who chatted with admin sorted by last message time
$conversations = [];
$sql = "
SELECT u.id, u.username, t.last_at
FROM (
  SELECT partner_id, MAX(created_at) AS last_at
  FROM (
    SELECT CASE WHEN sender_id = ? THEN receiver_id ELSE sender_id END AS partner_id, created_at
    FROM messages
    WHERE sender_id = ? OR receiver_id = ?
  ) AS x
  GROUP BY partner_id
) AS t
JOIN users u ON u.id = t.partner_id
ORDER BY t.last_at DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $admin_id, $admin_id, $admin_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $conversations[] = $row;
}

function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Chat Management</title>
  <style>
    :root {
      --border: #e6e6e6;
      --bg: #fff;
      --bg-soft: #f7f7f7;
      --text: #222;
      --muted: #777;
      --blue: #2d8cff;
      --blue-dark: #1f6ed1;
      --green: #27ae60;
      --red: #e74c3c;
    }
    * { box-sizing: border-box; }
    body {
      margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      color: var(--text); background: var(--bg);
    }
    .layout { display: grid; grid-template-columns: 320px 1fr; height: 100vh; }

    /* Left: conversation list */
    .sidebar {
      border-right: 1px solid var(--border);
      display: flex; flex-direction: column; min-width: 0;
    }
    .sidebar-header {
      padding: 16px; border-bottom: 1px solid var(--border); font-weight: 600;
    }
    .search { padding: 12px; }
    .search input {
      width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px;
      outline: none; font-size: 14px;
    }
    .conv-list { overflow-y: auto; }
    .conv-item {
      padding: 12px 16px; display: flex; align-items: center; gap: 12px; cursor: pointer;
      border-bottom: 1px solid var(--border); background: var(--bg);
    }
    .conv-item:hover { background: var(--bg-soft); }
    .conv-item.active { background: #eef4ff; }
    .avatar {
      width: 40px; height: 40px; border-radius: 50%; background: #ddd; display: grid; place-items: center; font-weight: 600;
    }
    .conv-info { flex: 1; min-width: 0; }
    .conv-name { font-size: 14px; font-weight: 600; }
    .conv-meta { font-size: 12px; color: var(--muted); }

    /* Right: chat panel */
    .chat {
      display: grid; grid-template-rows: auto 1fr auto; height: 100vh; min-width: 0;
    }
    .chat-header {
      padding: 14px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px;
    }
    .chat-title { font-weight: 600; }
    .chat-body { overflow-y: auto; padding: 16px; background: var(--bg-soft); }
    .empty-state { color: var(--muted); text-align: center; margin-top: 24px; }

    .bubble {
      max-width: 70%; padding: 10px 12px; border-radius: 14px; margin: 8px 0; font-size: 14px; line-height: 1.35;
      position: relative; word-wrap: break-word; white-space: pre-wrap;
    }
    .sent { margin-left: auto; background: var(--blue); color: #fff; border-top-right-radius: 4px; }
    .received { margin-right: auto; background: #fff; color: var(--text); border: 1px solid var(--border); border-top-left-radius: 4px; }
    .msg-time { display: block; font-size: 11px; color: var(--muted); margin-top: 4px; }

    .chat-footer { display: flex; gap: 8px; padding: 12px; border-top: 1px solid var(--border); background: #fff; }
    .chat-footer input[type="text"] {
      flex: 1; padding: 12px; border: 1px solid var(--border); border-radius: 8px; outline: none; font-size: 14px;
    }
    .chat-footer button {
      padding: 12px 16px; background: var(--blue); color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;
    }
    .chat-footer button:hover { background: var(--blue-dark); }

    @media (max-width: 900px) {
      .layout { grid-template-columns: 1fr; }
      .sidebar { display: none; }
      .layout.show-list .sidebar { display: flex; }
    }
  </style>
</head>
<body>
  <div class="layout" id="layout">
    <!-- Sidebar: Conversations -->
    <aside class="sidebar">
      <div class="sidebar-header">Conversations</div>
      <div class="search"><input type="text" id="searchInput" placeholder="Search users..." /></div>
      <div class="conv-list" id="convList">
        <?php if (count($conversations) === 0): ?>
          <div class="empty-state">No conversations yet.</div>
        <?php else: ?>
          <?php foreach ($conversations as $c): ?>
            <div class="conv-item" data-user-id="<?= (int)$c['id'] ?>" data-username="<?= h($c['username']) ?>">
              <div class="avatar"><?= strtoupper(h(substr($c['username'], 0, 1))) ?></div>
              <div class="conv-info">
                <div class="conv-name"><?= h($c['username']) ?></div>
                <div class="conv-meta">Last: <?= h($c['last_at']) ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </aside>

    <!-- Chat Panel -->
    <section class="chat">
      <div class="chat-header">
        <div class="avatar" id="partnerAvatar">?</div>
        <div class="chat-title" id="chatTitle">Select a conversation</div>
      </div>
      <div class="chat-body" id="chatBody">
        <div class="empty-state">Choose a user from the left to view the conversation.</div>
      </div>
      <div class="chat-footer">
        <input type="text" id="messageInput" placeholder="Type a message..." disabled />
        <button id="sendBtn" disabled>Send</button>
      </div>
    </section>
  </div>

  <script>
    const adminId = <?php echo json_encode($admin_id); ?>;
    const convList = document.getElementById('convList');
    const chatBody = document.getElementById('chatBody');
    const chatTitle = document.getElementById('chatTitle');
    const partnerAvatar = document.getElementById('partnerAvatar');
    const msgInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const searchInput = document.getElementById('searchInput');

    let partnerId = null;
    let partnerName = '';
    let pollTimer = null;

    function scrollToBottom() {
      chatBody.scrollTop = chatBody.scrollHeight;
    }

    function renderMessages(messages) {
      chatBody.innerHTML = '';
      if (!Array.isArray(messages) || messages.length === 0) {
        chatBody.innerHTML = '<div class="empty-state">No messages yet. Start the conversation.</div>';
        return;
      }
      for (const m of messages) {
        const isSent = Number(m.sender_id) === Number(adminId);
        const div = document.createElement('div');
        div.className = 'bubble ' + (isSent ? 'sent' : 'received');
        const text = document.createElement('div');
        text.textContent = m.message;
        const time = document.createElement('span');
        time.className = 'msg-time';
        time.textContent = (m.created_at || '').replace('T', ' ').slice(0, 19);
        div.appendChild(text);
        if (m.created_at) div.appendChild(time);
        chatBody.appendChild(div);
      }
      scrollToBottom();
    }

    async function loadMessages() {
      if (!partnerId) return;
      try {
        const res = await fetch('fetch_messages.php?partner_id=' + encodeURIComponent(partnerId));
        const data = await res.json();
        if (data && data.error === 'LOGIN_REQUIRED') {
          alert('Your session expired. Please log in again.');
          window.location.href = 'all-products.php';
          return;
        }
        renderMessages(data);
      } catch (e) {
        console.error('Failed to load messages', e);
      }
    }

    async function sendMessage() {
      const text = msgInput.value.trim();
      if (!text || !partnerId) return;
      try {
        const res = await fetch('send_message.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'receiver_id=' + encodeURIComponent(partnerId) + '&message=' + encodeURIComponent(text)
        });
        const resp = await res.text();
        if (resp === 'LOGIN_REQUIRED') {
          alert('Your session expired. Please log in again.');
          window.location.href = 'all-products.php';
          return;
        }
        msgInput.value = '';
        await loadMessages();
      } catch (e) {
        console.error('Failed to send message', e);
      }
    }

    function selectConversation(el) {
      document.querySelectorAll('.conv-item').forEach(i => i.classList.remove('active'));
      el.classList.add('active');
      partnerId = el.getAttribute('data-user-id');
      partnerName = el.getAttribute('data-username') || 'User';
      chatTitle.textContent = partnerName;
      partnerAvatar.textContent = (partnerName.substr(0,1) || '?').toUpperCase();
      msgInput.disabled = false;
      sendBtn.disabled = false;
      loadMessages();
      if (pollTimer) clearInterval(pollTimer);
      pollTimer = setInterval(loadMessages, 3000);
    }

    // Event bindings
    convList && convList.addEventListener('click', (e) => {
      const item = e.target.closest('.conv-item');
      if (item) selectConversation(item);
    });

    sendBtn && sendBtn.addEventListener('click', sendMessage);
    msgInput && msgInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    // Filter conversations by search
    searchInput && searchInput.addEventListener('input', () => {
      const term = searchInput.value.toLowerCase();
      document.querySelectorAll('.conv-item').forEach(item => {
        const name = (item.getAttribute('data-username') || '').toLowerCase();
        item.style.display = name.includes(term) ? '' : 'none';
      });
    });
  </script>
</body>
</html>

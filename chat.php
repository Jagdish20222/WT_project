<?php
/**
 * chat.php
 * Simple Chat Room
 * 
 * Purpose: Real-time messaging system for students
 * Storage: File-based (messages.json)
 */

$dataFile = __DIR__ . '/messages.json';

// Ensure file exists
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

// Handle new message POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = isset($_POST['user']) ? trim($_POST['user']) : 'Anonymous';
    $msg = isset($_POST['message']) ? trim($_POST['message']) : '';
    if ($msg !== '') {
        $entry = [
            'user' => mb_substr($user, 0, 60),
            'message' => mb_substr($msg, 0, 1000),
            'time' => time()
        ];
        // Append safely
        $all = json_decode(file_get_contents($dataFile), true);
        if (!is_array($all)) $all = [];
        $all[] = $entry;
        file_put_contents($dataFile, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
    // Redirect to avoid form resubmission
    header('Location: chat.php');
    exit;
}

$messages = json_decode(file_get_contents($dataFile), true);
if (!is_array($messages)) $messages = [];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Chat Room</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', sans-serif;
        background: #0f0f0f;
        color: #ffffff;
        min-height: 100vh;
    }

    /* Navigation */
    header {
        background: rgba(15, 15, 15, 0.8);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem 2rem;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    header nav {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header nav a {
        color: #a0a0a0;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.3s;
    }

    header nav a:hover {
        color: #ffd93d;
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.05);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
    }

    h1 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .subtitle {
        color: #888888;
        margin-bottom: 2rem;
    }

    .chat-container {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 2rem;
    }

    form {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    input[type="text"] {
        padding: 0.8rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: #ffffff;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    input[type="text"]:focus {
        outline: none;
        border-color: #ffd93d;
        background: rgba(255, 255, 255, 0.08);
    }

    input[name="user"] {
        flex: 0 0 200px;
    }

    textarea {
        flex: 1;
        min-width: 300px;
        padding: 0.8rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: #ffffff;
        font-size: 0.95rem;
        min-height: 60px;
        resize: vertical;
        font-family: inherit;
        transition: all 0.3s;
    }

    textarea:focus {
        outline: none;
        border-color: #ffd93d;
        background: rgba(255, 255, 255, 0.08);
    }

    input[type="submit"] {
        background: #ffd93d;
        color: #0f0f0f;
        padding: 0.8rem 2rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    input[type="submit"]:hover {
        background: #ffed4e;
        transform: translateY(-2px);
    }

    .messages {
        max-height: 500px;
        overflow-y: auto;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 1.5rem;
    }

    .messages::-webkit-scrollbar {
        width: 8px;
    }

    .messages::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 4px;
    }

    .messages::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    .msg {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        transition: all 0.3s;
    }

    .msg:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .msg-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .msg-user {
        font-weight: 600;
        color: #ffd93d;
    }

    .msg-time {
        font-size: 0.85rem;
        color: #666666;
    }

    .msg-text {
        color: #cbd5e1;
        line-height: 1.6;
        word-wrap: break-word;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #666666;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        h1 {
            font-size: 2rem;
        }

        form {
            flex-direction: column;
        }

        input[name="user"] {
            flex: 1;
        }

        textarea {
            min-width: 100%;
        }
    }
  </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.html" style="font-size:1.5rem; color:#ffd93d;">💬</a>
            <a href="index.html" class="back-btn">← Back to Home</a>
        </nav>
    </header>

    <div class="container">
        <h1>💬 Chat Room</h1>
        <p class="subtitle">Connect and discuss with fellow students</p>

        <div class="chat-container">
            <form method="post" action="chat.php">
                <input type="text" name="user" placeholder="Your name" required>
                <textarea name="message" placeholder="Type your message..." required></textarea>
                <input type="submit" value="Send Message">
            </form>

            <div class="messages">
                <?php if (count($messages) > 0): ?>
                    <?php foreach (array_reverse($messages) as $m): ?>
                        <div class="msg">
                            <div class="msg-header">
                                <span class="msg-user"><?php echo htmlspecialchars($m['user'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="msg-time"><?php echo date('M j, Y g:i A', $m['time']); ?></span>
                            </div>
                            <div class="msg-text"><?php echo nl2br(htmlspecialchars($m['message'], ENT_QUOTES, 'UTF-8')); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p style="font-size: 3rem; margin-bottom: 1rem;">📭</p>
                        <h3>No messages yet</h3>
                        <p>Be the first to start the conversation!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
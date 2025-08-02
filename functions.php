<?php
// ✅ Flash message setter
function set_flash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

// ✅ Flash message getter (with auto-delete)
function get_flash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}

// ✅ Sanitize user input
function clean_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// ✅ Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// ✅ Redirect shortcut
function redirect($url) {
    header("Location: $url");
    exit;
}

// ✅ Limit text (e.g., for showing preview)
function excerpt($text, $limit = 100) {
    return strlen($text) > $limit ? substr($text, 0, $limit) . '...' : $text;
}

// ✅ Show time ago (e.g., "5 minutes ago")
function time_ago($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;

    if ($diff < 60) return "just now";
    if ($diff < 3600) return floor($diff / 60) . " minutes ago";
    if ($diff < 86400) return floor($diff / 3600) . " hours ago";
    if ($diff < 604800) return floor($diff / 86400) . " days ago";

    return date("M j, Y", $time);
}
function timeAgo($timestamp) {
    $time = strtotime($timestamp);
    $diff = time() - $time;

    if ($diff < 1) return 'just now';
    if ($diff < 60) return $diff . 's ago';
    if ($diff < 3600) return floor($diff / 60) . 'm ago';
    if ($diff < 86400) return floor($diff / 3600) . 'h ago';
    if ($diff < 172800) return 'yesterday';
    if ($diff < 604800) return floor($diff / 86400) . 'd ago';
    if ($diff < 2419200) return floor($diff / 604800) . 'w ago';
    return date("M j, Y", $time); // fallback to full date
};

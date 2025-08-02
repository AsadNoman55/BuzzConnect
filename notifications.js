document.addEventListener("DOMContentLoaded", () => {
    const notifIcon = document.getElementById("notifIcon");
    const notifBadge = document.getElementById("notifCount");
    const notifDropdown = document.getElementById("notifDropdown");

    // 🔁 Poll unread count every 10s
    async function fetchUnreadCount() {
        try {
            const res = await fetch("../notifications/notifications_count.php");
            const data = await res.json();
            if (data.unread > 0) {
                notifBadge.classList.remove("d-none");
                notifBadge.innerText = data.unread > 9 ? "9+" : data.unread;
            } else {
                notifBadge.classList.add("d-none");
                notifBadge.innerText = "";
            }
        } catch (err) {
            console.error("Failed to fetch notification count:", err);
        }
    }

    // 🔔 Load full notifications HTML
    async function fetchNotifications() {
        try {
            const response = await fetch("../notifications/fetch_notifications.php");
            const html = await response.text();
            notifDropdown.innerHTML = html;
        } catch (err) {
            console.error("Failed to fetch notifications:", err);
        }
    }

    // 🖱️ Click on bell icon
    notifIcon?.addEventListener("click", () => {
        fetchNotifications(); // load dropdown
        notifDropdown.classList.toggle("d-none");

        // Mark all as read (optional AJAX call)
        fetch("../notifications/mark_as_read.php").then(() => {
            notifBadge.classList.add("d-none");
            notifBadge.innerText = "";
        });
    });

    // 🕒 Initial & interval check
    fetchUnreadCount();
    setInterval(fetchUnreadCount, 10000); // every 10s
});

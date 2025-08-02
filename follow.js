console.log("🚀 follow.js is loaded and running");
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".follow-btn").forEach(followBtn => {
        const followedId = followBtn.getAttribute("data-user");

        if (!followedId) return;

        // Initial status check
        fetch(`../follow/get_follow_status.php?followed_id=${followedId}`)
            .then(res => res.json())
            .then(data => {
                console.log("📦 Initial Follow Status:", data);
                updateFollowButton(followBtn, data.status);
            })
            .catch(err => console.error("Status check failed:", err));

        // Follow/unfollow on click
        followBtn.addEventListener("click", () => {
            console.log("📤 Sending followed_id =", followedId);
            fetch("../follow/follow_toggle.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `followed_id=${followedId}`
            })
                .then(res => res.json())
                .then(data => {
                    console.log("🔁 Toggle response:", data);
                    updateFollowButton(followBtn, data.status);
                })
                .catch(err => console.error("Toggle failed:", err));
        });
    });

    function updateFollowButton(button, status) {
        if (status === "followed") {
            button.innerText = "➖ Unfollow";
            button.classList.remove("btn-outline-success");
            button.classList.add("btn-outline-danger");
        } else {
            button.innerText = "➕ Follow";
            button.classList.remove("btn-outline-danger");
            button.classList.add("btn-outline-success");
        }
    }
});

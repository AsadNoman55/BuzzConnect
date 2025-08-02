<?php
// includes/footer.php
?>
</div>

<footer class="text-center mt-5 py-4" style="background-color: #1a1a2e; color: #aaa;">
    <div class="container">
        <p class="mb-0">&copy; <?= date('Y') ?> BuzzConnect. Made with ❤️ by Asad.</p>
    </div>
</footer>

<!-- ✅ Bootstrap & JS scripts go here -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/notifications.js"></script>

<!-- ✅ follow.js should be loaded only for users, not admins -->
<?php if (!isset($is_admin) || !$is_admin): ?>
<script src="../assets/js/follow.js"></script>
<?php endif; ?>

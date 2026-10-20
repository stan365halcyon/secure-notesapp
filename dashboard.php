<?php
require_once __DIR__ . '/config/database.php';
requireLogin();

$pageTitle = 'Dashboard';
$activePage = 'dashboard';
include __DIR__ . '/includes/header.php';
?>
<div class="card hero">
    <h1>Welcome back, <?php echo escape($_SESSION['username']); ?> </h1>
    <p>Your secure workspace is ready. Use the links above to view your profile, send a message, or review submissions.</p>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Secure Session</h3>
            <p>You are signed in and protected by PHP sessions.</p>
        </div>
        <div class="stat-card">
            <h3>Quick Actions</h3>
            <p>Visit the Contact Us page to share feedback or inquiries.</p>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

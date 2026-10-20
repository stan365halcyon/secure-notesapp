<?php
require_once __DIR__ . '/config/database.php';
requireLogin();

$pageTitle = 'Profile';
$activePage = 'profile';

$pdo = getConnection();
$stmt = $pdo->prepare('SELECT username, email, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h1>Your Profile</h1>
    <?php if ($user): ?>
        <p><strong>Username:</strong> <?php echo escape($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo escape($user['email']); ?></p>
        <p><strong>Registered:</strong> <?php echo escape($user['created_at']); ?></p>
    <?php else: ?>
        <p>No profile details found.</p>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>


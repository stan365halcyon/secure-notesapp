<?php
require_once __DIR__ . '/config/database.php';
requireLogin();

$pageTitle = 'Information Hub';
$activePage = 'information';

$pdo = getConnection();
$stmt = $pdo->query('SELECT COUNT(*) AS total_users FROM users');
$totalUsers = $stmt->fetch();

$stmt = $pdo->query('SELECT COUNT(*) AS total_submissions FROM contact_submissions');
$totalSubmissions = $stmt->fetch();

include __DIR__ . '/includes/header.php';
?>
<div class="card hero">
    <h1>Information Hub</h1>
    <p>This page demonstrates dynamic content pulled from the database.</p>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Registered Users</h3>
            <p><?php echo escape((string) $totalUsers['total_users']); ?></p>
        </div>
        <div class="stat-card">
            <h3>Contact Submissions</h3>
            <p><?php echo escape((string) $totalSubmissions['total_submissions']); ?></p>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>


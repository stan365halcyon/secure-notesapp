<?php
require_once __DIR__ . '/config/database.php';
requireLogin();

$pageTitle = 'Submissions';
$activePage = 'submissions';

$pdo = getConnection();
$stmt = $pdo->query('SELECT name, email, subject, message, created_at FROM contact_submissions ORDER BY created_at DESC');
$submissions = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h1>Submissions Directory</h1>
    <?php if ($submissions): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $submission): ?>
                    <tr>
                        <td><?php echo escape($submission['name']); ?></td>
                        <td><?php echo escape($submission['email']); ?></td>
                        <td><?php echo escape($submission['subject']); ?></td>
                        <td><?php echo escape($submission['message']); ?></td>
                        <td><?php echo escape($submission['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No submissions yet.</p>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>


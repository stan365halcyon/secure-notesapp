<?php
require_once __DIR__ . '/config/database.php';
requireLogin();

$pageTitle = 'Contact Us';
$activePage = 'contact';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $messageText = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $subject === '' || $messageText === '') {
        $message = 'Please fill in all contact fields.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $messageType = 'error';
    } elseif (strlen($subject) > 150) {
        $message = 'Subject is too long.';
        $messageType = 'error';
    } else {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO contact_submissions (name, email, subject, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $subject, $messageText]);
        $message = 'Your message was saved successfully.';
        $messageType = 'success';
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h1>Contact Us</h1>
    <?php if ($message !== ''): ?>
        <div class="alert <?php echo escape($messageType); ?>"><?php echo escape($message); ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="name">Name</label>
        <input id="name" name="name" required maxlength="100">

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required maxlength="100">

        <label for="subject">Subject</label>
        <input id="subject" name="subject" required maxlength="150">

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Submit</button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

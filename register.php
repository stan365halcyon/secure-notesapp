<?php
require_once __DIR__ . '/config/database.php';

$pageTitle = 'Register';
$activePage = 'register';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($username === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $message = 'Please fill in all fields.';
        $messageType = 'error';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $message = 'Username must be between 3 and 50 characters.';
        $messageType = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        $messageType = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters.';
        $messageType = 'error';
    } elseif ($password !== $confirmPassword) {
        $message = 'Passwords do not match.';
        $messageType = 'error';
    } else {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $message = 'A user with that username or email already exists.';
            $messageType = 'error';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
            $insert->execute([$username, $email, $hash]);
            $message = 'Registration successful. You can now log in.';
            $messageType = 'success';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h1>Create an Account</h1>
    <?php if ($message !== ''): ?>
        <div class="alert <?php echo escape($messageType); ?>"><?php echo escape($message); ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="username">Username</label>
        <input id="username" name="username" required maxlength="50">

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required minlength="6">

        <label for="confirm_password">Confirm Password</label>
        <input id="confirm_password" name="confirm_password" type="password" required minlength="6">

        <button type="submit">Register</button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

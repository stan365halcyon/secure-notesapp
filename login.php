<?php
require_once __DIR__ . '/config/database.php';

$pageTitle = 'Login';
$activePage = 'login';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = 'Please enter both username and password.';
        $messageType = 'error';
    } else {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];
            redirect('dashboard.php');
        } else {
            $message = 'Invalid login credentials.';
            $messageType = 'error';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>
<div class="card">
    <h1>Login</h1>
    <?php if ($message !== ''): ?>
        <div class="alert <?php echo escape($messageType); ?>"><?php echo escape($message); ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="username">Username</label>
        <input id="username" name="username" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <button type="submit">Login</button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>


<?php
declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

use Wisdom\Core\App;
use Wisdom\Core\Csrf;
use Wisdom\Core\Guard;
use Wisdom\Core\Request;
use Wisdom\Services\AuthService;

if (Request::isPost()) {
    Guard::throttle('login', 10, 60);
}

if (Guard::user() !== null) {
    $currentUser = Guard::user();
    redirect($currentUser !== null && $currentUser->isStaff() ? 'admin.php' : 'dashboard.php');
}

$auth = App::get(AuthService::class);
$pageTitle = 'Sign in';
$error = '';
$email = '';

if (Request::isPost()) {
    $email = Request::post('email');
    $password = $_POST['password'] ?? '';
    $password = is_string($password) ? $password : '';

    if (!Csrf::verifyRequest()) {
        $error = 'Your session expired. Please try again.';
    } else {
        $validator = $auth->loginValidator(['email' => $email, 'password' => $password]);
        if (!$validator->passes()) {
            $error = 'Enter a valid email and password.';
        } else {
            try {
                $user = $auth->attempt($email, $password);
                $auth->login($user);
                \Wisdom\Core\Session::set('_just_logged_in', true);
                if ($user->mustResetPassword()) {
                    redirect('set_password.php');
                }
                redirect($user->isStaff() ? 'admin.php' : 'dashboard.php');
            } catch (\Wisdom\Core\AppException $exception) {
                $error = $exception->getMessage();
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<?php require __DIR__ . '/partials/head.php'; ?>
</head>
<body class="auth-page">
    <main class="auth-card">
        <div class="auth-brand">
            <p class="auth-heading-large">WISDOM BLENDED CLASSES</p>
            <h1 class="auth-heading-small">Welcome back</h1>
        </div>
        <p class="auth-brand__lead">Sign in to continue to your account.</p>

<?php if ($error !== ''): ?><div class="alert alert--error" role="alert"><?= e($error) ?></div><?php endif; ?>
<?php if (isset($_GET['logged_out'])): ?><p class="alert alert--info" role="status">You have been signed out.</p><?php endif; ?>
<?php if (isset($_GET['registered'])): ?><p class="alert alert--success" role="status">Account created. You can sign in now.</p><?php endif; ?>

<form method="post" action="login.php" novalidate>
    <?= csrf_field() ?>
    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="<?= e($email) ?>" autocomplete="username" required>

    <label for="password">Password</label>
    <div class="pw-wrap">
        <input id="password" name="password" type="password" autocomplete="current-password" required>
        <button type="button" class="pw-toggle" data-pw-target="password" aria-label="Show password" aria-pressed="false">
            <svg class="pw-icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg class="pw-icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" style="display:none"><path d="M3 3l18 18"/><path d="M10.6 6.1A9.8 9.8 0 0 1 12 6c6 0 10 6 10 6a17 17 0 0 1-3.4 4.2"/><path d="M6.6 6.6C3.8 8.4 2 12 2 12s4 6 10 6a9.7 9.7 0 0 0 4.6-1.1"/></svg>
        </button>
    </div>

    <button type="submit" class="btn btn--gold">Sign in</button>
</form>

<div class="auth-links"><a href="forgot_password.php">Forgot your password?</a></div>
<div class="auth-links">New to WISDOM? <a href="register.php">Create an account</a></div>
</main>
<script src="assets/js/wisdom-ui.js" nonce="<?= e(nonce()) ?>" defer></script>
</body>
</html>

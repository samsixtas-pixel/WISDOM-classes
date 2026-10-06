<?php
declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

use Wisdom\Core\App;
use Wisdom\Core\AppException;
use Wisdom\Core\Csrf;
use Wisdom\Core\Guard;
use Wisdom\Core\Request;
use Wisdom\Services\SupportService;

if (Request::isPost()) {
    Guard::throttle('contact', 5, 900);
}

$pageTitle = 'Contact support';
$pageDesc  = 'Reach the WISDOM Blended Classes support team about fees, examinations, or your account.';

$current = Guard::user();
$home = $current === null ? 'landing.php' : ($current->isStaff() ? 'admin.php' : 'dashboard.php');

$service = App::get(SupportService::class);
$error = $message = $name = $email = $subject = '';
if (Request::isPost()) {
    $name    = Request::post('name');
    $email   = Request::post('email');
    $subject = Request::post('subject');
    $body    = is_string($_POST['message'] ?? null) ? $_POST['message'] : '';
    if (!Csrf::verifyRequest()) {
        $error = 'Your session expired. Please try again.';
    } else {
        try {
            $service->submit($name, $email, $subject, $body);
            $message = 'Your message has been received. Our team replies within one working day.';
            $name = $email = $subject = '';
        } catch (AppException $exception) {
            $error = $exception->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head><?php require __DIR__ . '/partials/head.php'; ?></head>
<body>
    <div class="shell">
        <?php require __DIR__ . '/partials/nav.php'; ?>
        <main class="shell__main page-fade">
            <?php require __DIR__ . '/partials/notice.php'; ?>
                <div class="eyebrow">Support</div>
                <h1>Contact & support</h1>
                    <p class="text-muted">Tell us what you need help with. Fee, examination and account questions are all handled here.</p>
                    <?php if ($error !== ''): ?><p class="alert error" role="alert"><?= e($error) ?></p><?php endif; ?>
                    <?php if ($message !== ''): ?><div id="js-success-modal" hidden data-title="Message sent" data-body="<?= e($message) ?>" data-confirm="Close"></div><?php endif; ?>
                <section class="card">
                    <form method="post" action="contact.php" class="contact-form">
                        <?= csrf_field() ?>
                        <div class="field">
                        <label>Your name<br><input name="name" value="<?= e($name) ?>" maxlength="120" required></label><br>
                        </div>
                        
                        <label>Email<input name="email" type="email" value="<?= e($email) ?>" maxlength="254" required></label><br>
                        <div class="field">
                        <label style="grid-column:1/-1">Subject<br><input name="subject" value="<?= e($subject) ?>" maxlength="150" required></label><br>
                        </div>
                        <label style="grid-column:1/-1">Message<textarea name="message" rows="6" maxlength="4000" required></textarea></label><br><br>
                        <button class="btn btn-gold" type="submit">Send message</button>
                    </form>
                </section>
            <section class="card"><br>
                <h2>Prefer email?</h2>
                <p class="text-muted">Write to <a href="mailto:wisdom.blendedclasses@hotmail.com">wisdom.blendedclasses@hotmail.com</a> and include your registered email address so we can find your account quickly.</p>
            </section>
        </main>
    </div>    
<footer class="footer" style="color: #361d7922;">
    <p class="text-muted"><a href="landing.php">Home</a> ·
     <a href="privacy.php">Privacy policy</a> · 
     <a href="terms.php">Terms of service</a>
    </p>
</footer>
<script src="assets/js/wisdom-ui.js" defer></script>
</body>
</html>

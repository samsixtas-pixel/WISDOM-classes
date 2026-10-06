<?php
/** Active notices shown on signed-in pages. */
$noticeService = $noticeService ?? \Wisdom\Core\App::get(\Wisdom\Services\NoticeService::class);
$currentUser = \Wisdom\Core\Guard::user();
$activeNotices = $noticeService->activeForCurrentUser($currentUser?->getId());
if ($activeNotices === []) {
    return;
}

$justLoggedIn = \Wisdom\Core\Session::pull('_just_logged_in', false) === true;
$cardClass = 'notice-card' . ($justLoggedIn ? ' notice-card--animate-in' : '');
?>
<div class="notice-stack">
<?php foreach ($activeNotices as $notice): ?>
    <article class="<?= e($cardClass) ?>" role="status">
        <div class="row" style="align-items:flex-start">
            <div class="w-tile-icon" aria-hidden="true">
                <svg class="w-icon-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path></svg>
            </div>
            <div style="flex:1; min-width:0;">
                <div class="eyebrow">Notice from administration</div>
                <h3><?= e($notice->getTitle()) ?></h3>
                <p><?= e($notice->getBody()) ?></p>
                <?php if ($notice->getExpiresAt() !== null): ?>
                    <small class="text-muted">Expires <?= e(date('D j M · H:i', strtotime($notice->getExpiresAt()))) ?></small>
                <?php endif; ?>
                <form method="post" action="notice_dismiss.php" class="notice-dismiss-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="notice_id" value="<?= (int) $notice->getId() ?>">
                    <input type="hidden" name="redirect_to" value="<?= e($_SERVER['REQUEST_URI'] ?? 'dashboard.php') ?>">
                    <button class="btn--neomorph-red" type="submit">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                            <line x1="6" y1="6" x2="18" y2="18"/>
                            <line x1="18" y1="6" x2="6" y2="18"/>
                        </svg>
                        <span>Dismiss</span>
                    </button>
                </form>
            </div>
        </div>
    </article>
<?php endforeach; ?>
</div>
<script nonce="<?= e(nonce()) ?>">
(function () {
    'use strict';

    document.querySelectorAll('.notice-dismiss-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const card = form.closest('.notice-card');
            if (!card || card.classList.contains('notice-card--dismissing')) {
                return;
            }

            card.classList.remove('notice-card--animate-in');
            card.classList.add('notice-card--dismissing');

            let settled = false;
            const formData = new FormData(form);
            const url = form.getAttribute('action') || 'notice_dismiss.php';

            fetch(url, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).catch(function () {
                if (!settled) {
                    settled = true;
                    form.submit();
                }
            });

            const finish = function () {
                if (settled) return;
                settled = true;
                card.remove();
                const stack = document.querySelector('.notice-stack');
                if (stack && stack.children.length === 0) {
                    stack.remove();
                }
            };

            card.addEventListener('animationend', function (ev) {
                if (ev.animationName === 'noticeDropletOut') finish();
            }, { once: true });

            setTimeout(finish, 900);
        });
    });
})();
</script>

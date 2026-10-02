<?php
declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

use Wisdom\Core\App;
use Wisdom\Core\AppException;
use Wisdom\Core\Csrf;
use Wisdom\Core\Guard;
use Wisdom\Core\Request;
use Wisdom\Core\Session;
use Wisdom\Models\User;
use Wisdom\Repositories\LiveClassRepository;
use Wisdom\Repositories\SubjectRepository;
use Wisdom\Services\LiveClassService;

$admin = Guard::requirePermission('exam.manage');
Guard::requirePasswordResetHandled();

$liveService = App::get(LiveClassService::class);
$repo        = App::get(LiveClassRepository::class);
$subjectRepo = App::get(SubjectRepository::class);

$active    = 'admin-live-classes';
$pageTitle = 'Live classes';
$pageDesc  = 'Schedule and manage live class session links.';

/* ---- POST ---- */
if (Request::isPost()) {
    if (!Csrf::verifyRequest()) {
        Session::flash('error', 'Your session expired. Please try again.');
        redirect('admin-live-classes.php');
    }

    $action = Request::post('form_action');

    try {
        if ($action === 'create_live_class') {
            $liveService->create(
                $admin,
                Request::post('level'),
                Request::post('subject_name'),
                Request::post('link'),
                Request::post('scheduled_at'),
            );
            Session::flash('success', 'Live class scheduled and shared with the target students.');
        } elseif ($action === 'delete_live_class') {
            $liveService->delete($admin, Request::intPost('class_id'));
            Session::flash('success', 'Live class removed.');
        } else {
            throw new AppException('Unknown action.');
        }
    } catch (AppException $e) {
        Session::flash('error', $e->getMessage());
    }

    redirect('admin-live-classes.php');
}

/* ---- Load ---- */
$catalogue = $subjectRepo->catalogue();
$classes   = $repo->all(200);
?>
<!doctype html>
<html lang="en">
<head>
<?php require __DIR__ . '/partials/head.php'; ?>
</head>
<body>

<div class="shell">
    <?php require __DIR__ . '/partials/nav.php'; ?>
    <main class="shell__main page-fade">
        <?php require __DIR__ . '/partials/notice.php'; ?>
        <?php require __DIR__ . '/partials/admin_flash.php'; ?>

        <header style="margin-bottom:var(--s-8)">
            <div class="eyebrow">Learning</div>
            <h1 style="margin:6px 0 4px">Live classes</h1>
            <p class="text-muted" style="margin:0">
                Schedule a session link for one programme. Students from other programmes never see it.
            </p>
        </header>

        <section class="card" style="margin-bottom:var(--s-8);max-width:820px">
            <div class="card__head">
                <div>
                    <div class="eyebrow">New session</div>
                    <h2 class="card__title" style="margin-top:6px">Schedule a live class</h2>
                    <p class="card__hint">Students only see sessions aimed at <strong>their own programme</strong> and matching one of their registered subjects.</p>
                </div>
            </div>

            <form method="post" novalidate>
                <?= csrf_field() ?>
                <input type="hidden" name="form_action" value="create_live_class">

                <div class="field" style="margin-bottom:var(--s-4)">
                    <label for="level">Programme</label>
                    <select id="level" name="level" required>
                        <?php foreach (User::LEVELS as $lvl): ?>
                            <option value="<?= e($lvl) ?>"><?= e($lvl) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted" style="font-size:12px">Only students on this programme will see the class.</small>
                </div>

                <div class="field" style="margin-bottom:var(--s-4)">
                    <label for="subject_name">Subject</label>
                    <select id="subject_name" name="subject_name" required>
                        <!-- Populated by JavaScript from the catalogue below -->
                    </select>
                </div>

                <div class="field" style="margin-bottom:var(--s-4)">
                    <label for="scheduled_at">Date and time</label>
                    <input id="scheduled_at" name="scheduled_at" type="datetime-local" required
                           value="<?= e(date('Y-m-d\TH:i', time() + 86400)) ?>">
                </div>

                <div class="field" style="margin-bottom:var(--s-4)">
                    <label for="link">Session link</label>
                    <input id="link" name="link" type="url" required maxlength="500"
                           placeholder="https://meet.example.com/abc-xyz">
                    <small class="text-muted" style="font-size:12px">Full URL including <code>https://</code>. Zoom, Google Meet, Jitsi, Teams — all fine.</small>
                </div>

                <button type="submit" class="btn btn--gold" style="margin-top:var(--s-3)">Schedule session</button>
            </form>
        </section>

        <section class="card">
            <div class="card__head">
                <div>
                    <div class="eyebrow">Existing</div>
                    <h2 class="card__title" style="margin-top:6px">Recent sessions</h2>
                    <p class="card__hint"><?= count($classes) ?> session<?= count($classes) === 1 ? '' : 's' ?> on file.</p>
                </div>
            </div>

            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Programme</th>
                            <th>Subject</th>
                            <th>Scheduled</th>
                            <th>Link</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($classes === []): ?>
                        <tr><td colspan="6" class="text-muted">No live classes scheduled yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($classes as $c): ?>
                            <?php
                                $link = (string) ($c['link'] ?? '');
                                $validLink = filter_var($link, FILTER_VALIDATE_URL)
                                          && preg_match('#^https?://#i', $link) === 1;
                            ?>
                            <tr>
                                <td class="is-tight">
                                    <span class="badge badge--plain badge--navy"><?= e((string) ($c['level'] ?? '—')) ?></span>
                                </td>
                                <td class="is-name"><?= e((string) ($c['subject_name'] ?? '—')) ?></td>
                                <td class="is-tight">
                                    <?= e(date('D, j M Y · H:i', strtotime((string) ($c['scheduled_at'] ?? 'now')))) ?>
                                </td>
                                <td>
                                    <?php if ($validLink): ?>
                                        <a href="<?= e($link) ?>" target="_blank" rel="noopener noreferrer">Open link</a>
                                    <?php else: ?>
                                        <span class="text-muted">Invalid</span>
                                    <?php endif; ?>
                                </td>
                                <td class="is-tight"><?= e((string) ($c['created_at'] ?? '—')) ?></td>
                                <td>
                                    <form method="post"
                                          data-confirm-modal
                                          data-modal-title="Delete this live class?"
                                          data-modal-body="Students will no longer see this session. This cannot be undone."
                                          data-modal-confirm="Delete session"
                                          data-modal-danger="1">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="form_action" value="delete_live_class">
                                        <input type="hidden" name="class_id" value="<?= (int) $c['id'] ?>">
                                        <button type="submit" class="btn btn--danger btn--sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<script src="assets/js/wisdom-ui.js" nonce="<?= e(nonce()) ?>" defer></script>
<script nonce="<?= e(nonce()) ?>">
(function () {
    const catalogue = <?= json_encode($catalogue, JSON_THROW_ON_ERROR) ?>;
    const levelSelect = document.getElementById('level');
    const subjectSelect = document.getElementById('subject_name');
    if (!levelSelect || !subjectSelect) return;

    function renderSubjects() {
        subjectSelect.replaceChildren();
        const subjects = catalogue[levelSelect.value] || [];
        subjects.forEach(function (subject) {
            const opt = document.createElement('option');
            opt.value = subject;
            opt.textContent = subject;
            subjectSelect.appendChild(opt);
        });
        if (subjects.length === 0) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'No subjects for this programme';
            opt.disabled = true;
            opt.selected = true;
            subjectSelect.appendChild(opt);
        }
    }

    levelSelect.addEventListener('change', renderSubjects);
    renderSubjects();
})();
</script>
</body>
</html>

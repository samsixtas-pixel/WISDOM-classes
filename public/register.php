<?php
declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

use Wisdom\Core\App;
use Wisdom\Core\AppException;
use Wisdom\Core\Csrf;
use Wisdom\Core\Guard;
use Wisdom\Core\Request;
use Wisdom\Models\User;
use Wisdom\Repositories\SubjectRepository;
use Wisdom\Services\RegistrationService;

if (Request::isPost()) {
    Guard::throttle('register', 5, 300);
}

if (Guard::user() !== null) {
    redirect('dashboard.php');
}

$registration = App::get(RegistrationService::class);
$subjectRepo = App::get(SubjectRepository::class);
$catalogue = $subjectRepo->catalogue();
$pageTitle = 'Create account';

$error = '';
$name = '';
$email = '';
$sex = '';
$level = '';
$selectedSubjects = [];

if (Request::isPost()) {
    $name = Request::post('name');
    $email = Request::post('email');
    $sex = Request::post('sex');
    $level = Request::post('level');
    $selectedSubjects = array_values(array_intersect($catalogue[$level] ?? [], Request::postList('subjects')));
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');

    if (!Csrf::verifyRequest()) {
        $error = 'Your session expired. Please try again.';
    } else {
        $validator = $registration->validator([
            'name' => $name, 'email' => $email, 'sex' => $sex, 'level' => $level,
            'password' => $password, 'password_confirmation' => $confirmation,
        ]);

        if (!$validator->passes()) {
            $fieldErrors = $validator->errors();
            $error = (string) reset($fieldErrors);
        } else {
            try {
                $registration->register($name, $email, $sex, $level, $selectedSubjects, $password);
                redirect('login.php?registered=1');
            } catch (AppException $exception) {
                $error = $exception->getMessage();
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head><?php require __DIR__ . '/partials/head.php'; ?></head>
<body class="auth-page">
<main class="auth-card">
    <div class="auth-brand">
        <p class="auth-heading-small">WISDOM BLENDED CLASSES</p>
        <h1 class="auth-heading-large">Create account</h1>
    </div>
    <p class="auth-brand__lead">Set up your learner profile to get started.</p>

<?php if ($error !== ''): ?><div class="alert alert--error" role="alert"><?= e($error) ?></div><?php endif; ?>

<form method="post" action="register.php" novalidate>
<?= csrf_field() ?>

<label for="name">Full name</label>
<input id="name" name="name" value="<?= e($name) ?>" autocomplete="name" required>

<label for="email">Email</label>
<input id="email" name="email" type="email" value="<?= e($email) ?>" autocomplete="email" required>

<label for="sex">Sex</label>
<select id="sex" name="sex" required>
    <option value="">Select sex</option>
    <?php foreach (User::SEXES as $option): ?>
        <option value="<?= e($option) ?>" <?= $sex === $option ? 'selected' : '' ?>><?= e(ucfirst($option)) ?></option>
    <?php endforeach; ?>
</select>

<label for="level">Programme</label>
<select id="level" name="level" required>
    <option value="">Select programme</option>
    <?php foreach (User::LEVELS as $option): ?>
        <option value="<?= e($option) ?>" <?= $level === $option ? 'selected' : '' ?>><?= e($option) ?></option>
    <?php endforeach; ?>
</select>

<fieldset class="subjects-fieldset">
    <legend>Subjects</legend>
    <div id="subjects" class="subjects-list" role="group" aria-describedby="subjects-help"></div>
    <small id="subjects-help">Tick one or more subjects for your programme.</small>
</fieldset>

<label for="password">Password</label>
<div class="pw-wrap">
    <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" required>
    <button type="button" class="pw-toggle" data-pw-target="password" aria-label="Show password" aria-pressed="false">
        <svg class="pw-icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
        <svg class="pw-icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" style="display:none"><path d="M3 3l18 18"/><path d="M10.6 6.1A9.8 9.8 0 0 1 12 6c6 0 10 6 10 6a17 17 0 0 1-3.4 4.2"/><path d="M6.6 6.6C3.8 8.4 2 12 2 12s4 6 10 6a9.7 9.7 0 0 0 4.6-1.1"/></svg>
    </button>
</div>

<label for="password_confirmation">Confirm password</label>
<div class="pw-wrap">
    <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" required>
    <button type="button" class="pw-toggle" data-pw-target="password_confirmation" aria-label="Show password" aria-pressed="false">
        <svg class="pw-icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
        <svg class="pw-icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" style="display:none"><path d="M3 3l18 18"/><path d="M10.6 6.1A9.8 9.8 0 0 1 12 6c6 0 10 6 10 6a17 17 0 0 1-3.4 4.2"/><path d="M6.6 6.6C3.8 8.4 2 12 2 12s4 6 10 6a9.7 9.7 0 0 0 4.6-1.1"/></svg>
    </button>
</div>

<button type="submit" class="btn btn--gold">Create account</button>
</form>
<div class="auth-links">Already registered? <a href="login.php">Sign in</a></div>

<script nonce="<?= e(nonce()) ?>">
/* subjects renderer — unchanged */
const subjects = <?= json_encode($catalogue, JSON_THROW_ON_ERROR) ?>;
const programme = document.querySelector('#level');
const subjectList = document.querySelector('#subjects');
const selectedSubjects = <?= json_encode($selectedSubjects, JSON_THROW_ON_ERROR) ?>;
function renderSubjects() {
    subjectList.replaceChildren();
    (subjects[programme.value] || []).forEach((subject, index) => {
        const id = 'subject-' + index;
        const label = document.createElement('label');
        label.className = 'subject-option';
        label.htmlFor = id;
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'subjects[]';
        checkbox.id = id;
        checkbox.value = subject;
        checkbox.checked = selectedSubjects.includes(subject);
        label.append(checkbox, document.createTextNode(subject));
        subjectList.append(label);
    });
}
programme.addEventListener('change', renderSubjects);
renderSubjects();
</script>
</main>
<script src="assets/js/wisdom-ui.js" nonce="<?= e(nonce()) ?>" defer></script>
</body>
</html>

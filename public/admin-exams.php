<?php
declare(strict_types=1);
require __DIR__ . '/../config/bootstrap.php';
use Wisdom\Core\App; use Wisdom\Core\AppException; use Wisdom\Core\Csrf; use Wisdom\Core\Guard; use Wisdom\Core\ListQuery; use Wisdom\Core\Request; use Wisdom\Core\Session; use Wisdom\Models\Exam; use Wisdom\Repositories\ExamRepository; use Wisdom\Services\ExamService;
$admin=Guard::requirePermission('exam.manage'); Guard::requirePasswordResetHandled(); $service=App::get(ExamService::class); $repo=App::get(ExamRepository::class); $active='admin-exams'; $pageTitle='Examinations';
if(Request::isPost()){
    Guard::throttle('admin.action',60,60);
    if(!Csrf::verifyRequest()){Session::flash('error','Your session expired. Please try again.');redirect('admin-exams.php');}
    $action = Request::post('form_action');
    try {
        if ($action === 'save_exams_batch') {
            $userId = Request::intPost('user_id');
            $subjects = $_POST['subject_name'] ?? [];
            $codes = $_POST['subject_code'] ?? [];
            $numbers = $_POST['exam_number'] ?? [];
            $weights = $_POST['weight'] ?? [];
            $marks = $_POST['result'] ?? [];
            $grades = $_POST['grade'] ?? [];
            $outcomes = $_POST['outcome'] ?? [];
            $rows = [];
            $count = max(count((array) $subjects), count((array) $codes), count((array) $numbers));
            for ($i = 0; $i < $count; $i++) {
                $rows[] = [
                    'subject_name' => (string) ($subjects[$i] ?? ''),
                    'subject_code' => (string) ($codes[$i] ?? ''),
                    'exam_number' => (string) ($numbers[$i] ?? ''),
                    'weight' => $weights[$i] ?? '100',
                    'result' => $marks[$i] ?? null,
                    'grade' => (string) ($grades[$i] ?? ''),
                    'outcome' => (string) ($outcomes[$i] ?? ''),
                ];
            }
            $saved = $service->recordMany($admin, $userId, $rows);
            Session::flash('success', "Saved {$saved} exam record(s).");
        } else {
            throw new AppException('Unknown action.');
        }
    } catch (AppException $e) {
        Session::flash('error', $e->getMessage());
    }
    redirect('admin-exams.php');
}
$subjectRepo = App::get(\Wisdom\Repositories\SubjectRepository::class);
$allSubjects = [];
foreach ($subjectRepo->catalogue() as $level => $list) {
    foreach ($list as $name) {
        $allSubjects[] = ['name' => $name, 'level' => $level];
    }
}
$q=ListQuery::fromRequest(['id','user','subject_name','subject_code','result','status'],'id',25);$page=$repo->paginateWithStudent($q);
?><!doctype html><html lang="en"><head><?php require __DIR__.'/partials/head.php'; ?></head><body><div class="shell"><?php require __DIR__.'/partials/nav.php'; ?><main class="shell__main page-fade"><?php require __DIR__.'/partials/notice.php'; ?><?php require __DIR__.'/partials/admin_flash.php'; ?><header style="margin-bottom:var(--s-8)"><div class="eyebrow">Examinations</div><h1>Enter results</h1><p class="text-muted">Search for a student, select a subject, and save. Records are listed below.</p></header>
<section class="card" style="margin-bottom:var(--s-8)"><div class="card__head"><div><div class="eyebrow">Examinations</div><h2 class="card__title" style="margin-top:6px">Record exam results</h2><p class="card__hint">Pick a student, then fill one row per subject. All rows are saved together.</p></div></div><form method="post" id="batch-exam-form" novalidate><?= csrf_field() ?><input type="hidden" name="form_action" value="save_exams_batch"><div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:var(--s-4)"><div class="field" style="grid-column:1/-1"><label for="student-query">Student</label><div class="ac-wrap" id="exam-student" data-endpoint="admin_suggest.php" data-extra='{"type":"student"}'><input id="student-query" class="ac-input" type="text" autocomplete="off" placeholder="Type a student name" required><input type="hidden" name="user_id" required><button type="button" class="ac-clear" aria-label="Clear student">×</button><ul class="ac-list" role="listbox" aria-label="Student suggestions"></ul></div></div></div><div class="table-wrap" style="margin-bottom:var(--s-4)"><table class="table" id="exam-rows-table"><thead><tr><th>Subject</th><th>Code</th><th>Exam no.</th><th>Weight</th><th>Marks</th><th>Grade</th><th>Status</th><th></th></tr></thead><tbody id="exam-rows-body"></tbody></table></div><input type="hidden" id="row-index" value="0"><div class="row gap-3" style="flex-wrap:wrap"><button type="button" class="btn btn--ghost" id="add-exam-row">+ Add another subject</button><button type="submit" class="btn btn--gold">Save all exams</button></div><datalist id="subject-suggestions"><?php foreach ($allSubjects as $s): ?><option value="<?= e($s['name']) ?>" data-level="<?= e($s['level']) ?>"></option><?php endforeach; ?></datalist></form></section>
<section class="card"><div class="card__head"><h2 class="card__title">Exam records</h2><span class="text-muted"><?= (int)$page['total'] ?> total</span></div><div class="table-wrap"><table class="table"><thead><tr><?= sortable_th('Student','user',$q) ?><?= sortable_th('Code','subject_code',$q) ?><th>Exam no.</th><?= sortable_th('Subject','subject_name',$q) ?><th>Weight</th><?= sortable_th('Result','result',$q) ?><th>Grade</th><th>Outcome</th></tr></thead><tbody><?php if($page['rows']===[]): ?><tr><td colspan="8" class="text-muted">No exam records match those filters.</td></tr><?php else: foreach($page['rows'] as $x): ?><tr><td><?= e((string)$x['name']) ?></td><td><?= e((string)$x['subject_code']) ?></td><td><?= e((string)$x['exam_number']) ?></td><td><?= e((string)$x['subject_name']) ?></td><td><?= e((string)$x['weight']) ?></td><td><?= $x['result']===null?'—':e((string)$x['result']) ?></td><td><?= $x['grade']===null?'—':e((string)$x['grade']) ?></td><td><?php if (($x['outcome'] ?? null) === 'pass'): ?><span class="badge badge--on">Pass</span><?php elseif (($x['outcome'] ?? null) === 'fail'): ?><span class="badge badge--off">Fail</span><?php else: ?><span class="text-muted">—</span><?php endif; ?></td></tr><?php endforeach; endif; ?></tbody></table></div><?= render_pager($q,(int)$page['total']) ?></section>
</main></div><script src="assets/js/wisdom-autocomplete.js" nonce="<?= e(nonce()) ?>" defer></script><script src="assets/js/wisdom-ui.js" nonce="<?= e(nonce()) ?>" defer></script><script nonce="<?= e(nonce()) ?>">document.addEventListener('DOMContentLoaded',()=>{for(const [id,key] of [['exam-student','user_id'],['exam-subject','subject_name']]){const wrap=document.getElementById(id),hidden=wrap.querySelector('input[type=hidden]');wrap.addEventListener('ac:selected',e=>hidden.value=e.detail.value);wrap.addEventListener('ac:cleared',()=>hidden.value='');}});</script>
<script nonce="<?= e(nonce()) ?>">(function(){'use strict';const tbody=document.getElementById('exam-rows-body');const addBtn=document.getElementById('add-exam-row');const indexInput=document.getElementById('row-index');if(!tbody||!addBtn)return;function newRowHtml(i){return `
            <td><input name="subject_name[]" list="subject-suggestions" placeholder="Start typing…" autocomplete="off" required></td>
            <td><input name="subject_code[]" maxlength="30" required></td>
            <td><input name="exam_number[]" maxlength="50" required></td>
            <td><input name="weight[]" type="text" inputmode="decimal" value="100" pattern="[0-9]*\.?[0-9]*" required></td>
            <td><input name="result[]" type="text" inputmode="decimal" pattern="[0-9]*\.?[0-9]*"></td>
            <td><input name="grade[]" maxlength="5" placeholder="A / B+"></td>
            <td>
                <select name="outcome[]" required>
                    <option value="">—</option>
                    <option value="pass">Pass</option>
                    <option value="fail">Fail</option>
                </select>
            </td>
            <td style="text-align:center">
                <button type="button" class="remove-row" aria-label="Remove row" style="border:0;background:transparent;color:var(--danger);font-size:20px;cursor:pointer;line-height:1">×</button>
            </td>
        `;}function addRow(){const i=parseInt(indexInput.value,10)||0;const tr=document.createElement('tr');tr.innerHTML=newRowHtml(i);tbody.appendChild(tr);indexInput.value=i+1;const first=tr.querySelector('input');if(first)first.focus();}addBtn.addEventListener('click',addRow);tbody.addEventListener('click',function(e){const btn=e.target.closest('.remove-row');if(!btn)return;const rows=tbody.querySelectorAll('tr');if(rows.length<=1){alert('At least one exam row is required.');return;}btn.closest('tr').remove();});for(let i=0;i<5;i++)addRow();})();</script><script nonce="<?= e(nonce()) ?>">(function(){'use strict';const datalist=document.getElementById('subject-suggestions');const studentWrap=document.getElementById('exam-student');if(!datalist||!studentWrap)return;const allOptions=Array.from(datalist.options).map(function(option){return {value:option.value,level:(option.getAttribute('data-level')||'')};});function rebuildForLevel(level){datalist.innerHTML='';allOptions.filter(function(option){return !level || option.level===level;}).forEach(function(option){const opt=document.createElement('option');opt.value=option.value;opt.setAttribute('data-level',option.level);datalist.appendChild(opt);});}studentWrap.addEventListener('ac:selected',function(event){const meta=(event.detail&&event.detail.meta)?String(event.detail.meta):'';const level=(meta.split('·')[0]||'').trim();rebuildForLevel(level);});studentWrap.addEventListener('ac:cleared',function(){rebuildForLevel('');});})();</script></body></html>

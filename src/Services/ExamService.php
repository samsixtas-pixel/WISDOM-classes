<?php
declare(strict_types=1);

namespace Wisdom\Services;

use Wisdom\Core\AppException;
use Wisdom\Core\Validator;
use Wisdom\Models\Exam;
use Wisdom\Models\User;
use Wisdom\Repositories\AuditLogRepository;
use Wisdom\Repositories\ExamRepository;
use Wisdom\Repositories\UserRepository;

/** Administrator management of exam records; student-facing read access. */
final class ExamService
{
    public function __construct(
        private ExamRepository $exams,
        private UserRepository $users,
        private AuditLogRepository $audit,
        private \Wisdom\Core\Database $db,
    ) {
    }

    /** @param array<string,mixed> $data */
    public function validator(array $data): Validator
    {
        return (new Validator($data))
            ->required('user_id', 'Student')
            ->required('subject_code', 'Subject code')->length('subject_code', 'Subject code', 1, 30)
            ->required('exam_number', 'Exam number')->length('exam_number', 'Exam number', 1, 50)
            ->required('subject_name', 'Subject name')->length('subject_name', 'Subject name', 1, 255)
            ->numeric('weight', 'Weight', 0, 1000)
            ->numeric('result', 'Marks', 0, 100)
            ->in('outcome', 'Result status', Exam::OUTCOMES);
    }

    /**
     * @param string $outcome One of Exam::OUTCOMES ('pass' or 'fail').
     * @throws AppException
     */
    public function record(
        User $admin,
        int $userId,
        string $subjectCode,
        string $examNumber,
        string $subjectName,
        float $weight,
        ?float $result,
        ?string $grade,
        string $outcome,
    ): void {
        if ($this->users->find($userId) === null) {
            throw new AppException('Select a valid student.');
        }

        if (!in_array($outcome, Exam::OUTCOMES, true)) {
            throw new AppException('Choose Pass or Fail.');
        }

        // A saved exam is published immediately so the student can see it.
        $id = $this->exams->create(
            $userId,
            $subjectCode,
            $examNumber,
            $subjectName,
            $weight,
            $result,
            $grade,
            'published',
            $outcome,
        );

        $this->audit->record(
            $admin->getId(),
            'exam.recorded',
            "exam #$id for user #$userId, outcome=$outcome"
        );
    }

    /**
     * Record several exam rows for ONE student in a single transaction.
     * Blank rows are skipped. The whole batch is atomic — if any row fails
     * validation, nothing is written.
     *
     * @param list<array{
     *     subject_name:string,
     *     subject_code:string,
     *     exam_number:string,
     *     weight:string|float,
     *     result:?string|float,
     *     grade:string,
     *     outcome:string
     * }> $rows
     * @return int Number of rows saved.
     * @throws AppException
     */
    public function recordMany(User $admin, int $userId, array $rows): int
    {
        if ($this->users->find($userId) === null) {
            throw new AppException('Select a valid student.');
        }
        if ($rows === []) {
            throw new AppException('Add at least one exam row.');
        }

        $clean = [];

        foreach ($rows as $i => $r) {
            $n = $i + 1;

            $code    = trim((string) ($r['subject_code'] ?? ''));
            $name    = trim((string) ($r['subject_name'] ?? ''));
            $num     = trim((string) ($r['exam_number']  ?? ''));
            $outcome = (string) ($r['outcome'] ?? '');

            if ($code === '' && $name === '' && $num === '') {
                continue;
            }

            if ($code === '') {
                throw new AppException("Row {$n}: subject code is required.");
            }
            if ($name === '') {
                throw new AppException("Row {$n}: subject name is required.");
            }
            if ($num === '') {
                throw new AppException("Row {$n}: exam number is required.");
            }
            if (!in_array($outcome, Exam::OUTCOMES, true)) {
                throw new AppException("Row {$n}: choose Pass or Fail.");
            }

            $weight = (float) ($r['weight'] ?? 100);
            if ($weight < 0 || $weight > 1000) {
                throw new AppException("Row {$n}: weight must be between 0 and 1000.");
            }

            $rawResult = $r['result'] ?? null;
            $result = null;
            if ($rawResult !== null && $rawResult !== '') {
                $result = (float) $rawResult;
                if ($result < 0 || $result > 100) {
                    throw new AppException("Row {$n}: marks must be between 0 and 100.");
                }
            }

            $grade = trim((string) ($r['grade'] ?? ''));

            $clean[] = [
                'subject_code' => $code,
                'subject_name' => $name,
                'exam_number'  => $num,
                'weight'       => $weight,
                'result'       => $result,
                'grade'        => $grade === '' ? null : $grade,
                'outcome'      => $outcome,
            ];
        }

        if ($clean === []) {
            throw new AppException('Add at least one complete exam row.');
        }

        $saved = 0;

        $this->db->transaction(function () use ($clean, $userId, &$saved): void {
            foreach ($clean as $row) {
                $this->exams->create(
                    $userId,
                    $row['subject_code'],
                    $row['exam_number'],
                    $row['subject_name'],
                    $row['weight'],
                    $row['result'],
                    $row['grade'],
                    'published',
                    $row['outcome'],
                );
                $saved++;
            }
        });

        $this->audit->record(
            $admin->getId(),
            'exam.recorded_batch',
            "{$saved} exam(s) for user #{$userId}"
        );

        return $saved;
    }

    /** Whether the student has an approved examination-fee payment (gate for viewing results). */
    public function canViewResults(User $user, \Wisdom\Repositories\PaymentRepository $payments): bool
    {
        return $payments->hasApprovedFor($user->getId(), 'examination');
    }

    /** @return list<Exam> */
    public function forUser(User $user): array
    {
        return $this->exams->forUser($user->getId());
    }

    /** @return list<array<string,mixed>> */
    public function allWithStudent(): array
    {
        return $this->exams->allWithStudent();
    }
}

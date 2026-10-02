<?php
declare(strict_types=1);

namespace Wisdom\Repositories;

use Wisdom\Core\Database;
use Wisdom\Models\LiveClass;

final class LiveClassRepository
{
    public function __construct(private Database $db)
    {
    }

    public function create(string $level, string $subjectName, string $link, string $scheduledAt, ?int $createdBy): int
    {
        return $this->db->insert(
            'INSERT INTO live_classes (level, subject_name, link, scheduled_at, created_by) VALUES (?, ?, ?, ?, ?)',
            [$level, $subjectName, $link, $scheduledAt, $createdBy]
        );
    }

    /** @return list<array<string,mixed>> Admin table view. */
    public function all(int $limit = 200): array
    {
        return $this->db->fetchAll(
            'SELECT live_classes.*, users.name AS creator_name FROM live_classes '
            . 'LEFT JOIN users ON users.id = live_classes.created_by '
            . 'ORDER BY live_classes.scheduled_at DESC LIMIT ?',
            [$limit]
        );
    }

    /**
     * Live classes visible to a student, filtered by level AND subject.
     * A student only sees a class aimed at their own level.
     *
     * @param list<string> $subjectNames
     * @return list<LiveClass>
     */
    public function forSubjects(array $subjectNames, ?string $level = null): array
    {
        $subjectNames = array_values(array_filter($subjectNames, 'is_string'));
        if ($subjectNames === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($subjectNames), '?'));
        $params       = $subjectNames;

        $where = 'subject_name IN (' . $placeholders . ')';

        if ($level !== null && $level !== '') {
            $where   .= ' AND level = ?';
            $params[] = $level;
        }

        $rows = $this->db->fetchAll(
            'SELECT * FROM live_classes WHERE ' . $where
            . ' ORDER BY scheduled_at DESC',
            $params
        );

        return array_map(static fn (array $row): LiveClass => LiveClass::fromRow($row), $rows);
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM live_classes WHERE id = ?', [$id]) > 0;
    }

    public function count(): int
    {
        return (int) $this->db->fetchValue('SELECT COUNT(*) FROM live_classes');
    }
}
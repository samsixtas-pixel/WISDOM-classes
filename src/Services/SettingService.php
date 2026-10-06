<?php
declare(strict_types=1);

namespace Wisdom\Services;

use Wisdom\Core\Cache;
use Wisdom\Models\User;
use Wisdom\Repositories\AuditLogRepository;
use Wisdom\Repositories\SettingRepository;

final class SettingService
{
    public const KEY_BANK_NUMBER = 'payment.bank_number';
    public const KEY_LIPA_NUMBER = 'payment.lipa_number';
    private const CACHE_TTL_SECONDS = 300;

    public function __construct(
        private SettingRepository $settings,
        private AuditLogRepository $audit,
        private Cache $cache,
    ) {
    }

    public function bankNumber(): string
    {
        return $this->get(self::KEY_BANK_NUMBER);
    }

    public function lipaNumber(): string
    {
        return $this->get(self::KEY_LIPA_NUMBER);
    }

    /** @param array<string,string> $values */
    public function update(User $admin, array $values): void
    {
        foreach ($values as $key => $value) {
            $clean = trim($value);
            $this->settings->set($key, $clean);
            $this->cache->set('settings.' . $key, $clean, self::CACHE_TTL_SECONDS);
        }
        $this->audit->record($admin->getId(), 'settings.updated', implode(',', array_keys($values)));
    }

    private function get(string $key): string
    {
        $cacheKey = 'settings.' . $key;
        $value = $this->cache->get($cacheKey, Cache::MISSING);
        if ($value !== Cache::MISSING) {
            return (string) $value;
        }

        $value = $this->settings->get($key, '');
        $this->cache->set($cacheKey, $value, self::CACHE_TTL_SECONDS);

        return (string) $value;
    }
}
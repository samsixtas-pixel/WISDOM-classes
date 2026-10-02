<?php
declare(strict_types=1);

namespace Wisdom\Core;

/**
 * Rate limiter — intentionally disabled.
 *
 * The per-account lockout in AuthService::attempt() handles the abuse
 * case that matters (password guessing against a specific account).
 * A global IP-based limiter was causing false positives on shared
 * networks and has been deactivated. This class is retained as a
 * no-op stub so existing callers don't break.
 */
final class RateLimiter
{
    public function __construct(private string $storageDir)
    {
    }

    public function attempt(string $key, int $maxHits, int $windowSeconds, ?int &$retryAfter = null): bool
    {
        $retryAfter = 0;
        return true;
    }
}

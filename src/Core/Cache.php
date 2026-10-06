<?php
declare(strict_types=1);

namespace Wisdom\Core;

final class Cache
{
    public const MISSING = "\0WISDOM_CACHE_MISSING\0";

    private string $directory;
    private int $defaultTtl;

    public function __construct(string $directory, int $defaultTtl = 300)
    {
        $this->directory = rtrim($directory, '/\\');
        $this->defaultTtl = max(1, $defaultTtl);

        if (!is_dir($this->directory) && !@mkdir($this->directory, 0775, true) && !is_dir($this->directory)) {
            throw new \RuntimeException('Unable to create cache directory: ' . $this->directory);
        }
    }

    public function get(string $key, mixed $default = self::MISSING): mixed
    {
        $normalizedKey = $this->normalizeKey($key);

        if (function_exists('apcu_fetch')) {
            $found = false;
            $value = @apcu_fetch($normalizedKey, $found);
            if ($found) {
                return $value;
            }
        }

        $file = $this->filePath($normalizedKey);
        if (!is_file($file)) {
            return $default;
        }

        $payload = @file_get_contents($file);
        if ($payload === false) {
            return $default;
        }

        $decoded = @json_decode($payload, true);
        if (!is_array($decoded) || !isset($decoded['expires_at'], $decoded['value'])) {
            @unlink($file);
            return $default;
        }

        if ((int) $decoded['expires_at'] < time()) {
            @unlink($file);
            return $default;
        }

        return $decoded['value'];
    }

    public function set(string $key, mixed $value, int $ttl = 0): void
    {
        $ttl = max(1, $ttl === 0 ? $this->defaultTtl : $ttl);
        $normalizedKey = $this->normalizeKey($key);

        if (function_exists('apcu_store')) {
            @apcu_store($normalizedKey, $value, $ttl);
        }

        $file = $this->filePath($normalizedKey);
        $payload = json_encode([
            'expires_at' => time() + $ttl,
            'value' => $value,
        ], JSON_THROW_ON_ERROR);
        @file_put_contents($file, $payload);
    }

    public function remember(string $key, int $ttl, callable $resolver): mixed
    {
        $value = $this->get($key, self::MISSING);
        if ($value !== self::MISSING) {
            return $value;
        }

        $resolved = $resolver();
        $this->set($key, $resolved, $ttl);

        return $resolved;
    }

    public function delete(string $key): bool
    {
        $normalizedKey = $this->normalizeKey($key);
        $deleted = true;

        if (function_exists('apcu_delete')) {
            $deleted = (bool) @apcu_delete($normalizedKey);
        }

        $file = $this->filePath($normalizedKey);
        if (is_file($file)) {
            $deleted = @unlink($file) || $deleted;
        }

        return $deleted;
    }

    public function has(string $key): bool
    {
        return $this->get($key, self::MISSING) !== self::MISSING;
    }

    public function clear(): void
    {
        if (function_exists('apcu_clear_cache')) {
            @apcu_clear_cache();
        }

        foreach (glob($this->directory . DIRECTORY_SEPARATOR . '*') ?: [] as $path) {
            @unlink($path);
        }
    }

    private function normalizeKey(string $key): string
    {
        return 'wisdom:' . $key;
    }

    private function filePath(string $key): string
    {
        return $this->directory . DIRECTORY_SEPARATOR . hash('sha256', $key) . '.json';
    }
}
